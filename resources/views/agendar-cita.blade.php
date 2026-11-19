<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita | Odontología Especializada</title>

    {{-- Fuentes Google: Playfair Display + Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Tailwind CSS CDN con paleta oficial --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dental-blue': '#1E6F9F',
                        'dental-blue-dark': '#16567C',
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
<body class="bg-[#F8FAFC] text-slate-700 antialiased min-h-screen flex flex-col justify-between"
      x-data="{
          fecha: '',
          hora: '09:00 AM',
          motivo: 'Limpieza',
          notas: '',
          toastExito: false,
          cargando: false,
          mobileSidebar: false,
          confirmarCita() {
              if (!this.fecha) {
                  alert('Por favor selecciona una fecha válida.');
                  return;
              }
              this.cargando = true;
              setTimeout(() => {
                  this.cargando = false;
                  this.toastExito = true;
                  setTimeout(() => {
                      window.location.href = '/dashboard-paciente';
                  }, 2500);
              }, 600);
          }
      }">

    {{-- Top Navbar --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <div class="flex items-center gap-4">
                <button type="button" @click="mobileSidebar = !mobileSidebar" class="lg:hidden text-slate-600 hover:text-[#1E6F9F] text-xl">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="/dashboard-paciente" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#1E6F9F] to-[#9F7AEA] flex items-center justify-center text-white shadow-md">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M18.8 6.5C18.2 4.4 16.7 3 14.8 3c-1.3 0-2.2.7-2.8 1.4C11.4 3.7 10.5 3 9.2 3 7.3 3 5.8 4.4 5.2 6.5 4.3 9.5 4.9 14.1 6.8 17.5c1.1 2 2.7 3.5 4 3.5.7 0 1.2-.5 1.2-1.5 0-1.2.4-2.5 1-2.5s1 1.3 1 2.5c0 1 .5 1.5 1.2 1.5 1.3 0 2.9-1.5 4-3.5 1.9-3.4 2.5-8 1.6-11z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-tight text-[#1E6F9F]">Odontología <span class="text-[#9F7AEA]">Salud</span></span>
                        <span class="block text-[10px] uppercase font-bold tracking-widest text-slate-400 -mt-1">Agendamiento en Línea</span>
                    </div>
                </a>
            </div>

            <nav class="hidden lg:flex items-center gap-1 font-semibold text-sm">
                <a href="/dashboard-paciente" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-th-large mr-2 text-xs"></i>Inicio
                </a>
                <a href="/agendar-cita" class="px-4 py-2 rounded-xl text-[#1E6F9F] bg-blue-50/80 font-bold transition">
                    <i class="fas fa-calendar-plus mr-2 text-xs"></i>Mis Citas
                </a>
                <a href="/historial-clinico" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-notes-medical mr-2 text-xs"></i>Mi Historial
                </a>
                <a href="/mi-plan" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-shield-alt mr-2 text-xs"></i>Mi Plan
                </a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="/dashboard-paciente" class="text-xs font-bold text-slate-600 hover:text-[#1E6F9F] flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i>
                    <span class="hidden sm:inline">Volver</span>
                </a>
            </div>

        </div>

        {{-- Menú Móvil --}}
        <div x-show="mobileSidebar" x-cloak class="lg:hidden px-4 pt-2 pb-4 border-t border-slate-200 bg-white space-y-1">
            <a href="/dashboard-paciente" class="block py-2.5 px-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50">
                <i class="fas fa-th-large mr-2"></i>Inicio
            </a>
            <a href="/agendar-cita" class="block py-2.5 px-3 rounded-xl font-bold text-[#1E6F9F] bg-blue-50">
                <i class="fas fa-calendar-plus mr-2"></i>Mis Citas
            </a>
            <a href="/historial-clinico" class="block py-2.5 px-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50">
                <i class="fas fa-notes-medical mr-2"></i>Mi Historial
            </a>
            <a href="/mi-plan" class="block py-2.5 px-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50">
                <i class="fas fa-shield-alt mr-2"></i>Mi Plan
            </a>
            <a href="/" class="block py-2.5 px-3 rounded-xl font-semibold text-rose-600 hover:bg-rose-50">
                <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
            </a>
        </div>
    </header>

    {{-- Contenido Principal --}}
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full flex-1">
        
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-2xl shadow-slate-900/5">
            
            {{-- Encabezado --}}
            <div class="mb-8 text-center sm:text-left">
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#1E6F9F] bg-blue-50 px-3 py-1 rounded-full border border-blue-100 mb-3">
                    Reserva tu Turno
                </span>
                <h1 class="font-serif text-3xl font-bold text-slate-900">
                    Agendar Cita
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Selecciona el día, horario y procedimiento para tu atención clínica.
                </p>
            </div>

            {{-- Alertas Flash --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Formulario de Agendamiento Backend + Frontend --}}
            <form action="{{ route('paciente.citas.store') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Selector de Fecha --}}
                <div>
                    <label for="fecha" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Fecha de la Cita <span class="text-rose-500">*</span>
                    </label>
                    <input type="date"
                           name="fecha"
                           id="fecha"
                           value="{{ old('fecha', date('Y-m-d', strtotime('+1 day'))) }}"
                           required
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                    @error('fecha')
                        <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Selector de Hora --}}
                <div>
                    <label for="hora" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Hora Disponible <span class="text-rose-500">*</span>
                    </label>
                    <select id="hora"
                            name="hora"
                            required
                            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                        <option value="09:00:00">09:00 am – Turno Mañana</option>
                        <option value="10:30:00">10:30 am – Turno Mañana</option>
                        <option value="11:30:00">11:30 am – Turno Mañana</option>
                        <option value="14:00:00">02:00 pm – Turno Tarde</option>
                        <option value="15:30:00">03:30 pm – Turno Tarde</option>
                        <option value="16:30:00">04:30 pm – Turno Tarde</option>
                    </select>
                    @error('hora')
                        <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Selector de Motivo --}}
                <div>
                    <label for="motivo" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Motivo de Consulta <span class="text-rose-500">*</span>
                    </label>
                    <select id="motivo"
                            name="motivo"
                            required
                            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                        <option value="Limpieza y Profilaxis">Limpieza y Profilaxis (Incluida en Membresía)</option>
                        <option value="Revisión Diagnóstica General">Revisión Diagnóstica General y Odontograma</option>
                        <option value="Dolor o Emergencia">Dolor, Sensibilidad o Emergencia Dental</option>
                        <option value="Consulta de Ortodoncia">Consulta de Ortodoncia y Alineación</option>
                        <option value="Otro Procedimiento">Otro Procedimiento Clínico</option>
                    </select>
                    @error('motivo')
                        <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Doctor Especialista (Opcional) --}}
                <div>
                    <label for="doctor" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Doctor Especialista
                    </label>
                    <select id="doctor"
                            name="nombre_doctor"
                            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                        <option value="Dr. Roberto Méndez">Dr. Roberto Méndez (Director Odontológico)</option>
                        <option value="Dra. Valentina Torres">Dra. Valentina Torres (Ortodoncia)</option>
                        <option value="Dr. Carlos Silva">Dr. Carlos Silva (Endodoncia & Cirugía)</option>
                    </select>
                </div>

                {{-- Aviso Obligatorio de Consumo de Consulta --}}
                <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-50 via-purple-50/60 to-blue-50 border border-[#1E6F9F]/20 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-xl bg-[#1E6F9F] text-white flex items-center justify-center flex-shrink-0 text-sm mt-0.5">
                        <i class="fas fa-info"></i>
                    </div>
                    <div class="text-xs leading-relaxed text-slate-700">
                        <strong class="text-[#1E6F9F] block text-sm font-bold mb-0.5">Información de Membresía</strong>
                        Esta cita consumirá <strong>1 de tus consultas anuales</strong>.
                        @if(isset($suscripcion))
                            Actualmente dispones de <strong class="text-[#1E6F9F]">{{ $suscripcion->consultas_disponibles }}</strong> consultas.
                        @endif
                    </div>
                </div>

                {{-- Botón Confirmar Cita --}}
                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-4 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] shadow-lg shadow-blue-900/15 hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 flex items-center justify-center gap-2.5">
                        <i class="fas fa-calendar-check"></i>
                        <span>Confirmar y Reservar Cita</span>
                    </button>
                </div>
            </form>
                        <span x-show="!cargando">Confirmar Cita</span>
                        <span x-show="cargando" x-cloak class="flex items-center gap-2">
                            <i class="fas fa-spinner fa-spin"></i>
                            Reservando turno...
                        </span>
                    </button>
                </div>

            </form>

            <div class="mt-6 text-center text-xs text-slate-400">
                <a href="/dashboard-paciente" class="hover:text-slate-600 transition">
                    <i class="fas fa-chevron-left text-[10px] mr-1"></i> Volver al Portal del Paciente
                </a>
            </div>

        </div>

    </main>

    {{-- Toast de Éxito (Alpine.js) --}}
    <div x-show="toastExito"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3.5 border border-white/15 max-w-md">
        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm flex-shrink-0">
            <i class="fas fa-check"></i>
        </div>
        <div class="text-xs">
            <strong class="block text-sm text-white font-bold">¡Cita agendada!</strong>
            <span>Recibirás un correo de confirmación con las instrucciones y el recordatorio.</span>
        </div>
    </div>

    {{-- Footer Simple --}}
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        <p>© 2026 Odontología Especializada · Sede: Torre Médica Dental, Piso 4, Consultorio 402.</p>
    </footer>

</body>
</html>