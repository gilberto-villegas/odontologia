<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Muestra la vista de inicio de sesión.
     */
    public function showLogin(): View
    {
        return view('login');
    }

    /**
     * Procesa la autenticación del usuario y redirige según su rol.
     */
    public function login(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt($credenciales, $request->boolean('remember'))) {
            $request->session()->regenerate();

            /** @var Usuario $usuario */
            $usuario = Auth::user();

            if ($usuario->rol === 'administrador') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Bienvenido de nuevo, Dr. ' . $usuario->nombre);
            }

            return redirect()->intended(route('paciente.dashboard'))->with('success', 'Bienvenido a tu portal, ' . $usuario->nombre);
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión activa.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio')->with('success', 'Has cerrado sesión correctamente.');
    }
}
