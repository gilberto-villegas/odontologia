<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Administrativo | Odontología Especializada</title>

    {{-- Fuentes Google: Playfair Display + Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
                        'sidebar-dark': '#0B132B',
                        'sidebar-card': '#1C2541',
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
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.3); border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.5); }
    </style>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F1F5F9] text-slate-700 antialiased min-h-screen flex"
      @actualizar-pagos-pendientes.window="pagosPendientesCount = $event.detail"
      x-data="{
          tab: '{{ request()->is('admin/pagos*') ? 'pagos' : (request()->is('admin/pacientes*') ? 'pacientes' : (request()->is('admin/configuracion*') ? 'configuracion' : (request()->is('admin/citas*') ? 'citas' : 'dashboard'))) }}',
          mobileSidebar: false,
          time: '',
          toast: false,
          toastMsg: '',
          pagosPendientesCount: {{ $pagosPendientesCount ?? 0 }},
          init() {
              window.showToast = (msg) => this.showToast(msg);
              this.updateTime();
              setInterval(() => this.updateTime(), 1000);
          },
          updateTime() {
              const now = new Date();
              this.time = now.toLocaleTimeString('es-VE', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
          },
          showToast(msg) {
              this.toastMsg = msg;
              this.toast = true;
              setTimeout(() => this.toast = false, 4000);
          }
      }">

    {{-- ==================== SIDEBAR FIJO (Fondo oscuro azulado / pizarra) ==================== --}}
    <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-950 text-slate-300 flex flex-col justify-between transition-transform duration-300 ease-in-out border-r border-slate-900 shadow-2xl lg:translate-x-0"
           :class="mobileSidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        
        <div class="flex flex-col h-full">
            
            {{-- Logo y Cabecera del Sidebar --}}
            <div class="h-20 flex items-center px-6 border-b border-slate-900/80 bg-slate-950/50">
                <a href="/admin" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-[#1E6F9F] to-[#9F7AEA] flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M18.8 6.5C18.2 4.4 16.7 3 14.8 3c-1.3 0-2.2.7-2.8 1.4C11.4 3.7 10.5 3 9.2 3 7.3 3 5.8 4.4 5.2 6.5 4.3 9.5 4.9 14.1 6.8 17.5c1.1 2 2.7 3.5 4 3.5.7 0 1.2-.5 1.2-1.5 0-1.2.4-2.5 1-2.5s1 1.3 1 2.5c0 1 .5 1.5 1.2 1.5 1.3 0 2.9-1.5 4-3.5 1.9-3.4 2.5-8 1.6-11z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-serif text-lg font-bold tracking-tight text-white block">
                            Odonto<span class="text-[#C8B6E2]">Salud</span>
                        </span>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#1E6F9F] -mt-1 block">
                            Panel Administrativo
                        </span>
                    </div>
                </a>
            </div>

            {{-- Menú Vertical de Navegación --}}
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
                
                {{-- 1. Panel de Control --}}
                <button type="button"
                        @click="tab = 'dashboard'; mobileSidebar = false"
                        class="w-full flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all text-left"
                        :class="tab === 'dashboard' ? 'bg-[#1E6F9F] text-white shadow-lg shadow-blue-900/30' : 'text-slate-400 hover:text-white hover:bg-slate-900/80'">
                    <i class="fas fa-th-large w-5 text-center text-base" :class="tab === 'dashboard' ? 'text-white' : 'text-[#C8B6E2]'"></i>
                    <span>Panel de Control</span>
                </button>

                {{-- 2. Pacientes --}}
                <button type="button"
                        @click="tab = 'pacientes'; mobileSidebar = false"
                        class="w-full flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all text-left"
                        :class="tab === 'pacientes' ? 'bg-[#1E6F9F] text-white shadow-lg shadow-blue-900/30' : 'text-slate-400 hover:text-white hover:bg-slate-900/80'">
                    <i class="fas fa-users w-5 text-center text-base" :class="tab === 'pacientes' ? 'text-white' : 'text-[#C8B6E2]'"></i>
                    <span>Pacientes</span>
                </button>

                {{-- 3. Citas --}}
                <button type="button"
                        @click="tab = 'citas'; mobileSidebar = false"
                        class="w-full flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all text-left"
                        :class="tab === 'citas' ? 'bg-[#1E6F9F] text-white shadow-lg shadow-blue-900/30' : 'text-slate-400 hover:text-white hover:bg-slate-900/80'">
                    <i class="fas fa-calendar-check w-5 text-center text-base" :class="tab === 'citas' ? 'text-white' : 'text-[#C8B6E2]'"></i>
                    <span>Citas</span>
                </button>

                {{-- 4. Validar Pagos (PRIORITARIO) --}}
                <button type="button"
                        @click="tab = 'pagos'; mobileSidebar = false"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all text-left"
                        :class="tab === 'pagos' ? 'bg-[#1E6F9F] text-white shadow-lg shadow-blue-900/30' : 'text-slate-400 hover:text-white hover:bg-slate-900/80'">
                    <div class="flex items-center gap-3.5">
                        <i class="fas fa-money-check-alt w-5 text-center text-base" :class="tab === 'pagos' ? 'text-white' : 'text-emerald-400'"></i>
                        <span>Validar Pagos</span>
                    </div>
                    <span x-show="pagosPendientesCount > 0"
                          class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-500 text-white shadow-sm"
                          x-text="pagosPendientesCount + ' pend.'">
                    </span>
                </button>

                {{-- 5. Planes y Membresías --}}
                <button type="button"
                        @click="tab = 'planes'; mobileSidebar = false"
                        class="w-full flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all text-left"
                        :class="tab === 'planes' ? 'bg-[#1E6F9F] text-white shadow-lg shadow-blue-900/30' : 'text-slate-400 hover:text-white hover:bg-slate-900/80'">
                    <i class="fas fa-gem w-5 text-center text-base" :class="tab === 'planes' ? 'text-white' : 'text-[#C8B6E2]'"></i>
                    <span>Planes y Membresías</span>
                </button>

                {{-- 6. Configuración (Para editar Landing) --}}
                <button type="button"
                        @click="tab = 'configuracion'; mobileSidebar = false"
                        class="w-full flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold transition-all text-left"
                        :class="tab === 'configuracion' ? 'bg-[#1E6F9F] text-white shadow-lg shadow-blue-900/30' : 'text-slate-400 hover:text-white hover:bg-slate-900/80'">
                    <i class="fas fa-sliders-h w-5 text-center text-base" :class="tab === 'configuracion' ? 'text-white' : 'text-[#C8B6E2]'"></i>
                    <span>Configuración</span>
                </button>

            </nav>

            {{-- Pie del Sidebar / Botón Salir --}}
            <div class="p-4 border-t border-slate-900/80">
                <a href="/"
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold text-slate-400 hover:text-rose-400 hover:bg-slate-900/90 transition-all">
                    <i class="fas fa-sign-out-alt w-5 text-center text-base text-rose-500"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>

        </div>
    </aside>

    {{-- Backdrop para móvil --}}
    <div x-show="mobileSidebar" 
         x-cloak
         @click="mobileSidebar = false"
         class="fixed inset-0 z-30 bg-slate-950/70 backdrop-blur-sm lg:hidden"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    {{-- ==================== CONTENEDOR PRINCIPAL ==================== --}}
    <div class="flex-1 lg:pl-64 flex flex-col min-w-0">
        
        {{-- Header Superior --}}
        <header class="h-20 bg-white border-b border-slate-200/90 sticky top-0 z-20 px-4 sm:px-8 flex items-center justify-between shadow-sm">
            
            <div class="flex items-center gap-4">
                {{-- Botón menú móvil --}}
                <button type="button" 
                        @click="mobileSidebar = true"
                        class="p-2 text-slate-600 hover:text-[#1E6F9F] lg:hidden text-xl focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>

                {{-- Título Contextual --}}
                <div>
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider hidden sm:block">
                        Centro Odontológico Especializado
                    </h2>
                    <span class="text-xs text-slate-400 block sm:inline">Administración General</span>
                </div>
            </div>

            {{-- Datos de Derecha: Hora en Vivo, Acceso Landing, Admin Profile --}}
            <div class="flex items-center gap-4 sm:gap-6">
                
                {{-- Reloj en Vivo (Alpine.js) --}}
                <div class="hidden md:flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100 border border-slate-200/80 text-xs font-mono font-bold text-slate-700">
                    <i class="far fa-clock text-[#1E6F9F]"></i>
                    <span x-text="time"></span>
                </div>

                {{-- Enlace a Landing Pública --}}
                <a href="/" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold text-[#1E6F9F] hover:text-[#16567C] bg-blue-50/80 px-3 py-1.5 rounded-xl border border-blue-100 transition">
                    <i class="fas fa-external-link-alt text-[10px]"></i>
                    <span>Ver Landing</span>
                </a>

                {{-- Perfil del Administrador --}}
                <div class="flex items-center gap-3 pl-3 sm:border-l border-slate-200">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-[#1E6F9F] to-[#9F7AEA] text-white font-bold flex items-center justify-center text-sm shadow-md">
                        AD
                    </div>
                    <div class="text-left hidden sm:block">
                        <strong class="text-xs font-bold text-slate-800 block">Dr. Roberto Méndez</strong>
                        <span class="text-[11px] text-slate-400 block">Director Médico</span>
                    </div>
                </div>

                {{-- Cerrar Sesión --}}
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" title="Cerrar sesión" class="p-2 text-slate-400 hover:text-rose-600 text-base transition focus:outline-none">
                        <i class="fas fa-power-off"></i>
                    </button>
                </form>

            </div>
        </header>

        {{-- Área de Contenido Dinámico según pestaña activa --}}
        <main class="flex-1 p-4 sm:p-8 overflow-y-auto">
            
            {{-- Tab 1: Dashboard Principal --}}
            <div x-show="tab === 'dashboard'" x-cloak>
                @include('admin-dashboard')
            </div>

            {{-- Tab 2: Validar Pagos (Prioritario) --}}
            <div x-show="tab === 'pagos'" x-cloak>
                @include('admin-pagos')
            </div>

            {{-- Tab 3: Configuración Landing --}}
            <div x-show="tab === 'configuracion'" x-cloak>
                @include('admin-configuracion')
            </div>

            {{-- Tab 4: Pacientes --}}
            <div x-show="tab === 'pacientes'" x-cloak>
                @include('admin-pacientes')
            </div>

            {{-- Tab 5: Citas (Módulo Auxiliar) --}}
            <div x-show="tab === 'citas'" x-cloak class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="font-serif text-3xl font-bold text-slate-900">Gestión de Citas Médicas</h1>
                        <p class="text-slate-500 text-sm mt-1">Horarios asignados por box clínico y doctor especialista.</p>
                    </div>
                    <button type="button" @click="showToast('Horario actualizado')" class="px-5 py-2.5 rounded-xl bg-[#1E6F9F] text-white text-xs font-bold shadow-md">
                        + Nueva Cita Manual
                    </button>
                </div>

                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl shadow-slate-900/5 overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider">
                                <th class="pb-3 font-bold">Fecha / Hora</th>
                                <th class="pb-3 font-bold">Paciente</th>
                                <th class="pb-3 font-bold">Procedimiento</th>
                                <th class="pb-3 font-bold">Doctor Asignado</th>
                                <th class="pb-3 font-bold">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="py-4 font-bold text-slate-900">Hoy · 09:00 AM</td>
                                <td class="py-4 text-slate-700">Sofía Martínez</td>
                                <td class="py-4 font-semibold text-[#1E6F9F]">Limpieza Dental Periódica (Cupo 1)</td>
                                <td class="py-4 text-slate-500 text-xs">Dra. Valentina Rosas</td>
                                <td class="py-4"><span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">Confirmada</span></td>
                            </tr>
                            <tr>
                                <td class="py-4 font-bold text-slate-900">Hoy · 11:30 AM</td>
                                <td class="py-4 text-slate-700">Alejandro Silva</td>
                                <td class="py-4 font-semibold text-[#1E6F9F]">Revisión y Diagnóstico 3D</td>
                                <td class="py-4 text-slate-500 text-xs">Dr. Alejandro Morales</td>
                                <td class="py-4"><span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700">Pendiente de llegada</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tab 6: Planes y Membresías (Resumen visual) --}}
            <div x-show="tab === 'planes'" x-cloak class="space-y-6">
                <div>
                    <h1 class="font-serif text-3xl font-bold text-slate-900">Planes de Membresía</h1>
                    <p class="text-slate-500 text-sm mt-1">Estructura de precios y beneficios activos para afiliación en línea.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-md">
                        <span class="text-xs font-bold uppercase text-slate-400">Nivel 1</span>
                        <h3 class="font-serif text-2xl font-bold text-slate-900 mt-1">Plan Básico</h3>
                        <div class="text-3xl font-black text-[#1E6F9F] my-3">$15 <span class="text-xs font-bold text-slate-400">USD/mes</span></div>
                        <p class="text-xs text-slate-500">6 consultas anuales + limpiezas + extracciones simples.</p>
                    </div>
                    <div class="p-6 rounded-3xl bg-white border-2 border-[#1E6F9F] shadow-xl">
                        <span class="text-xs font-bold uppercase text-[#1E6F9F]">Nivel 2 (Más Popular)</span>
                        <h3 class="font-serif text-2xl font-bold text-slate-900 mt-1">Plan Plus</h3>
                        <div class="text-3xl font-black text-[#1E6F9F] my-3">$25 <span class="text-xs font-bold text-slate-400">USD/mes</span></div>
                        <p class="text-xs text-slate-500">Todo el Básico + 2 restauraciones simples + 1 prótesis básica.</p>
                    </div>
                    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-md">
                        <span class="text-xs font-bold uppercase text-slate-400">Nivel 3</span>
                        <h3 class="font-serif text-2xl font-bold text-slate-900 mt-1">Plan Premium</h3>
                        <div class="text-3xl font-black text-slate-900 my-3">$40 <span class="text-xs font-bold text-slate-400">USD/mes</span></div>
                        <p class="text-xs text-slate-500">Todo el Plus + prótesis extendida + urgencias sin espera.</p>
                    </div>
                </div>
            </div>

        </main>
    </div>

    {{-- Toast Global de Notificación (Alpine.js) --}}
    <div x-show="toast"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         class="fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3.5 border border-white/10 max-w-md">
        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm flex-shrink-0 shadow-sm">
            <i class="fas fa-check"></i>
        </div>
        <span class="text-xs sm:text-sm font-semibold" x-text="toastMsg"></span>
    </div>

</body>
</html>