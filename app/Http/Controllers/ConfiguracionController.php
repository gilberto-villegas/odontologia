<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfiguracionController extends Controller
{
    /**
     * El Administrador actualiza las configuraciones de la landing y los planes de membresía.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'horario_lunes_viernes' => ['nullable', 'string', 'max:255'],
            'horario_sabados' => ['nullable', 'string', 'max:255'],
            'direccion_sede' => ['nullable', 'string', 'max:255'],
            'telefono_contacto' => ['nullable', 'string', 'max:50'],
            'planes' => ['nullable', 'array'],
            'planes.*.precio' => ['required', 'numeric', 'min:0'],
            'planes.*.activo' => ['nullable'],
            'planes.*.caracteristicas' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($request) {
            // 1. Guardar configuraciones clave-valor
            $claves = ['horario_lunes_viernes', 'horario_sabados', 'direccion_sede', 'telefono_contacto'];
            foreach ($claves as $clave) {
                if ($request->has($clave)) {
                    Configuracion::updateOrCreate(
                        ['clave' => $clave],
                        ['valor' => $request->input($clave)]
                    );
                }
            }

            // 2. Guardar estado y precios de los planes
            if ($request->has('planes')) {
                foreach ($request->input('planes') as $planId => $planData) {
                    $plan = Plan::find($planId);
                    if ($plan) {
                        $caracteristicas = isset($planData['caracteristicas'])
                            ? array_filter(array_map('trim', explode("\n", $planData['caracteristicas'])))
                            : $plan->caracteristicas;

                        $plan->update([
                            'precio' => $planData['precio'],
                            'activo' => isset($planData['activo']),
                            'caracteristicas' => $caracteristicas,
                        ]);
                    }
                }
            }
        });

        return back()->with('success', '¡Configuración de la Landing Page y Planes guardada con éxito!');
    }
}
