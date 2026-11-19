@php
    $tasaBcv = $tasaBcv ?? cache()->remember('bcv_dolar_rate', now()->addMinutes(30), function () {
        try {
            $ch = curl_init('https://www.bcv.org.ve/');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 8);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
            $html = curl_exec($ch);
            curl_close($ch);

            // Extrae el valor directamente del div id="dolar" y su strong
            if ($html && preg_match('/id=[\'"]dolar[\'"].*?<strong[^>]*>(.*?)<\/strong>/is', $html, $matches)) {
                $raw = trim($matches[1]); // ej: 917,77510000
                $clean = floatval(str_replace(',', '.', str_replace('.', '', $raw)));
                if ($clean > 0) {
                    return $clean;
                }
            }
        } catch (\Throwable $e) {
            // Manejo de contingencia
        }
        return 917.7751;
    });
@endphp
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registra tu Pago Móvil | Odontología Especializada</title>
    <meta name="description" content="Paso 2: Registra los datos de tu Pago Móvil con tasa oficial BCV para activar tu membresía.">

    {{-- Fuentes Google: Playfair Display + Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dental-blue': '#1E6F9F',
                        'dental-lilac': '#C8B6E2',
                        'dental-lilac-dark': '#9F7AEA',
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Playfair Display', Georgia, serif; }
        [x-cloak] { display: none !important; }
    </style>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F8FAFC] min-h-screen text-slate-700 antialiased py-10 px-4 sm:px-6 lg:px-8 flex flex-col justify-between"
      x-data="{
          plan: '{{ request('plan', 'plus') }}',
          tasaCambio: {{ $tasaBcv }},
          bancoOrigen: '',
          cedulaTitular: '',
          telefonoEmisor: '',
          fechaPago: new Date().toISOString().split('T')[0],
          referencia: '',
          modalExito: false,
          error: '',
          getMontoUsd() {
              if (this.plan === 'basico') return 15;
              if (this.plan === 'premium') return 40;
              return 25;
          },
          getMontoBs() {
              return (this.getMontoUsd() * this.tasaCambio).toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
          },
          getPlanName() {
              if (this.plan === 'basico') return 'Plan Básico';
              if (this.plan === 'premium') return 'Plan Premium';
              return 'Plan Plus';
          },
          enviarComprobante() {
              if (!this.bancoOrigen || !this.cedulaTitular || !this.telefonoEmisor || !this.fechaPago || !this.referencia) {
                  this.error = 'Por favor completa todos los campos del reporte de pago.';
                  return;
              }
              if (this.referencia.length < 6) {
                  this.error = 'El número de referencia debe tener entre 6 y 8 dígitos.';
                  return;
              }
              this.error = '';
              this.modalExito = true;
          },
          irAExito() {
              window.location.href = '/pago-exitoso?plan=' + encodeURIComponent(this.plan);
          }
      }">

    {{-- Header Minimalista --}}
    <header class="max-w-xl mx-auto w-full mb-8 text-center">
        <a href="/" class="inline-flex items-center gap-3 group focus:outline-none">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#1E6F9F] to-[#9F7AEA] flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                    <path d="M18.8 6.5C18.2 4.4 16.7 3 14.8 3c-1.3 0-2.2.7-2.8 1.4C11.4 3.7 10.5 3 9.2 3 7.3 3 5.8 4.4 5.2 6.5 4.3 9.5 4.9 14.1 6.8 17.5c1.1 2 2.7 3.5 4 3.5.7 0 1.2-.5 1.2-1.5 0-1.2.4-2.5 1-2.5s1 1.3 1 2.5c0 1 .5 1.5 1.2 1.5 1.3 0 2.9-1.5 4-3.5 1.9-3.4 2.5-8 1.6-11z"/>
                </svg>
            </div>
            <div class="text-left">
                <span class="font-serif text-2xl font-bold tracking-tight text-[#1E6F9F]">Odontología <span class="text-[#9F7AEA]">Salud</span></span>
                <span class="block text-[10px] uppercase font-bold tracking-widest text-slate-400 -mt-1">Afiliación Digital</span>
            </div>
        </a>
    </header>

    {{-- Tarjeta Principal Centrada --}}
    <main class="max-w-xl mx-auto w-full">
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-2xl shadow-slate-900/5">
            
            {{-- Encabezado --}}
            <div class="mb-6 text-center">
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#9F7AEA] bg-purple-50 px-3 py-1 rounded-full border border-purple-100 mb-3">
                    Paso 2 de 2: Verificación de Pago
                </span>
                <h1 class="font-serif text-3xl font-bold text-slate-900">
                    Registra tu Pago Móvil
                </h1>
                <p class="text-sm text-slate-500 mt-2">
                    Realiza la transferencia desde tu banco y reporta los dígitos de referencia.
                </p>
            </div>

            {{-- Bloque de Instrucciones con Datos del Pago Móvil Destinatario --}}
            <div class="mb-6 p-5 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-[#1E6F9F]/30 rounded-full blur-2xl pointer-events-none"></div>

                <div class="flex items-center justify-between border-b border-white/10 pb-3 mb-4">
                    <span class="text-xs uppercase font-extrabold tracking-widest text-[#C8B6E2]">
                        Datos Oficiales de Pago Móvil
                    </span>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-white/10 font-bold" x-text="getPlanName()"></span>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[11px] uppercase font-semibold">Banco Destino:</span>
                        <strong class="text-sm text-white">Banesco (0134)</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px] uppercase font-semibold">Teléfono:</span>
                        <strong class="text-sm text-white">0414-1234567</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px] uppercase font-semibold">Cédula / RIF:</span>
                        <strong class="text-sm text-white">V-12345678</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px] uppercase font-semibold">Monto a Transferir:</span>
                        <strong class="text-sm text-emerald-400">
                            $<span x-text="getMontoUsd()"></span> / mes
                        </strong>
                        <span class="text-[11px] text-slate-300 block">
                            ≈ <span x-text="getMontoBs()"></span> Bs.
                        </span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-[11px] text-slate-300">
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-university text-amber-400"></i>
                        <span>Tasa oficial de cambio (BCV):</span>
                    </span>
                    <strong class="text-white font-mono bg-white/10 px-2.5 py-0.5 rounded-md" x-text="tasaCambio.toLocaleString('es-VE', { minimumFractionDigits: 2, maximumFractionDigits: 4 }) + ' Bs / $' "></strong>
                </div>
            </div>

            {{-- Alerta de Error en Validación Frontend --}}
            <div x-show="error" x-cloak class="mb-6 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-rose-500 text-sm"></i>
                <span x-text="error"></span>
            </div>

            {{-- Errores de Validación Backend --}}
            @if ($errors->any())
                <div class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    <div class="font-bold flex items-center gap-1.5 text-rose-700">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Por favor corrige los siguientes datos:</span>
                    </div>
                    <ul class="list-disc list-inside pl-1 text-[11px] text-rose-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario de Registro de Pago --}}
            <form action="{{ route('pago.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="suscripcion_id" value="{{ $suscripcion->id ?? 1 }}">
                <input type="hidden" name="monto_usd" :value="getMontoUsd()">
                <input type="hidden" name="monto_bs" :value="(getMontoUsd() * tasaBcv).toFixed(2)">

                {{-- Banco de Origen --}}
                <div>
                    <label for="banco" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Banco de origen <span class="text-rose-500">*</span>
                    </label>
                    <select id="banco"
                            name="banco"
                            x-model="bancoOrigen"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                        <option value="">Selecciona tu banco...</option>
                        <option value="Banesco">Banesco</option>
                        <option value="Banco de Venezuela">Banco de Venezuela</option>
                        <option value="Mercantil">Mercantil</option>
                        <option value="BBVA Provincial">BBVA Provincial</option>
                        <option value="Bancamiga">Bancamiga</option>
                        <option value="BNC">BNC (Banco Nacional de Crédito)</option>
                        <option value="Banplus">Banplus</option>
                        <option value="Bancaribe">Bancaribe</option>
                        <option value="Otro">Otro Banco Nacional</option>
                    </select>
                </div>

                {{-- Cédula del Titular y Teléfono Emisor --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="cedula" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Cédula del titular <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="cedula_titular"
                               id="cedula"
                               x-model="cedulaTitular"
                               required
                               placeholder="Ej. V-20123456"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                    </div>

                    <div>
                        <label for="telefono" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Teléfono emisor <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel"
                               name="telefono_emisor"
                               id="telefono"
                               x-model="telefonoEmisor"
                               required
                               placeholder="Ej. 0412-1234567"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                    </div>
                </div>

                {{-- Fecha de Pago y Referencia --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="fecha" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Fecha de pago <span class="text-rose-500">*</span>
                        </label>
                        <input type="date"
                               name="fecha_pago"
                               id="fecha"
                               x-model="fechaPago"
                               required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                    </div>

                    <div>
                        <label for="referencia" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Referencia (4-20 dígitos) <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="referencia"
                               id="referencia"
                               x-model="referencia"
                               maxlength="20"
                               required
                               placeholder="Ej. 859421"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                    </div>
                </div>

                {{-- Monto Calculado en Bs con Alpine.js --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Monto en Bs. (Calculado automáticamente)
                    </label>
                    <div class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-100/70 text-slate-900 font-bold text-sm flex items-center justify-between">
                        <span>Bs. <span x-text="getMontoBs()"></span></span>
                        <span class="text-xs text-slate-500 font-normal">Equivalente a $<span x-text="getMontoUsd()"></span> USD</span>
                    </div>
                </div>

                {{-- Botón Enviar Comprobante --}}
                <div class="pt-4">
                    <button type="submit"
                            class="w-full py-4 px-6 text-sm font-bold text-white bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] rounded-xl shadow-lg shadow-blue-900/15 hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane text-xs"></i>
                        <span>Enviar Comprobante para Verificación</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-xs text-slate-400">
                <a :href="'/registro?plan=' + encodeURIComponent(plan)" class="hover:text-slate-600 transition">
                    <i class="fas fa-chevron-left text-[10px] mr-1"></i> Modificar datos del titular
                </a>
            </div>
        </div>
    </main>

    {{-- Modal de Éxito / Estado en Revisión (Alpine.js) --}}
    <div x-show="modalExito" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-3xl max-w-md w-full p-8 shadow-2xl border border-slate-200 text-center relative">
            
            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-5 text-2xl shadow-inner">
                <i class="fas fa-hourglass-half animate-pulse"></i>
            </div>

            <h3 class="font-serif text-2xl font-bold text-slate-900 mb-2">
                ¡Comprobante Recibido!
            </h3>

            <p class="text-sm text-slate-600 leading-relaxed mb-6">
                Tu pago está en revisión. Te notificaremos por correo cuando sea aprobado. Mientras tanto, tu cuenta ha sido creada.
            </p>

            <button type="button"
                    @click="irAExito()"
                    class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] text-white text-sm font-bold shadow-lg hover:shadow-xl transition-all">
                Ver Estado de mi Cuenta
            </button>
        </div>
    </div>

    {{-- Footer Simple --}}
    <footer class="mt-8 text-center text-xs text-slate-400">
        © 2026 Odontología Especializada. Todos los derechos reservados.
    </footer>

</body>
</html>