<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Historial Clínico | Odontología Especializada</title>

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
      x-data="{ mobileSidebar: false }">

    {{-- Header / Top Navbar --}}
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
                        <span class="block text-[10px] uppercase font-bold tracking-widest text-slate-400 -mt-1">Expediente Clínico</span>
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
                <a href="/historial-clinico" class="px-4 py-2 rounded-xl text-[#1E6F9F] bg-blue-50/80 font-bold transition">
                    <i class="fas fa-notes-medical mr-2 text-xs"></i>Mi Historial
                </a>
                <a href="/mi-plan" class="px-4 py-2 rounded-xl text-slate-600 hover:text-[#1E6F9F] hover:bg-slate-50 transition">
                    <i class="fas fa-shield-alt mr-2 text-xs"></i>Mi Plan
                </a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="/dashboard-paciente" class="text-xs font-bold text-slate-600 hover:text-[#1E6F9F] flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i>
                    <span class="hidden sm:inline">Volver al Dashboard</span>
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
            <a href="/historial-clinico" class="block py-2.5 px-3 rounded-xl font-bold text-[#1E6F9F] bg-blue-50">
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

    {{-- Contenedor Principal --}}
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full flex-1">
        
        {{-- Encabezado de la Sección --}}
        <div class="mb-10 text-center sm:text-left flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#1E6F9F] bg-blue-50 px-3 py-1 rounded-full border border-blue-100 mb-2">
                    Registro de Procedimientos
                </span>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900">
                    Mi Historial Clínico
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Histórico digital de diagnósticos, profilaxis y tratamientos realizados bajo tu membresía dental.
                </p>
            </div>

            <a href="/agendar-cita" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#1E6F9F] hover:bg-[#16567C] text-white text-xs font-bold shadow-md transition self-start sm:self-auto">
                <i class="fas fa-calendar-plus"></i>
                <span>Nueva Cita</span>
            </a>
        </div>

        {{-- Timeline de Consultas Realizadas --}}
        <div class="space-y-6 relative before:absolute before:inset-0 before:left-8 sm:before:left-9 before:w-0.5 before:bg-slate-200 before:pointer-events-none">
            
            {{-- Registro 1 --}}
            <div class="relative flex items-start gap-5 sm:gap-6">
                <div class="w-16 sm:w-18 flex-shrink-0 flex items-center justify-center">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-[#1E6F9F] to-[#9F7AEA] text-white flex items-center justify-center text-sm shadow-md ring-4 ring-white z-10">
                        <i class="fas fa-teeth"></i>
                    </div>
                </div>

                <div class="flex-1 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xl shadow-slate-900/5 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100 mb-4">
                        <div>
                            <span class="text-xs font-bold text-[#1E6F9F] uppercase tracking-wider">12 Enero 2026 · 10:00 AM</span>
                            <h3 class="font-serif text-xl font-bold text-slate-900 mt-0.5">
                                Limpieza Dental Profunda y Profilaxis Ultrasónica
                            </h3>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap self-start">
                            <i class="fas fa-check-circle mr-1.5"></i> Cubierta por membresía
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs mb-4">
                        <div>
                            <span class="text-slate-400 block uppercase font-bold text-[10px]">Especialista</span>
                            <strong class="text-slate-800 text-sm">Dra. Valentina Rosas (Periodoncia)</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block uppercase font-bold text-[10px]">Piezas / Área</span>
                            <strong class="text-slate-800 text-sm">Arcada Superior e Inferior Completa</strong>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-[#F8FAFC] border border-slate-100 text-xs text-slate-600 leading-relaxed">
                        <strong class="text-slate-800 block mb-1 font-semibold flex items-center gap-1.5">
                            <i class="fas fa-comment-medical text-[#1E6F9F]"></i> Observaciones del Doctor:
                        </strong>
                        Se retiró tártaro supragingival de manera exitosa. Esmalte en excelentes condiciones sin presencia de caries activa. Se aplicó barniz de flúor preventivo. Paciente toleró el procedimiento sin molestias.
                    </div>
                </div>
            </div>

            {{-- Registro 2 --}}
            <div class="relative flex items-start gap-5 sm:gap-6">
                <div class="w-16 sm:w-18 flex-shrink-0 flex items-center justify-center">
                    <div class="w-10 h-10 rounded-2xl bg-purple-100 text-[#9F7AEA] flex items-center justify-center text-sm shadow-md ring-4 ring-white z-10">
                        <i class="fas fa-x-ray"></i>
                    </div>
                </div>

                <div class="flex-1 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xl shadow-slate-900/5 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100 mb-4">
                        <div>
                            <span class="text-xs font-bold text-[#9F7AEA] uppercase tracking-wider">05 Diciembre 2025 · 03:30 PM</span>
                            <h3 class="font-serif text-xl font-bold text-slate-900 mt-0.5">
                                Diagnóstico Integral 3D y Radiografía Panorámica
                            </h3>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap self-start">
                            <i class="fas fa-check-circle mr-1.5"></i> Cubierta por membresía
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs mb-4">
                        <div>
                            <span class="text-slate-400 block uppercase font-bold text-[10px]">Especialista</span>
                            <strong class="text-slate-800 text-sm">Dr. Alejandro Morales (Rehabilitación Oral)</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block uppercase font-bold text-[10px]">Estudio Realizado</span>
                            <strong class="text-slate-800 text-sm">Ortopantomografía Digital + Odontograma</strong>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-[#F8FAFC] border border-slate-100 text-xs text-slate-600 leading-relaxed">
                        <strong class="text-slate-800 block mb-1 font-semibold flex items-center gap-1.5">
                            <i class="fas fa-comment-medical text-[#9F7AEA]"></i> Observaciones del Doctor:
                        </strong>
                        Estructura ósea maxilar y mandibular sin alteraciones quísticas. Mordida clase I funcional. Se abre historia clínica digital inicial vinculada a la membresía anual.
                    </div>
                </div>
            </div>

        </div>

        {{-- Resumen de Consumo Anual al Final --}}
        <div class="mt-12 bg-gradient-to-r from-blue-50/90 via-purple-50/60 to-blue-50/90 rounded-3xl p-8 border border-[#1E6F9F]/20 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4 text-center sm:text-left">
                <div class="w-16 h-16 rounded-2xl bg-[#1E6F9F] text-white flex items-center justify-center text-2xl flex-shrink-0 shadow-md">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                    <span class="text-xs uppercase font-bold tracking-wider text-slate-500">Balance del Periodo 2026</span>
                    <h2 class="font-serif text-2xl font-bold text-slate-900 mt-0.5">
                        Total de consultas usadas este año: 2 de 6
                    </h2>
                    <p class="text-xs text-slate-600 mt-1">
                        Aún dispones de <strong>4 consultas anuales</strong> para limpieza, profilaxis o revisión diagnóstica.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="/agendar-cita" class="px-6 py-3.5 rounded-xl bg-[#1E6F9F] hover:bg-[#16567C] text-white text-xs font-bold shadow-md hover:shadow-lg transition">
                    Usar mi Próxima Consulta
                </a>
            </div>
        </div>

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        <p>© 2026 Odontología Especializada · Tu información médica está protegida con estándares de privacidad y confidencialidad.</p>
    </footer>

</body>
</html>