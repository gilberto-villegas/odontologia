<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Suscripcion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class PagoController extends Controller
{
    /**
     * Muestra la vista de pago móvil con tasa oficial BCV.
     */
    public function showPago(Request $request): View
    {
        $suscripcionId = $request->query('suscripcion_id');
        $suscripcion = null;

        if ($suscripcionId) {
            $suscripcion = Suscripcion::with('plan', 'usuario')->find($suscripcionId);
        }

        if (!$suscripcion && auth()->check()) {
            $suscripcion = Suscripcion::with('plan', 'usuario')
                ->where('usuario_id', auth()->id())
                ->latest()
                ->first();
        }

        // Obtener tasa BCV con cache de 12 horas y scraping seguro
        $tasaBcv = Cache::remember('tasa_bcv_oficial', 43200, function () {
            try {
                $response = Http::withoutVerifying()->timeout(5)->get('https://www.bcv.org.ve/');
                if ($response->successful()) {
                    $html = $response->body();
                    if (preg_match('/<div id="dolar"[^>]*>.*?<strong class="strong-tb">([^<]+)<\/strong>/is', $html, $matches)) {
                        $tasaTexto = trim(str_replace(',', '.', str_replace('.', '', $matches[1])));
                        $tasa = (float) $tasaTexto;
                        if ($tasa > 0) return $tasa;
                    }
                }
            } catch (\Throwable $e) {
                // Silenciar error en caso de fallo de red
            }
            return 917.77; // Valor de contingencia oficial
        });

        return view('pago', compact('suscripcion', 'tasaBcv'));
    }

    /**
     * Registra el pago móvil del paciente en estado 'pendiente'.
     */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'suscripcion_id' => ['required', 'exists:suscripciones,id'],
            'banco' => ['required', 'string', 'max:100'],
            'referencia' => ['required', 'string', 'min:4', 'max:20'],
            'monto_bs' => ['required', 'numeric', 'min:0'],
            'monto_usd' => ['required', 'numeric', 'min:0'],
            'fecha_pago' => ['required', 'date'],
        ], [
            'referencia.required' => 'El número de referencia es obligatorio.',
            'banco.required' => 'Debes seleccionar el banco emisor.',
            'monto_bs.required' => 'El monto en Bolívares es obligatorio.',
        ]);

        Pago::create([
            'suscripcion_id' => $datos['suscripcion_id'],
            'banco' => $datos['banco'],
            'referencia' => $datos['referencia'],
            'monto_bs' => $datos['monto_bs'],
            'monto_usd' => $datos['monto_usd'],
            'fecha_pago' => $datos['fecha_pago'],
            'estado' => 'pendiente',
        ]);

        return redirect()->route('pago.exitoso')
            ->with('success', '¡Comprobante enviado! Tu pago está siendo verificado por el equipo de administración.');
    }

    /**
     * Vista de confirmación de pago enviado.
     */
    public function exitoso(): View
    {
        return view('pago-exitoso');
    }

    /**
     * Acción de Administrador: Aprueba el pago y activa la suscripción del paciente.
     */
    public function aprobar(Request $request, $id)
    {
        $pago = Pago::with('suscripcion')->findOrFail($id);

        DB::transaction(function () use ($pago) {
            $pago->update(['estado' => 'aprobado']);

            if ($pago->suscripcion) {
                $pago->suscripcion->update([
                    'estado' => 'activa',
                    'consultas_disponibles' => 6,
                    'fecha_inicio' => now()->toDateString(),
                    'fecha_fin' => now()->addYear()->toDateString(),
                ]);
            }
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'mensaje' => "Pago ref. {$pago->referencia} aprobado correctamente.",
                'estado' => 'Aprobado',
            ]);
        }

        return back()->with('success', "Pago ref. {$pago->referencia} aprobado. La membresía ha sido activada con 6 consultas disponibles.");
    }

    /**
     * Acción de Administrador: Rechaza el pago y suspende la suscripción.
     */
    public function rechazar(Request $request, $id)
    {
        $pago = Pago::with('suscripcion')->findOrFail($id);

        DB::transaction(function () use ($pago) {
            $pago->update(['estado' => 'rechazado']);
            if ($pago->suscripcion) {
                $pago->suscripcion->update(['estado' => 'suspendida']);
            }
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'mensaje' => "Pago ref. {$pago->referencia} rechazado.",
                'estado' => 'Rechazado',
            ]);
        }

        return back()->with('error', "Pago ref. {$pago->referencia} rechazado. La membresía permanece suspendida.");
    }
}
