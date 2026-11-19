<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Suscripcion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CitaController extends Controller
{
    /**
     * Muestra la vista de agendar cita para el paciente.
     */
    public function create(): View
    {
        $suscripcion = Suscripcion::with('plan')
            ->where('usuario_id', auth()->id())
            ->where('estado', 'activa')
            ->latest()
            ->first();

        return view('agendar-cita', compact('suscripcion'));
    }

    /**
     * El paciente agenda una cita médica.
     * Valida cupo de consultas, estado de membresía y disponibilidad horaria.
     */
    public function store(Request $request): RedirectResponse
    {
        $usuario = auth()->user();

        // 1. Validar membresía activa
        $suscripcion = Suscripcion::where('usuario_id', $usuario->id)
            ->where('estado', 'activa')
            ->latest()
            ->first();

        if (!$suscripcion) {
            return back()->with('error', 'No posees una membresía dental activa. Por favor formaliza tu pago primero.');
        }

        // 2. Validar consultas disponibles
        if ($suscripcion->consultas_disponibles <= 0) {
            return back()->with('error', 'Has agotado tus 6 consultas anuales. Contacta a administración para adquirir una extensión.');
        }

        // 3. Validar datos del formulario
        $datos = $request->validate([
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'hora' => ['required', 'string'],
            'motivo' => ['required', 'string', 'max:255'],
            'nombre_doctor' => ['nullable', 'string', 'max:100'],
        ], [
            'fecha.after_or_equal' => 'La fecha de la cita no puede ser en el pasado.',
            'hora.required' => 'Debes seleccionar el horario de atención.',
            'motivo.required' => 'Indica el motivo de tu consulta odontológica.',
        ]);

        // 4. Resolver cuello de botella: Prevenir doble reserva en el mismo horario
        $citaExistente = Cita::where('fecha', $datos['fecha'])
            ->where('hora', $datos['hora'])
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->exists();

        if ($citaExistente) {
            return back()->with('error', 'El horario seleccionado ya se encuentra ocupado para esa fecha. Por favor elige otro horario.')
                ->withInput();
        }

        // 5. Crear la cita y descontar 1 consulta en transacción atómica
        DB::transaction(function () use ($usuario, $suscripcion, $datos) {
            Cita::create([
                'usuario_id' => $usuario->id,
                'nombre_doctor' => $datos['nombre_doctor'] ?? 'Dr. Roberto Méndez',
                'fecha' => $datos['fecha'],
                'hora' => $datos['hora'],
                'motivo' => $datos['motivo'],
                'estado' => 'confirmada',
            ]);

            $suscripcion->decrement('consultas_disponibles');
        });

        return redirect()->route('paciente.dashboard')
            ->with('success', '¡Cita confirmada exitosamente! Se ha descontado 1 consulta de tu membresía anual.');
    }

    /**
     * El Administrador actualiza el estado de la cita.
     * Si el paciente 'no_asistio' o la cita fue 'cancelada', se reintegra la consulta a su membresía.
     */
    public function actualizarEstado(Request $request, Cita $cita): RedirectResponse
    {
        $request->validate([
            'estado' => ['required', 'in:pendiente,confirmada,completada,cancelada,no_asistio'],
        ]);

        $nuevoEstado = $request->input('estado');
        $estadoAnterior = $cita->estado;

        DB::transaction(function () use ($cita, $nuevoEstado, $estadoAnterior) {
            $cita->update(['estado' => $nuevoEstado]);

            // Reembolso de consulta si la cita no se llevó a cabo
            if (in_array($nuevoEstado, ['no_asistio', 'cancelada']) && !in_array($estadoAnterior, ['no_asistio', 'cancelada'])) {
                $suscripcion = Suscripcion::where('usuario_id', $cita->usuario_id)
                    ->where('estado', 'activa')
                    ->latest()
                    ->first();

                if ($suscripcion && $suscripcion->consultas_disponibles < 6) {
                    $suscripcion->increment('consultas_disponibles');
                }
            }
        });

        return back()->with('success', "Estado de la cita actualizado a: {$nuevoEstado}.");
    }
}
