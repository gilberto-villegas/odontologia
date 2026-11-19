<?php

namespace App\Http\Controllers;

use App\Models\HistoriaMedica;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HistoriaMedicaController extends Controller
{
    /**
     * El Administrador/Doctor registra o actualiza una evolución clínica del paciente.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'usuario_id' => ['required', 'exists:usuarios,id'],
            'cita_id' => ['nullable', 'exists:citas,id'],
            'procedimiento_realizado' => ['required', 'string', 'max:255'],
            'alergias' => ['nullable', 'string', 'max:255'],
            'antecedentes' => ['nullable', 'string', 'max:255'],
            'notas' => ['nullable', 'string'],
            'fecha_registro' => ['required', 'date'],
        ], [
            'procedimiento_realizado.required' => 'Debes especificar el procedimiento odontológico efectuado.',
            'fecha_registro.required' => 'La fecha de atención clínica es obligatoria.',
        ]);

        HistoriaMedica::create($datos);

        return back()->with('success', 'Registro clínico añadido satisfactoriamente al historial del paciente.');
    }
}
