<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Configuracion;
use App\Models\Pago;
use App\Models\Plan;
use App\Models\Suscripcion;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Muestra el Panel de Administración general con todas las métricas y registros reales.
     */
    public function index(): View
    {
        $pagos = Pago::with(['suscripcion.usuario', 'suscripcion.plan'])
            ->orderByRaw("CASE WHEN estado = 'pendiente' THEN 1 ELSE 2 END")
            ->orderBy('created_at', 'desc')
            ->get();

        $pagosPendientesCount = Pago::where('estado', 'pendiente')->count();

        $pacientes = Usuario::where('rol', 'paciente')
            ->with(['suscripciones.plan', 'citas', 'historiasMedicas'])
            ->orderBy('created_at', 'desc')
            ->get();

        $citas = Cita::with('usuario')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'asc')
            ->get();

        $planes = Plan::all();

        $configuraciones = Configuracion::pluck('valor', 'clave')->toArray();

        return view('admin-layout', compact(
            'pagos',
            'pagosPendientesCount',
            'pacientes',
            'citas',
            'planes',
            'configuraciones'
        ));
    }

    /**
     * Alterna el estado del paciente / suscripción entre 'activa' y 'suspendida' (Bloqueo reactivo).
     */
    public function togglePaciente(Usuario $usuario): RedirectResponse
    {
        $suscripcion = $usuario->suscripciones()->latest()->first();

        if ($suscripcion) {
            $nuevoEstado = $suscripcion->estado === 'activa' ? 'suspendida' : 'activa';
            $suscripcion->update(['estado' => $nuevoEstado]);
            $mensaje = $nuevoEstado === 'activa'
                ? "Paciente {$usuario->nombre} {$usuario->apellido} ha sido activado."
                : "Paciente {$usuario->nombre} {$usuario->apellido} ha sido bloqueado (no podrá agendar citas).";

            return back()->with('success', $mensaje);
        }

        return back()->with('error', 'El paciente no posee una membresía registrada.');
    }

    /**
     * Extiende la membresía del paciente sumando consultas o extendiendo vencimiento.
     */
    public function extenderMembresia(Request $request, Usuario $usuario): RedirectResponse
    {
        $request->validate([
            'consultas_extra' => ['required', 'integer', 'min:1', 'max:12'],
            'nueva_fecha_fin' => ['nullable', 'date'],
        ]);

        $suscripcion = $usuario->suscripciones()->latest()->first();

        if ($suscripcion) {
            DB::transaction(function () use ($suscripcion, $request) {
                $suscripcion->increment('consultas_disponibles', (int) $request->input('consultas_extra'));
                if ($request->filled('nueva_fecha_fin')) {
                    $suscripcion->update(['fecha_fin' => $request->input('nueva_fecha_fin')]);
                }
            });

            return back()->with('success', "Membresía extendida con éxito (+{$request->input('consultas_extra')} consultas).");
        }

        return back()->with('error', 'El paciente no posee una suscripción activa.');
    }

    /**
     * Elimina un paciente y sus registros asociados.
     */
    public function destroyPaciente(Usuario $usuario): RedirectResponse
    {
        $nombre = "{$usuario->nombre} {$usuario->apellido}";
        $usuario->delete();

        return back()->with('success', "Paciente {$nombre} eliminado de la base de datos.");
    }
}
