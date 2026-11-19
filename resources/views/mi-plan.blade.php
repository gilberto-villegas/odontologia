<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de mi Plan | Odontología Especializada</title>

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
          modalExtension: false,
          toast: false,
          tipoPeticion: 'extension',
          mensajeAdmin: '',
          mobileSidebar: false,
          enviarPeticion() {
              this.modalExtension = false;
              this.mensajeAdmin = '';
              this.toast = true;
              setTimeout(() => this.toast = false, 4000);
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
                        <span class="block text-[10px] uppercase font-bold tracking-widest text-slate-400 -mt-1">Póliza y Membresía</span>
                    </div>
                </a>
            </div>

            <nav class="hidden lg:flex items-center gap-1 font-semibold text-sm">
                <a href="/dashboard-paciente" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-th-large mr-2 text-xs"></i>Inicio
                </a>
                <a href="/agendar-cita" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-calendar-plus mr-2 text-xs"></i>Mis Citas
                </a>
                <a href="/historial-clinico" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-notes-medical mr-2 text-xs"></i>Mi Historial
                </a>
                <a href="/mi-plan" class="px-4 py-2 rounded-xl text-[#1E6F9F] bg-blue-50/80 font-bold transition">
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
            <a href="/agendar-cita" class="block py-2.5 px-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50">
                <i class="fas fa-calendar-plus mr-2"></i>Mis Citas
            </a>
            <a href="/historial-clinico" class="block py-2.5 px-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50">
                <i class="fas fa-notes-medical mr-2"></i>Mi Historial
            </a>
            <a href="/mi-plan" class="block py-2.5 px-3 rounded-xl font-bold text-[#1E6F9F] bg-blue-50">
                <i class="fas fa-shield-alt mr-2"></i>Mi Plan
            </a>
            <a href="/" class="block py-2.5 px-3 rounded-xl font-semibold text-rose-600 hover:bg-rose-50">
                <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
            </a>
        </div>
    </header>

    {{-- Contenido Principal --}}
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full flex-1">
        
        {{-- Encabezado --}}
        <div class="mb-10 text-center sm:text-left">
            <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#1E6F9F] bg-blue-50 px-3 py-1 rounded-full border border-blue-100 mb-2">
                Póliza Dental
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900">
                Detalles de mi Plan
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Consulta los beneficios, fechas de vigencia y gestiona la continuidad de tu membresía.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- Columna Izquierda: Tarjeta de Información General del Plan --}}
            <div class="lg:col-span-5 bg-white rounded-3xl p-7 sm:p-8 border border-slate-200/90 shadow-xl shadow-slate-900/5 space-y-6">
                
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-xs uppercase font-bold text-slate-400 block">Nivel Contratado</span>
                        <h2 class="font-serif text-2xl font-bold text-slate-900">Plan Plus</h2>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                        Activo
                    </span>
                </div>

                {{-- Datos Clave --}}
                <div class="space-y-4 text-xs">
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#F8FAFC]">
                        <span class="text-slate-500 font-semibold">Costo Mensual:</span>
                        <strong class="text-sm font-bold text-[#1E6F9F]">$25 USD / mes</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#F8FAFC]">
                        <span class="text-slate-500 font-semibold">Fecha de Inicio:</span>
                        <strong class="text-sm font-bold text-slate-800">01 Feb 2026</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#F8FAFC]">
                        <span class="text-slate-500 font-semibold">Fecha de Renovación:</span>
                        <strong class="text-sm font-bold text-slate-800">01 Mar 2026</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#F8FAFC]">
                        <span class="text-slate-500 font-semibold">Cupo Anual de Consultas:</span>
                        <strong class="text-sm font-bold text-[#9F7AEA]">6 Consultas (6 Disponibles)</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#F8FAFC]">
                        <span class="text-slate-500 font-semibold">Método de Facturación:</span>
                        <strong class="text-xs font-bold text-slate-800">Pago Móvil Verificado</strong>
                    </div>
                </div>

                {{-- Botón Modal Solicitud --}}
                <div class="pt-2">
                    <button type="button"
                            @click="modalExtension = true"
                            class="w-full py-3.5 px-5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] shadow-md hover:shadow-xl transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-edit text-xs"></i>
                        <span>Solicitar Extensión / Modificar Pago</span>
                    </button>
                </div>
            </div>

            {{-- Columna Derecha: Beneficios Incluidos --}}
            <div class="lg:col-span-7 bg-white rounded-3xl p-7 sm:p-8 border border-slate-200/90 shadow-xl shadow-slate-900/5">
                
                <div class="mb-6">
                    <h3 class="font-serif text-2xl font-bold text-slate-900">
                        Beneficios y Coberturas Incluidas
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Todo lo que tu membresía cubre sin costo adicional o con descuento preferencial.
                    </p>
                </div>

                <div class="space-y-4">
                    
                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 flex items-start gap-3.5">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5 text-xs">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-sm text-slate-900 block font-bold">6 Consultas Anuales de Revisión y Diagnóstico</strong>
                            <span class="text-xs text-slate-500">Incluye evaluación clínica completa, odontograma digital y chequeo de salud gingival.</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 flex items-start gap-3.5">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5 text-xs">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-sm text-slate-900 block font-bold">Profilaxis y Destartraje Ultrasónico</strong>
                            <span class="text-xs text-slate-500">Limpieza profunda con tecnología piezoeléctrica para eliminar tártaro y manchas superficiales.</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 flex items-start gap-3.5">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5 text-xs">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-sm text-slate-900 block font-bold">2 Restauraciones Simples al Año (Resinas)</strong>
                            <span class="text-xs text-slate-500">Tratamiento estético de caries con resina fotocurada de alta durabilidad sin cargo adicional.</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 flex items-start gap-3.5">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5 text-xs">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-sm text-slate-900 block font-bold">1 Prótesis Básica Cubierta</strong>
                            <span class="text-xs text-slate-500">Cobertura de confección o ajuste protésico según indicación del rehabilitador.</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 flex items-start gap-3.5">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5 text-xs">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong class="text-sm text-slate-900 block font-bold">Tarifas Preferenciales en Ortodoncia y Cirugía</strong>
                            <span class="text-xs text-slate-500">Descuentos exclusivos de hasta 30% en alineadores invisibles, brackets y extracción de cordales.</span>
                        </div>
                    </div>

                </div>

                {{-- Leyenda Legal Obligatoria --}}
                <div class="mt-8 pt-4 border-t border-slate-100">
                    <p class="text-xs text-slate-400 italic">
                        * Plan de membresía dental. No es un seguro médico.
                    </p>
                </div>

            </div>

        </div>

    </main>

    {{-- Modal Solicitar Extensión / Modificar Pago (Alpine.js) --}}
    <div x-show="modalExtension"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="modalExtension = false"
             class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <div>
                    <h3 class="font-serif text-2xl font-bold text-slate-900">Gestión de Membresía</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Contacta con el equipo administrativo del centro.</p>
                </div>
                <button type="button" @click="modalExtension = false" class="text-slate-400 hover:text-slate-700 text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form @submit.prevent="enviarPeticion()" class="space-y-4 text-sm">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Tipo de Solicitud
                    </label>
                    <select x-model="tipoPeticion" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm outline-none focus:border-[#1E6F9F]">
                        <option value="extension">Extensión o Pausa Temporal de Póliza</option>
                        <option value="pago">Modificar Datos de Pago Móvil</option>
                        <option value="upgrade">Mejorar a Plan Premium ($40/mes)</option>
                        <option value="baja">Solicitar Cancelación de Plan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Mensaje o Explicación para el Administrador
                    </label>
                    <textarea x-model="mensajeAdmin"
                              rows="4"
                              required
                              placeholder="Indica el motivo de tu solicitud o el ajuste que requieres en tu suscripción..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm outline-none focus:border-[#1E6F9F]"></textarea>
                </div>

                <div class="p-3.5 rounded-xl bg-blue-50/70 border border-blue-100 text-xs text-[#1E6F9F]">
                    Un coordinador administrativo responderá tu solicitud a través de correo electrónico o WhatsApp (+58 422 0584267) en menos de 24 horas.
                </div>

                <div class="pt-3 flex items-center justify-end gap-3">
                    <button type="button" @click="modalExtension = false" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                        Cerrar
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#1E6F9F] text-white text-xs font-bold hover:bg-[#16567C] shadow-md transition">
                        Enviar Solicitud
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- Toast Notificación (Alpine.js) --}}
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
        <span>Tu solicitud ha sido enviada al administrador con éxito.</span>
    </div>

    {{-- Footer Simple --}}
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        <p>© 2026 Odontología Especializada · Plan de Membresía Dental de 6 Consultas Anuales.</p>
    </footer>

</body>
</html>