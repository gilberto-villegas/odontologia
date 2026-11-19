<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea tu cuenta | Odontología Especializada</title>
    <meta name="description" content="Paso 1: Crea tu cuenta para afiliarte a tu Plan de Membresía Dental.">

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
          nombre: '',
          apellido: '',
          email: '',
          edad: '',
          terminos: false,
          modalTerminos: false,
          error: '',
          getPlanTitle() {
              if (this.plan === 'basico') return 'Plan Básico - $15/mes';
              if (this.plan === 'premium') return 'Plan Premium - $40/mes';
              return 'Plan Plus - $25/mes';
          },
          continuarPago() {
              if (!this.nombre || !this.apellido || !this.email || !this.edad) {
                  this.error = 'Por favor completa todos los campos obligatorios.';
                  return;
              }
              if (!this.terminos) {
                  this.error = 'Debes aceptar los Términos y Condiciones para continuar.';
                  return;
              }
              this.error = '';
              window.location.href = '/pago?plan=' + encodeURIComponent(this.plan);
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
            
            {{-- Encabezado del Formulario --}}
            <div class="mb-6 text-center">
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#1E6F9F] bg-blue-50 px-3 py-1 rounded-full border border-blue-100 mb-3">
                    Paso 1 de 2: Registro de Paciente
                </span>
                <h1 class="font-serif text-3xl font-bold text-slate-900">
                    Crea tu cuenta
                </h1>
                <p class="text-sm text-slate-500 mt-2">
                    Ingresa tus datos personales para aperturar tu historia clínica digital.
                </p>
            </div>

            {{-- Resumen del Plan Seleccionado --}}
            <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-blue-50/80 via-purple-50/50 to-blue-50/80 border border-[#1E6F9F]/20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#1E6F9F] text-white flex items-center justify-center font-bold text-sm">
                        <i class="fas fa-gem"></i>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400">Plan Seleccionado</span>
                        <span class="text-sm sm:text-base font-bold text-[#1E6F9F]">
                            Estás afiliándote al {{ $planSeleccionado->nombre ?? 'Plan Plus' }} (${{ number_format($planSeleccionado->precio ?? 25, 0) }}/mes)
                        </span>
                    </div>
                </div>
                <a href="/#plan" class="text-xs font-bold text-[#9F7AEA] hover:underline whitespace-nowrap">
                    Cambiar
                </a>
            </div>

            {{-- Errores de Validación Backend --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    <div class="font-bold flex items-center gap-1.5 text-rose-700">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Por favor corrige los siguientes campos:</span>
                    </div>
                    <ul class="list-disc list-inside pl-1 text-[11px] text-rose-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulario Backend + Frontend --}}
            <form action="{{ route('registro.post') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $planSeleccionado->id ?? 2 }}">

                {{-- Nombre y Apellido --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nombre" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Nombre <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="nombre"
                               id="nombre"
                               value="{{ old('nombre') }}"
                               required
                               placeholder="Ej. Sofía"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                    </div>
                    <div>
                        <label for="apellido" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Apellido <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="apellido"
                               id="apellido"
                               value="{{ old('apellido') }}"
                               required
                               placeholder="Ej. Martínez"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                    </div>
                </div>

                {{-- Cédula y Edad --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="cedula" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Cédula / DNI <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="cedula"
                               id="cedula"
                               value="{{ old('cedula') }}"
                               required
                               placeholder="Ej. V-20123456"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                    </div>
                    <div>
                        <label for="edad" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Edad <span class="text-rose-500">*</span>
                        </label>
                        <input type="number"
                               name="edad"
                               id="edad"
                               value="{{ old('edad') }}"
                               min="1"
                               max="120"
                               required
                               placeholder="Ej. 28"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                    </div>
                </div>

                {{-- Correo Electrónico --}}
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Correo electrónico <span class="text-rose-500">*</span>
                    </label>
                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="sofia.martinez@ejemplo.com"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                </div>

                {{-- Contraseña --}}
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Crea tu Contraseña <span class="text-rose-500">*</span>
                    </label>
                    <input type="password"
                           name="password"
                           id="password"
                           required
                           placeholder="Mínimo 6 caracteres"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                </div>

                {{-- Checkbox Términos y Condiciones --}}
                <div class="pt-2">
                    <label class="flex items-start gap-3 cursor-pointer select-none">
                        <input type="checkbox"
                               name="terminos"
                               value="1"
                               {{ old('terminos') ? 'checked' : '' }}
                               required
                               class="w-4 h-4 mt-1 text-[#1E6F9F] border-slate-300 rounded focus:ring-[#1E6F9F]">
                        <span class="text-xs text-slate-600 leading-relaxed">
                            Acepto los <a href="#" @click.prevent="modalTerminos = true" class="font-bold text-[#1E6F9F] underline hover:text-[#9F7AEA]">Términos y Condiciones</a> del plan de membresía dental de 6 consultas anuales.
                        </span>
                    </label>
                </div>

                {{-- Botón Continuar al Pago --}}
                <div class="pt-4">
                    <button type="submit"
                            class="w-full py-4 px-6 text-sm font-bold text-white bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] rounded-xl shadow-lg shadow-blue-900/15 hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Continuar al Pago</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-xs text-slate-400">
                <a href="/" class="hover:text-slate-600 transition">
                    <i class="fas fa-chevron-left text-[10px] mr-1"></i> Volver a la página principal
                </a>
            </div>
        </div>
    </main>

    {{-- Modal Términos y Condiciones (Alpine.js) --}}
    <div x-show="modalTerminos" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="modalTerminos = false" 
             class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative max-h-[85vh] flex flex-col">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-serif text-xl font-bold text-slate-900">Términos y Condiciones</h3>
                <button type="button" @click="modalTerminos = false" class="text-slate-400 hover:text-slate-700 text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="overflow-y-auto my-4 pr-2 space-y-3 text-xs text-slate-600 leading-relaxed">
                <p><strong>1. Objeto del Plan:</strong> El Plan de Membresía Dental otorga al paciente un cupo de hasta seis (6) consultas anuales de revisión diagnóstica y profilaxis profiláctica.</p>
                <p><strong>2. Naturaleza Legal:</strong> La membresía dental constituye un contrato de servicios odontológicos preventivos y de fidelización clínica; <strong>no es un seguro médico</strong> ni una póliza de hospitalización.</p>
                <p><strong>3. Forma de Pago:</strong> Los pagos se gestionan de forma mensual o anual mediante Pago Móvil verificado. Los cupos se renuevan al cumplir cada ciclo mensual.</p>
                <p><strong>4. Cancelación:</strong> El afiliado puede pausar o cancelar su membresía con 15 días de antelación sin recargo ni penalización alguna.</p>
            </div>

            <div class="pt-3 border-t border-slate-100 text-right">
                <button type="button" 
                        @click="modalTerminos = false; terminos = true;"
                        class="px-5 py-2.5 rounded-xl bg-[#1E6F9F] text-white text-xs font-bold hover:bg-[#16567C] transition">
                    Entendido y Aceptar
                </button>
            </div>
        </div>
    </div>

    {{-- Footer Simple --}}
    <footer class="mt-8 text-center text-xs text-slate-400">
        © 2026 Odontología Especializada. Todos los derechos reservados.
    </footer>

</body>
</html>