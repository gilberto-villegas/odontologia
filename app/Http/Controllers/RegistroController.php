<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Suscripcion;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegistroController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function showRegistro(Request $request): View
    {
        $planSlug = $request->query('plan', 'plus');
        $nombrePlan = match (strtolower($planSlug)) {
            'basico' => 'Plan Básico',
            'premium' => 'Plan Premium',
            default => 'Plan Plus',
        };

        $planSeleccionado = Plan::where('nombre', 'like', "%{$nombrePlan}%")
            ->where('activo', true)
            ->first() ?? Plan::where('activo', true)->first();

        $planes = Plan::where('activo', true)->get();

        return view('registro', compact('planSeleccionado', 'planes'));
    }

    /**
     * Registra un nuevo paciente y crea su suscripción en estado 'pendiente'.
     */
    public function register(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'cedula' => ['required', 'string', 'max:20', 'unique:usuarios,cedula'],
            'edad' => ['required', 'integer', 'min:1', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,email'],
            'password' => ['required', 'string', 'min:6'],
            'plan_id' => ['required', 'exists:planes,id'],
            'terminos' => ['accepted'],
        ], [
            'cedula.unique' => 'Esta cédula ya se encuentra registrada en el sistema.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'terminos.accepted' => 'Debes aceptar los Términos y Condiciones para afiliarte.',
            'password.min' => 'La contraseña debe contener al menos 6 caracteres.',
        ]);

        return DB::transaction(function () use ($datos) {
            $usuario = Usuario::create([
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'cedula' => $datos['cedula'],
                'edad' => $datos['edad'],
                'email' => $datos['email'],
                'password' => Hash::make($datos['password']),
                'rol' => 'paciente',
            ]);

            $suscripcion = Suscripcion::create([
                'usuario_id' => $usuario->id,
                'plan_id' => $datos['plan_id'],
                'estado' => 'pendiente',
                'consultas_disponibles' => 6,
                'fecha_inicio' => now()->toDateString(),
                'fecha_fin' => now()->addYear()->toDateString(),
            ]);

            // Iniciar sesión automáticamente
            Auth::login($usuario);

            return redirect()->route('pago', ['suscripcion_id' => $suscripcion->id])
                ->with('success', 'Cuenta creada exitosamente. Por favor registra tu pago móvil para activar la membresía.');
        });
    }
}
