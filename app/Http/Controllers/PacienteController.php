<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HistoriaMedica;
use App\Models\Suscripcion;
use Illuminate\View\View;

class PacienteController extends Controller
{
    /**
     * Muestra el portal / dashboard del paciente.
     */
    public function dashboard(): View
    {
        $usuario = auth()->user();

        $suscripcion = Suscripcion::with('plan')
            ->where('usuario_id', $usuario->id)
            ->latest()
            ->first();

        $citas = Cita::where('usuario_id', $usuario->id)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'asc')
            ->get();

        $proximasCitas = Cita::where('usuario_id', $usuario->id)
            ->where('fecha', '>=', now()->toDateString())
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->orderBy('fecha', 'asc')
            ->get();

        return view('dashboard-paciente', compact('usuario', 'suscripcion', 'citas', 'proximasCitas'));
    }

    /**
     * Muestra la vista de historial clínico del paciente.
     */
    public function historial(): View
    {
        $usuario = auth()->user();

        $suscripcion = Suscripcion::with('plan')
            ->where('usuario_id', $usuario->id)
            ->latest()
            ->first();

        $historias = HistoriaMedica::where('usuario_id', $usuario->id)
            ->orderBy('fecha_registro', 'desc')
            ->get();

        $consultasUsadas = Cita::where('usuario_id', $usuario->id)
            ->whereIn('estado', ['confirmada', 'completada'])
            ->count();

        return view('historial-clinico', compact('usuario', 'suscripcion', 'historias', 'consultasUsadas'));
    }

    /**
     * Muestra los detalles del plan activo del paciente.
     */
    public function miPlan(): View
    {
        $usuario = auth()->user();

        $suscripcion = Suscripcion::with(['plan', 'pagos'])
            ->where('usuario_id', $usuario->id)
            ->latest()
            ->first();

        return view('mi-plan', compact('usuario', 'suscripcion'));
    }
}
