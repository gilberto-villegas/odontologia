<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal del Paciente | Odontología Especializada</title>

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
          modalCita: false,
          toast: false,
          toastMsg: '',
          mobileSidebar: false,
          fechaCita: '',
          horaCita: '09:00 AM',
          motivoCita: 'Limpieza y Profilaxis',
          citas: [
              { id: 1, fecha: '28 Feb 2026', hora: '10:30 AM', motivo: 'Limpieza Dental Periódica', doctor: 'Dra. Valentina Rosas', estado: 'Confirmada' },
              { id: 2, fecha: '15 Mar 2026', hora: '03:00 PM', motivo: 'Revisión y Diagnóstico 3D', doctor: 'Dr. Alejandro Morales', estado: 'Pendiente' }
          ],
          agendarRapido() {
              if (!this.fechaCita) {
                  alert('Por favor selecciona una fecha.');
                  return;
              }
              this.citas.unshift({
                  id: Date.now(),
                  fecha: this.fechaCita,
                  hora: this.horaCita,
                  motivo: this.motivoCita,
                  doctor: 'Dra. Valentina Rosas',
                  estado: 'Pendiente'
              });
              this.modalCita = false;
              this.mostrarToast('¡Cita solicitada con éxito! Te contactaremos para confirmar.');
          },
          mostrarToast(msg) {
              this.toastMsg = msg;
              this.toast = true;
              setTimeout(() => this.toast = false, 4000);
          }
      }">

    {{-- Top Navbar / Header --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            {{-- Logo y Toggle Móvil --}}
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
                        <span class="block text-[10px] uppercase font-bold tracking-widest text-slate-400 -mt-1">Portal del Paciente</span>
                    </div>
                </a>
            </div>

            {{-- Navegación Desktop --}}
            <nav class="hidden lg:flex items-center gap-1 font-semibold text-sm">
                <a href="/dashboard-paciente" class="px-4 py-2 rounded-xl text-[#1E6F9F] bg-blue-50/80 font-bold transition">
                    <i class="fas fa-th-large mr-2 text-xs"></i>Inicio
                </a>
                <a href="/agendar-cita" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-calendar-plus mr-2 text-xs"></i>Mis Citas
                </a>
                <a href="/historial-clinico" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-notes-medical mr-2 text-xs"></i>Mi Historial
                </a>
                <a href="/mi-plan" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-shield-alt mr-2 text-xs"></i>Mi Plan
                </a>
            </nav>

            {{-- Perfil del Paciente y Salir --}}
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-3 pr-3 border-r border-slate-200">
                    <div class="w-10 h-10 rounded-full bg-purple-100 text-[#9F7AEA] flex items-center justify-center font-bold text-sm">
                        SM
                    </div>
                    <div class="text-left">
                        <span class="block text-xs font-bold text-slate-800">Sofía Martínez</span>
                        <span class="block text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Afiliado Activo
                        </span>
                    </div>
                </div>
                <a href="/" title="Cerrar Sesión" class="text-xs font-bold text-slate-500 hover:text-rose-600 flex items-center gap-1.5 py-2 px-3 rounded-xl hover:bg-rose-50 transition">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="hidden sm:inline">Cerrar Sesión</span>
                </a>
            </div>

        </div>

        {{-- Menú Móvil Desplegable --}}
        <div x-show="mobileSidebar" x-cloak class="lg:hidden px-4 pt-2 pb-4 border-t border-slate-200 bg-white space-y-1">
            <a href="/dashboard-paciente" class="block py-2.5 px-3 rounded-xl font-bold text-[#1E6F9F] bg-blue-50">
                <i class="fas fa-th-large mr-2"></i>Inicio
            </a>
            <a href="/agendar-cita" class="block py-2.5 px-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50">
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full flex-1">
        
        {{-- Saludo y Botón Agendar Cita --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900">
                    ¡Hola de nuevo, {{ auth()->user()->nombre ?? 'Sofía' }}!
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Gestiona tus 6 consultas anuales y mantén tu salud bucal al día.
                </p>
            </div>

            <a href="/agendar-cita"
               class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] text-white font-bold text-sm shadow-lg shadow-blue-900/15 hover:shadow-2xl hover:scale-105 transition-all">
                <i class="fas fa-calendar-plus"></i>
                <span>Agendar Nueva Cita</span>
            </a>
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

        {{-- Tarjetas de Estado y Cupos del Plan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            
            {{-- Card 1: Plan Actual & Estado --}}
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xl shadow-slate-900/5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Membresía Vigente</span>
                        @php
                            $estadoPlan = $suscripcion->estado ?? 'activa';
                        @endphp
                        @if($estadoPlan === 'activa')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Activo
                            </span>
                        @elseif($estadoPlan === 'pendiente')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Pago en Revisión
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-rose-50 text-rose-700 border border-rose-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Suspendido
                            </span>
                        @endif
                    </div>
                    <h2 class="font-serif text-2xl font-bold text-slate-900">{{ $suscripcion->plan->nombre ?? 'Plan Plus' }}</h2>
                    <p class="text-xs text-slate-500 mt-1">
                        ${{ number_format($suscripcion->plan->precio ?? 25, 0) }} USD / mes · Vencimiento: {{ isset($suscripcion->fecha_fin) ? \Carbon\Carbon::parse($suscripcion->fecha_fin)->format('d M Y') : '01 Mar 2027' }}
                    </p>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500">
                        {{ ($suscripcion->estado ?? '') === 'activa' ? 'Pago verificado vía Pago Móvil' : 'Comprobante en revisión' }}
                    </span>
                    <a href="/mi-plan" class="font-bold text-[#1E6F9F] hover:underline">Ver detalles →</a>
                </div>
            </div>

            {{-- Card 2: Consultas Disponibles (con barra de progreso real) --}}
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xl shadow-slate-900/5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Cupo Anual</span>
                        <span class="text-xs font-extrabold text-[#9F7AEA] bg-purple-50 px-2.5 py-0.5 rounded-md">6 Consultas / Año</span>
                    </div>

                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-black text-[#1E6F9F]">{{ $suscripcion->consultas_disponibles ?? 6 }}</span>
                        <span class="text-base font-bold text-slate-400">de 6 disponibles</span>
                    </div>

                    {{-- Barra de Progreso --}}
                    @php
                        $disp = $suscripcion->consultas_disponibles ?? 6;
                        $porcentaje = ($disp / 6) * 100;
                    @endphp
                    <div class="w-full bg-slate-100 rounded-full h-3 mt-4 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#1E6F9F] to-[#9F7AEA] h-3 rounded-full transition-all duration-700" style="width: {{ $porcentaje }}%"></div>
                    </div>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
                    <span>{{ $disp }} consultas restantes</span>
                    <span class="text-emerald-600 font-bold">¡Vigente todo el año!</span>
                </div>
            </div>

            {{-- Card 3: Acceso Directo a Beneficios --}}
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 sm:p-7 text-white shadow-xl flex flex-col justify-between relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 w-28 h-28 bg-[#1E6F9F]/30 rounded-full blur-2xl pointer-events-none"></div>
                
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#C8B6E2] block mb-2">Descuentos Activos</span>
                    <h3 class="font-serif text-xl font-bold">Cobertura Dental Plus</h3>
                    <p class="text-xs text-slate-300 mt-2 leading-relaxed">
                        Tienes acceso a 2 resinas estéticas cubiertas y descuentos preferenciales en ortodoncia y coronas.
                    </p>
                </div>

                <div class="pt-4 mt-4 border-t border-white/10">
                    <a href="/historial-clinico" class="text-xs font-bold text-[#C8B6E2] hover:text-white flex items-center gap-1.5">
                        <i class="fas fa-file-medical"></i>
                        <span>Revisar mi historial clínico</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- Tabla de Próximas Citas --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl shadow-slate-900/5">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-serif text-2xl font-bold text-slate-900">Próximas Citas</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Calendario de valoraciones y procedimientos programados.</p>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full" x-text="citas.length + ' agendadas'"></span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider">
                            <th class="pb-3 font-bold">Fecha</th>
                            <th class="pb-3 font-bold">Hora</th>
                            <th class="pb-3 font-bold">Motivo / Especialidad</th>
                            <th class="pb-3 font-bold">Doctor Asignado</th>
                            <th class="pb-3 font-bold">Estado</th>
                            <th class="pb-3 font-bold text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="cita in citas" :key="cita.id">
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 font-bold text-slate-800 whitespace-nowrap" x-text="cita.fecha"></td>
                                <td class="py-4 text-slate-600 whitespace-nowrap" x-text="cita.hora"></td>
                                <td class="py-4 font-medium text-slate-700" x-text="cita.motivo"></td>
                                <td class="py-4 text-slate-500 text-xs" x-text="cita.doctor"></td>
                                <td class="py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold"
                                          :class="cita.estado === 'Confirmada' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200'"
                                          x-text="cita.estado">
                                    </span>
                                </td>
                                <td class="py-4 text-right">
                                    <button type="button" 
                                            @click="citas = citas.filter(c => c.id !== cita.id); mostrarToast('Cita cancelada con éxito.');"
                                            class="text-xs font-bold text-rose-500 hover:text-rose-700 hover:underline">
                                        Cancelar
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>* Las cancelaciones deben hacerse con al menos 24h de anticipación.</span>
                <a href="/agendar-cita" class="text-[#1E6F9F] font-bold hover:underline">Ver agenda completa</a>
            </div>
        </div>

    </main>

    {{-- Modal Agendar Cita Rápida (Alpine.js) --}}
    <div x-show="modalCita" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="modalCita = false" 
             class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <div>
                    <h3 class="font-serif text-2xl font-bold text-slate-900">Agendar Cita Rápida</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Consume 1 de tus 6 consultas de membresía.</p>
                </div>
                <button type="button" @click="modalCita = false" class="text-slate-400 hover:text-slate-700 text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form @submit.prevent="agendarRapido()" class="space-y-4 text-sm">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Fecha deseada</label>
                    <input type="date" 
                           x-model="fechaCita" 
                           required 
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm outline-none focus:border-[#1E6F9F]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Hora preferida</label>
                    <select x-model="horaCita" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm outline-none focus:border-[#1E6F9F]">
                        <option value="09:00 AM">09:00 AM - 10:00 AM</option>
                        <option value="10:30 AM">10:30 AM - 11:30 AM</option>
                        <option value="02:00 PM">02:00 PM - 03:00 PM</option>
                        <option value="03:30 PM">03:30 PM - 04:30 PM</option>
                        <option value="04:30 PM">04:30 PM - 05:30 PM</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Motivo de consulta</label>
                    <select x-model="motivoCita" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm outline-none focus:border-[#1E6F9F]">
                        <option value="Limpieza y Profilaxis">Limpieza y Profilaxis (Cubierta)</option>
                        <option value="Revisión Diagnóstica General">Revisión Diagnóstica General (Cubierta)</option>
                        <option value="Evaluación de Ortodoncia">Evaluación de Ortodoncia (Descuento Plan)</option>
                        <option value="Dolor o Sensibilidad">Dolor o Sensibilidad Dental</option>
                    </select>
                </div>

                <div class="p-3.5 rounded-xl bg-blue-50/70 border border-blue-100 text-xs text-[#1E6F9F] flex items-start gap-2.5">
                    <i class="fas fa-info-circle text-sm mt-0.5"></i>
                    <span>Esta cita consumirá <strong>1 de tus 6 consultas anuales</strong>. No se te cobrará ningún monto adicional al acudir a tu consulta.</span>
                </div>

                <div class="pt-3 flex items-center justify-end gap-3">
                    <button type="button" @click="modalCita = false" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#1E6F9F] text-white text-xs font-bold hover:bg-[#16567C] shadow-md transition">
                        Confirmar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Toast de Éxito Flotante (Alpine.js) --}}
    <div x-show="toast"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         class="fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-5 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 text-sm font-semibold border border-white/10">
        <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs">
            <i class="fas fa-check"></i>
        </div>
        <span x-text="toastMsg"></span>
    </div>

    {{-- Footer Simple --}}
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        <p>© 2026 Odontología Especializada · Plan de Membresía Dental de 6 Consultas Anuales.</p>
    </footer>

</body>
</html>