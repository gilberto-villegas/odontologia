<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactoController extends Controller
{
    /**
     * Procesa y valida el formulario de contacto y envía una notificación por correo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|min:2|max:100',
            'email'    => 'required|email|max:150',
            'telefono' => 'required|string|min:7|max:30',
            'mensaje'  => 'required|string|min:10|max:2000',
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Ingresa un correo electrónico válido.',
            'telefono.required' => 'El número telefónico es obligatorio.',
            'mensaje.required'  => 'Por favor, escribe tu consulta o mensaje.',
            'mensaje.min'       => 'El mensaje debe tener al menos 10 caracteres.',
        ]);

        try {
            // Envío con el Mailable oficial hacia la dirección administrativa
            $adminEmail = config('mail.from.address', 'contacto@odontologia.test');
            Mail::to($adminEmail)->send(new ContactoMail($validated));
        } catch (\Throwable $e) {
            // Se registra en logs para no romper la experiencia si el mailer no está configurado en local
            Log::error('Error al enviar correo de contacto: ' . $e->getMessage());
        }

        return redirect()->to(url()->previous() . '#contacto')
            ->with('success', '¡Gracias por contactarnos! Hemos recibido tu mensaje y nos comunicaremos contigo a la brevedad.');
    }
}
