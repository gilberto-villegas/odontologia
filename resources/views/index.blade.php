<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- SEO y Metadatos --}}
    <title>@yield('title', 'Odontología Especializada | Plan de Membresía Dental 6 Consultas Anuales')</title>
    <meta name="description" content="@yield('meta_description', 'Plan de membresía dental con 6 consultas anuales, profilaxis, diagnóstico integral y tarifas preferenciales. Tu salud bucal en manos de especialistas.')">
    <meta property="og:title" content="@yield('og_title', 'Plan de Membresía Dental - Odontología Especializada')">
    <meta property="og:description" content="@yield('og_description', 'Tu sonrisa, nuestra prioridad. Cobertura dental continua y accesible.')">
    <meta property="og:image" content="@yield('og_image', 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1200&q=80')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">

    {{-- Tipografías Editoriales de Google Fonts: Playfair Display + Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Swiper.js CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    {{-- Font Awesome (como en robert/index.html) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Tailwind CSS CDN con configuración personalizada y fallback --}}
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

    {{-- Estilos Vite de la app si están presentes --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    {{-- Estilos Globales, Keyframes y Micro-interacciones (Integrados directamente para funcionar sin Vite) --}}
    <style>
        :root {
            --color-dental-blue: #1E6F9F;
            --color-dental-lilac: #C8B6E2;
            --color-dental-lilac-dark: #9F7AEA;
            --deepBlue: #0F3A54;
            --brightBlue: #1E6F9F;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
            background-color: #FFFFFF;
        }

        h1, h2, h3, .font-serif-heading {
            font-family: 'Playfair Display', Georgia, serif;
            letter-spacing: -0.02em;
        }

        /* 1. Flotación orgánica del diente (toothFloat de robert) */
        @keyframes toothFloat {
            0% { transform: translateY(0px) rotate(0deg) scale(1); }
            25% { transform: translateY(-7px) rotate(-6deg) scale(1.05); }
            50% { transform: translateY(0px) rotate(0deg) scale(1); }
            75% { transform: translateY(-4px) rotate(6deg) scale(1.02); }
            100% { transform: translateY(0px) rotate(0deg) scale(1); }
        }

        .tooth-icon {
            display: inline-block;
            animation: toothFloat 3.5s ease-in-out infinite;
        }

        /* 2. Pulso expansivo en ondas para el botón de WhatsApp (pulse-whatsapp de robert) */
        @keyframes pulse-blue-glow {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(30, 111, 159, 0.7);
            }
            70% {
                transform: scale(1.03);
                box-shadow: 0 0 0 22px rgba(30, 111, 159, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(30, 111, 159, 0);
            }
        }

        .pulse-whatsapp {
            animation: pulse-blue-glow 2.5s infinite;
        }

        /* 3. Fondo dinámico animado con gradiente (gradientShift de robert) */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .bg-animated-mesh {
            background: linear-gradient(135deg, #FFFFFF 0%, #F0F6FA 50%, #FAF7FD 100%);
            background-size: 300% 300%;
            animation: gradientShift 14s ease infinite;
        }

        /* 4. Tarjetas Glassmorphism (glass-card de robert adaptada a los colores) */
        .glass-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(200, 182, 226, 0.35);
            box-shadow: 0 8px 30px rgba(30, 111, 159, 0.07);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 22px 44px rgba(30, 111, 159, 0.16);
            border-color: #9F7AEA;
            background: rgba(255, 255, 255, 0.98);
        }

        /* Gradientes corporativos */
        .blue-gradient {
            background: linear-gradient(135deg, #1E6F9F 0%, #0F3A54 100%);
        }

        /* Keyframes de fade y zoom */
        @keyframes fade-up {
            0% {
                opacity: 0;
                transform: translateY(28px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes pulse-soft {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.08);
            }
        }

        @keyframes ken-burns {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.12);
            }
        }

        .animate-fade-up {
            animation: fade-up 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }

        .animate-pulse-soft {
            animation: pulse-soft 2.6s ease-in-out infinite;
        }

        /* Efecto Ken Burns para imágenes activas en Swiper */
        .swiper-slide-active .ken-burns-img {
            animation: ken-burns 8s ease-out forwards;
        }

        /* Scroll Reveal con IntersectionObserver */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Línea que crece en enlaces editoriales */
        .editorial-link {
            position: relative;
            display: inline-block;
        }

        .editorial-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: -3px;
            left: 0;
            background: linear-gradient(90deg, #1E6F9F, #9F7AEA);
            transform-origin: bottom right;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .editorial-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* Botón con efecto de brillo Shimmer */
        .btn-shimmer {
            position: relative;
            overflow: hidden;
        }

        .btn-shimmer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: skewX(-20deg);
            transition: none;
        }

        .btn-shimmer:hover::before {
            left: 140%;
            transition: all 0.75s ease-in-out;
        }

        /* Bullets personalizados Swiper */
        .swiper-pagination-bullet {
            background: #FFFFFF !important;
            opacity: 0.6 !important;
            width: 10px !important;
            height: 10px !important;
            margin: 0 5px !important;
            transition: all 0.4s ease !important;
        }

        .swiper-pagination-bullet-active {
            background: #C8B6E2 !important;
            opacity: 1 !important;
            width: 32px !important;
            border-radius: 9999px !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    {{-- Alpine.js vía CDN --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    {{-- Swiper.js vía CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>
<body class="bg-animated-mesh text-slate-700 antialiased selection:bg-[#C8B6E2] selection:text-[#1E6F9F] overflow-x-hidden"
      x-data="{
          scrolled: false,
          mobileMenuOpen: false
      }"
      @scroll.window="scrolled = (window.pageYOffset > 25)">

    {{-- Toast de éxito para contacto --}}
    @if(session('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 7000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-4 sm:translate-y-0 sm:translate-x-4"
             x-transition:enter-end="opacity-100 transform translate-y-0 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed bottom-6 left-6 z-50 max-w-md bg-white border-l-4 border-emerald-500 rounded-2xl shadow-2xl p-4 flex items-start gap-3"
             role="alert">
            <div class="text-emerald-500 flex-shrink-0 mt-0.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-bold text-slate-900 text-sm">¡Consulta Recibida!</p>
                <p class="text-sm text-slate-600 mt-0.5">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-slate-400 hover:text-slate-700 transition" aria-label="Cerrar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Sección 1: Navbar sticky que cambia de transparente a blanco con blur al hacer scroll --}}
    <header class="fixed top-0 left-0 right-0 z-40 transition-all duration-500"
            :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md shadow-slate-900/5 py-3.5 border-b border-slate-100' : 'bg-transparent py-6'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                
                {{-- Logo Editorial con animación tooth-icon --}}
                <a href="#inicio" class="flex items-center gap-3.5 group focus:outline-none">
                    <div class="tooth-icon w-11 h-11 rounded-2xl bg-gradient-to-br from-[#1E6F9F] via-[#1E6F9F] to-[#9F7AEA] flex items-center justify-center text-white shadow-lg shadow-blue-900/20 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M18.8 6.5C18.2 4.4 16.7 3 14.8 3c-1.3 0-2.2.7-2.8 1.4C11.4 3.7 10.5 3 9.2 3 7.3 3 5.8 4.4 5.2 6.5 4.3 9.5 4.9 14.1 6.8 17.5c1.1 2 2.7 3.5 4 3.5.7 0 1.2-.5 1.2-1.5 0-1.2.4-2.5 1-2.5s1 1.3 1 2.5c0 1 .5 1.5 1.2 1.5 1.3 0 2.9-1.5 4-3.5 1.9-3.4 2.5-8 1.6-11z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-tight" :class="scrolled ? 'text-[#1E6F9F]' : 'text-white drop-shadow-md'">
                            Odontología <span class="text-[#C8B6E2] font-semibold italic">Salud</span>
                        </span>
                        <span class="block text-[10px] uppercase font-bold tracking-widest -mt-1" :class="scrolled ? 'text-slate-400' : 'text-slate-200'">
                            Centro Clínico Dental
                        </span>
                    </div>
                </a>

                {{-- Links Desktop con línea animada --}}
                <nav class="hidden md:flex items-center gap-8" aria-label="Navegación principal">
                    <a href="#inicio" class="editorial-link text-sm font-semibold transition" :class="scrolled ? 'text-slate-700 hover:text-[#1E6F9F]' : 'text-white/95 hover:text-white drop-shadow'">Inicio</a>
                    <a href="#quienes-somos" class="editorial-link text-sm font-semibold transition" :class="scrolled ? 'text-slate-700 hover:text-[#1E6F9F]' : 'text-white/95 hover:text-white drop-shadow'">Quiénes Somos</a>
                    <a href="#servicios" class="editorial-link text-sm font-semibold transition" :class="scrolled ? 'text-slate-700 hover:text-[#1E6F9F]' : 'text-white/95 hover:text-white drop-shadow'">Servicios</a>
                    <a href="#plan" class="editorial-link text-sm font-semibold transition" :class="scrolled ? 'text-slate-700 hover:text-[#1E6F9F]' : 'text-white/95 hover:text-white drop-shadow'">Planes</a>
                    <a href="#horarios" class="editorial-link text-sm font-semibold transition" :class="scrolled ? 'text-slate-700 hover:text-[#1E6F9F]' : 'text-white/95 hover:text-white drop-shadow'">Horarios</a>
                    <a href="#contacto" class="editorial-link text-sm font-semibold transition" :class="scrolled ? 'text-slate-700 hover:text-[#1E6F9F]' : 'text-white/95 hover:text-white drop-shadow'">Contacto</a>
                </nav>

                {{-- CTA Desktop con Iniciar Sesión y "Afíliate ahora" --}}
                <div class="hidden md:flex items-center gap-5">
                    <a href="/login"
                       class="text-sm font-semibold transition"
                       :class="scrolled ? 'text-slate-700 hover:text-[#1E6F9F]' : 'text-white/95 hover:text-white drop-shadow'">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('registro') }}"
                       class="btn-shimmer inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-[#1E6F9F] to-[#175b83] hover:from-[#1E6F9F] hover:to-[#9F7AEA] rounded-full shadow-lg shadow-blue-900/15 hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <span>Afíliate ahora</span>
                        <svg class="w-4 h-4 ml-1.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                {{-- Menú hamburguesa móvil --}}
                <div class="flex md:hidden">
                    <button type="button"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="p-2 rounded-xl focus:outline-none transition-colors"
                            :class="scrolled ? 'text-slate-700 hover:bg-slate-100' : 'text-white hover:bg-white/10'"
                            aria-label="Abrir menú de navegación">
                        <svg x-show="!mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

            </div>
        </div>

        {{-- Desplegable Móvil --}}
        <div x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden bg-white/95 backdrop-blur-xl border-b border-slate-200 shadow-2xl px-6 pt-4 pb-8 space-y-4">
            <a href="#inicio" @click="mobileMenuOpen = false" class="block py-2 text-base font-semibold text-slate-800 hover:text-[#1E6F9F]">Inicio</a>
            <a href="#quienes-somos" @click="mobileMenuOpen = false" class="block py-2 text-base font-semibold text-slate-800 hover:text-[#1E6F9F]">Quiénes Somos</a>
            <a href="#servicios" @click="mobileMenuOpen = false" class="block py-2 text-base font-semibold text-slate-800 hover:text-[#1E6F9F]">Servicios</a>
            <a href="#plan" @click="mobileMenuOpen = false" class="block py-2 text-base font-semibold text-slate-800 hover:text-[#1E6F9F]">Planes de Membresía</a>
            <a href="#horarios" @click="mobileMenuOpen = false" class="block py-2 text-base font-semibold text-slate-800 hover:text-[#1E6F9F]">Horarios</a>
            <a href="#contacto" @click="mobileMenuOpen = false" class="block py-2 text-base font-semibold text-slate-800 hover:text-[#1E6F9F]">Contacto</a>
            <div class="pt-2 space-y-2.5">
                <a href="/login"
                   @click="mobileMenuOpen = false"
                   class="w-full inline-block text-center py-2.5 px-6 text-sm font-bold text-slate-700 hover:text-[#1E6F9F] border border-slate-200 rounded-full transition-all">
                    Iniciar Sesión
                </a>
                <a href="{{ route('registro') }}"
                   @click="mobileMenuOpen = false"
                   class="w-full inline-block text-center py-3.5 px-6 text-base font-bold text-white bg-[#1E6F9F] hover:bg-[#9F7AEA] rounded-full shadow-lg transition-all">
                    Afíliate ahora
                </a>
            </div>
        </div>
    </header>

    {{-- Sección 2: Hero con Carrusel de Imágenes Realistas (Unsplash) y Efecto Ken Burns --}}
    <section id="inicio" class="relative min-h-[680px] lg:min-h-screen flex items-center justify-center overflow-hidden">
        
        {{-- Swiper con efecto Ken Burns y fotos odontológicas de alta resolución --}}
        <div class="swiper heroSwiper absolute inset-0 w-full h-full z-0">
            <div class="swiper-wrapper">
                
                {{-- Slide 1: Técnica 4x2 --}}
                <div class="swiper-slide relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1920&q=80"
                         alt="Instalaciones clínicas de odontología moderna"
                         class="ken-burns-img w-full h-full object-cover">
                    {{-- Banner badge superpuesto estilo clínica de alta gama --}}
                    <div class="absolute top-28 left-6 sm:left-12 lg:left-20 z-20">
                        <span class="inline-block px-5 py-2 rounded-lg bg-[#1E6F9F] text-white text-xs sm:text-sm font-extrabold uppercase tracking-widest shadow-xl border-l-4 border-[#C8B6E2]">
                            TÉCNICA 4X2
                        </span>
                    </div>
                </div>

                {{-- Slide 2: Cirugía Bucal --}}
                <div class="swiper-slide relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=1920&q=80"
                         alt="Cirugía bucal y rehabilitación dental especializada"
                         class="ken-burns-img w-full h-full object-cover">
                    <div class="absolute top-28 left-6 sm:left-12 lg:left-20 z-20">
                        <span class="inline-block px-5 py-2 rounded-lg bg-[#1E6F9F] text-white text-xs sm:text-sm font-extrabold uppercase tracking-widest shadow-xl border-l-4 border-[#C8B6E2]">
                            CIRUGÍA BUCAL
                        </span>
                    </div>
                </div>

                {{-- Slide 3: Endodoncia --}}
                <div class="swiper-slide relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&w=1920&q=80"
                         alt="Tratamiento de endodoncia avanzada sin dolor"
                         class="ken-burns-img w-full h-full object-cover">
                    <div class="absolute top-28 left-6 sm:left-12 lg:left-20 z-20">
                        <span class="inline-block px-5 py-2 rounded-lg bg-[#1E6F9F] text-white text-xs sm:text-sm font-extrabold uppercase tracking-widest shadow-xl border-l-4 border-[#C8B6E2]">
                            ENDODONCIA
                        </span>
                    </div>
                </div>

                {{-- Slide 4: Diseño de Sonrisa --}}
                <div class="swiper-slide relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=1920&q=80"
                         alt="Diseño de sonrisa y estética dental de precisión"
                         class="ken-burns-img w-full h-full object-cover">
                    <div class="absolute top-28 left-6 sm:left-12 lg:left-20 z-20">
                        <span class="inline-block px-5 py-2 rounded-lg bg-[#1E6F9F] text-white text-xs sm:text-sm font-extrabold uppercase tracking-widest shadow-xl border-l-4 border-[#C8B6E2]">
                            DISEÑO DE SONRISA
                        </span>
                    </div>
                </div>

            </div>

            {{-- Indicadores personalizados --}}
            <div class="swiper-pagination !bottom-10 z-20"></div>
        </div>

        {{-- Overlay Degradado Suave y Profesional (#1E6F9F/80 a #0F3A54/85) --}}
        <div class="absolute inset-0 bg-gradient-to-r from-[#0F3A54]/85 via-[#1E6F9F]/75 to-[#0F3A54]/85 z-10 pointer-events-none"></div>

        {{-- Contenido Hero Editorial Centrado con animación fade-up --}}
        <div class="relative z-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center text-white animate-fade-up">
            
            <div class="inline-flex items-center gap-2.5 px-5 py-1.5 rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-white text-xs sm:text-sm font-semibold tracking-wider uppercase mb-8 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-[#C8B6E2] animate-ping"></span>
                <span>Programa Clínico Anual</span>
            </div>

            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-serif font-bold text-white tracking-tight leading-[1.1] drop-shadow-lg">
                Tu sonrisa, <span class="italic font-normal text-[#C8B6E2]">nuestra prioridad</span>
            </h1>

            <p class="mt-6 text-lg sm:text-xl lg:text-2xl text-slate-100 max-w-2xl mx-auto font-light leading-relaxed drop-shadow">
                Plan de membresía dental con <strong class="text-white font-semibold">6 consultas anuales</strong>. Cobertura integral continua, precio accesible.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-5">
                {{-- Botón Ver el Plan (lila) --}}
                <a href="#plan"
                   class="btn-shimmer w-full sm:w-auto px-9 py-4 text-sm font-bold text-slate-900 bg-[#C8B6E2] hover:bg-[#9F7AEA] hover:text-white rounded-full shadow-xl hover:scale-105 transition-all duration-300 text-center">
                    Ver el Plan
                </a>

                {{-- Botón Afiliarme (Redirige a /registro) --}}
                <a href="{{ route('registro') }}"
                   class="btn-shimmer w-full sm:w-auto px-9 py-4 text-sm font-bold text-white bg-transparent border-2 border-white/90 hover:bg-white hover:text-[#1E6F9F] rounded-full shadow-lg hover:scale-105 transition-all duration-300 text-center">
                    Afiliarme en Línea
                </a>
            </div>

            {{-- Trust Badges --}}
            <div class="mt-14 pt-8 border-t border-white/15 flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-xs sm:text-sm text-slate-200">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#C8B6E2]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Sin listas de espera
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#C8B6E2]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Afiliación digital instantánea
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#C8B6E2]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Especialistas certificados
                </span>
            </div>

        </div>
    </section>

    {{-- Sección 3: Quiénes Somos (2 Columnas con Trayectoria y Fotografía Clínica) --}}
    <section id="quienes-somos" class="py-28 bg-[#F8FAFC] reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                {{-- Columna Imagen Representativa --}}
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <div class="absolute -inset-4 bg-gradient-to-tr from-[#1E6F9F]/20 to-[#9F7AEA]/20 rounded-3xl blur-2xl -z-10"></div>
                        <img src="https://images.unsplash.com/photo-1629909615184-74f495363b67?auto=format&fit=crop&w=1000&q=80"
                             alt="Equipo médico y trayectoria del centro odontológico"
                             class="rounded-3xl shadow-2xl object-cover w-full h-[460px] border-4 border-white">
                        <div class="absolute -bottom-6 -right-6 bg-white p-5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-4 hidden sm:flex">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center font-bold text-xl">
                                12+
                            </div>
                            <div>
                                <p class="text-xs uppercase font-extrabold text-slate-400">Años de</p>
                                <p class="text-sm font-bold text-slate-900">Trayectoria Clínica</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Columna Texto Persuasivo --}}
                <div class="lg:col-span-7 space-y-6">
                    <span class="text-xs uppercase tracking-widest font-extrabold text-[#1E6F9F] bg-blue-50 px-4 py-1.5 rounded-full inline-block">
                        Quiénes Somos
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900 leading-tight">
                        Más de una década transformando sonrisas con vocación y ciencia
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                        Nacimos con la firme convicción de que la salud bucal no debe ser un servicio reservado únicamente para momentos de urgencia o dolor, sino un programa preventivo continuo, digno y accesible para toda la familia.
                    </p>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        A lo largo de más de 12 años, nuestro centro odontológico ha consolidado un modelo asistencial que combina aparatología diagnóstica digital de última generación con un trato humano, cordial y personalizado. Cada tratamiento es abordado por especialistas certificados en ortodoncia, cirugía bucal, prótesis y estética, asegurando resultados clínicos predecibles y duraderos.
                    </p>

                    <div class="pt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-900">Especialistas Certificados</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Equipo colegiado con formación clínica continua.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-900">Bioseguridad de Punta</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Protocolos rigurosos de esterilización en cada cita.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3">
                        <a href="#plan"
                           class="btn-shimmer inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold text-white bg-[#1E6F9F] hover:bg-[#9F7AEA] rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <span>Conoce Nuestros Planes</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Sección 4: ¿Qué nos hace diferentes? (3 bloques editoriales con número grande) --}}
    <section class="py-28 bg-white relative reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-xs uppercase tracking-widest font-extrabold text-[#1E6F9F] bg-blue-50 px-4 py-1.5 rounded-full inline-block mb-3">
                    Estándar Clínico Superior
                </span>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900">
                    ¿Qué nos hace diferentes?
                </h2>
                <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                    Más que tratamientos aislados, ofrecemos un modelo de acompañamiento odontológico centrado en tu tranquilidad.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                
                {{-- Bloque 1 --}}
                <div class="relative bg-white border border-slate-200/90 rounded-3xl p-9 sm:p-11 shadow-sm hover:shadow-2xl hover:-translate-y-2 hover:border-[#1E6F9F] transition-all duration-300 group">
                    <div class="font-serif text-6xl sm:text-7xl font-bold text-[#C8B6E2]/40 group-hover:text-[#9F7AEA]/50 transition-colors select-none">
                        01
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center my-5 group-hover:bg-[#1E6F9F] group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-slate-900 mb-3">
                        Atención personalizada
                    </h3>
                    <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                        Cada paciente es único. Ofrecemos un contacto cercano, cordial y sin prisas, diseñando esquemas de tratamiento ajustados a tu perfil biológico y estilo de vida.
                    </p>
                </div>

                {{-- Bloque 2 --}}
                <div class="relative bg-white border border-slate-200/90 rounded-3xl p-9 sm:p-11 shadow-sm hover:shadow-2xl hover:-translate-y-2 hover:border-[#1E6F9F] transition-all duration-300 group">
                    <div class="font-serif text-6xl sm:text-7xl font-bold text-[#C8B6E2]/40 group-hover:text-[#9F7AEA]/50 transition-colors select-none">
                        02
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center my-5 group-hover:bg-[#1E6F9F] group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-slate-900 mb-3">
                        Diagnóstico integral
                    </h3>
                    <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                        Evaluación completa con radiografía panorámica y escaneo intraoral desde tu primera cita para detectar cualquier patología a tiempo con absoluta exactitud.
                    </p>
                </div>

                {{-- Bloque 3 --}}
                <div class="relative bg-white border border-slate-200/90 rounded-3xl p-9 sm:p-11 shadow-sm hover:shadow-2xl hover:-translate-y-2 hover:border-[#1E6F9F] transition-all duration-300 group">
                    <div class="font-serif text-6xl sm:text-7xl font-bold text-[#C8B6E2]/40 group-hover:text-[#9F7AEA]/50 transition-colors select-none">
                        03
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center my-5 group-hover:bg-[#1E6F9F] group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-slate-900 mb-3">
                        Control y seguimiento
                    </h3>
                    <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                        Monitoreo clínico continuo y recordatorios programados hasta culminar exitosamente tu tratamiento, garantizando una sonrisa saludable y perdurable.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- Sección 5: Sección de Servicios y Especialidades --}}
    <section id="servicios" class="py-28 bg-[#F8FAFC] reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-xs uppercase tracking-widest font-extrabold text-[#1E6F9F] bg-blue-50 px-4 py-1.5 rounded-full inline-block mb-3">
                    Especialidades Clínicas
                </span>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900">
                    Servicios y Especialidades
                </h2>
                <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                    Un equipo multidisciplinario altamente calificado para resolver cualquier necesidad dental con equipamiento de vanguardia.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                
                {{-- Tarjeta 1 --}}
                <a href="https://wa.me/584220584267?text=Hola%2C%20deseo%20agendar%20mi%20consulta%20para%20el%20servicio%20de%3A%20Ortodoncia%20Especializada" 
                   target="_blank" rel="noopener"
                   class="glass-card rounded-3xl p-8 transition-all duration-300 group flex flex-col justify-between hover:-translate-y-2 hover:shadow-2xl hover:border-[#1E6F9F]/40">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-[#1E6F9F] group-hover:text-white transition-all">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-slate-900 mb-2 group-hover:text-[#1E6F9F] transition-colors">Ortodoncia Especializada</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Alineación dental anatómica con brackets metálicos, estéticos de zafiro y alineadores invisibles.</p>
                    </div>
                    <div class="pt-5 flex items-center gap-2 text-xs font-bold text-[#1E6F9F] group-hover:text-[#9F7AEA] transition-colors">
                        <i class="fab fa-whatsapp text-emerald-500 text-sm"></i>
                        <span>Agendar Consulta</span>
                        <i class="fas fa-arrow-right text-[10px] ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- Tarjeta 2 --}}
                <a href="https://wa.me/584220584267?text=Hola%2C%20deseo%20agendar%20mi%20consulta%20para%20el%20servicio%20de%3A%20Dise%C3%B1o%20de%20Sonrisa" 
                   target="_blank" rel="noopener"
                   class="glass-card rounded-3xl p-8 transition-all duration-300 group flex flex-col justify-between hover:-translate-y-2 hover:shadow-2xl hover:border-[#1E6F9F]/40">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-[#1E6F9F] group-hover:text-white transition-all">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-slate-900 mb-2 group-hover:text-[#1E6F9F] transition-colors">Diseño de Sonrisa</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Carillas cerámicas y resinas estratificadas para devolver armonía, simetría y luminosidad a tu sonrisa.</p>
                    </div>
                    <div class="pt-5 flex items-center gap-2 text-xs font-bold text-[#1E6F9F] group-hover:text-[#9F7AEA] transition-colors">
                        <i class="fab fa-whatsapp text-emerald-500 text-sm"></i>
                        <span>Agendar Consulta</span>
                        <i class="fas fa-arrow-right text-[10px] ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- Tarjeta 3 --}}
                <a href="https://wa.me/584220584267?text=Hola%2C%20deseo%20agendar%20mi%20consulta%20para%20el%20servicio%20de%3A%20Implantes%20y%20Rehabilitaci%C3%B3n" 
                   target="_blank" rel="noopener"
                   class="glass-card rounded-3xl p-8 transition-all duration-300 group flex flex-col justify-between hover:-translate-y-2 hover:shadow-2xl hover:border-[#1E6F9F]/40">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-[#1E6F9F] group-hover:text-white transition-all">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-slate-900 mb-2 group-hover:text-[#1E6F9F] transition-colors">Implantes y Rehabilitación</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Restitución de piezas dentales ausentes mediante fijación de titanio biocompatible de durabilidad vitalicia.</p>
                    </div>
                    <div class="pt-5 flex items-center gap-2 text-xs font-bold text-[#1E6F9F] group-hover:text-[#9F7AEA] transition-colors">
                        <i class="fab fa-whatsapp text-emerald-500 text-sm"></i>
                        <span>Agendar Consulta</span>
                        <i class="fas fa-arrow-right text-[10px] ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- Tarjeta 4 --}}
                <a href="https://wa.me/584220584267?text=Hola%2C%20deseo%20agendar%20mi%20consulta%20para%20el%20servicio%20de%3A%20Limpieza%20y%20Profilaxis" 
                   target="_blank" rel="noopener"
                   class="glass-card rounded-3xl p-8 transition-all duration-300 group flex flex-col justify-between hover:-translate-y-2 hover:shadow-2xl hover:border-[#1E6F9F]/40">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-[#1E6F9F] group-hover:text-white transition-all">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-slate-900 mb-2 group-hover:text-[#1E6F9F] transition-colors">Limpieza y Profilaxis</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Eliminación ultrasónica profunda de tártaro, placa subgingival, manchas y aplicación tópica de flúor.</p>
                    </div>
                    <div class="pt-5 flex items-center gap-2 text-xs font-bold text-[#1E6F9F] group-hover:text-[#9F7AEA] transition-colors">
                        <i class="fab fa-whatsapp text-emerald-500 text-sm"></i>
                        <span>Agendar Consulta</span>
                        <i class="fas fa-arrow-right text-[10px] ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- Tarjeta 5 --}}
                <a href="https://wa.me/584220584267?text=Hola%2C%20deseo%20agendar%20mi%20consulta%20para%20el%20servicio%20de%3A%20Pr%C3%B3tesis%20Dental" 
                   target="_blank" rel="noopener"
                   class="glass-card rounded-3xl p-8 transition-all duration-300 group flex flex-col justify-between hover:-translate-y-2 hover:shadow-2xl hover:border-[#1E6F9F]/40">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-[#1E6F9F] group-hover:text-white transition-all">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7zm4 4h8m-8 4h5" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-slate-900 mb-2 group-hover:text-[#1E6F9F] transition-colors">Prótesis Dental</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Prótesis fijas en zirconio o removibles flexibles para recuperar la fuerza masticatoria y la estética.</p>
                    </div>
                    <div class="pt-5 flex items-center gap-2 text-xs font-bold text-[#1E6F9F] group-hover:text-[#9F7AEA] transition-colors">
                        <i class="fab fa-whatsapp text-emerald-500 text-sm"></i>
                        <span>Agendar Consulta</span>
                        <i class="fas fa-arrow-right text-[10px] ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                {{-- Tarjeta 6 --}}
                <a href="https://wa.me/584220584267?text=Hola%2C%20deseo%20agendar%20mi%20consulta%20para%20el%20servicio%20de%3A%20Endodoncia" 
                   target="_blank" rel="noopener"
                   class="glass-card rounded-3xl p-8 transition-all duration-300 group flex flex-col justify-between hover:-translate-y-2 hover:shadow-2xl hover:border-[#1E6F9F]/40">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-[#1E6F9F] group-hover:text-white transition-all">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-serif font-bold text-slate-900 mb-2 group-hover:text-[#1E6F9F] transition-colors">Endodoncia</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Tratamientos de conductos con instrumentación rotatoria microscópica para salvar tus dientes biológicos.</p>
                    </div>
                    <div class="pt-5 flex items-center gap-2 text-xs font-bold text-[#1E6F9F] group-hover:text-[#9F7AEA] transition-colors">
                        <i class="fab fa-whatsapp text-emerald-500 text-sm"></i>
                        <span>Agendar Consulta</span>
                        <i class="fas fa-arrow-right text-[10px] ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

            </div>
        </div>
    </section>

    {{-- Sección 6: Nuestros Planes de Membresía (Rediseño a 3 Tarjetas Premium) --}}
    <section id="plan" class="py-28 bg-white relative reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-xs uppercase tracking-widest font-extrabold text-[#1E6F9F] bg-blue-50 px-4 py-1.5 rounded-full inline-block mb-3">
                    Inversión Inteligente en Salud
                </span>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900">
                    Nuestros Planes de Membresía
                </h2>
                <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                    Selecciona el nivel de cobertura que mejor se adapte a ti y a tu familia. Sin periodos de carencia y con activación inmediata.
                </p>
            </div>

            {{-- Grid de 3 Tarjetas de Planes --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
                
                {{-- Tarjeta 1: Plan Básico ($15 USD/mes) --}}
                <div class="glass-card rounded-3xl p-8 sm:p-9 flex flex-col justify-between transition-all duration-300 hover:border-[#1E6F9F] hover:-translate-y-2 hover:shadow-2xl">
                    <div>
                        <div class="inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-wider mb-4">
                            Preventivo Esencial
                        </div>
                        <h3 class="text-2xl font-serif font-bold text-slate-900 mb-2">
                            Plan Básico
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 min-h-[38px] leading-relaxed">
                            Cuidado esencial para mantener tu sonrisa limpia, controlada y sin caries.
                        </p>

                        <div class="my-6 pb-6 border-b border-slate-100 flex items-baseline gap-1">
                            <span class="text-4xl sm:text-5xl font-black text-[#1E6F9F]">$15</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-400">USD / mes</span>
                        </div>

                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600 mb-8">
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>6 consultas anuales</strong> (limpieza + revisión diagnóstica)</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>Extracciones simples</strong> cubiertas en el centro</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>Descuentos preferenciales</strong> en ortodoncia y prótesis</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span>Historia clínica digital y recordatorios</span>
                            </li>
                        </ul>
                    </div>

                    <a href="/registro?plan=basico"
                       class="btn-shimmer block w-full py-3.5 px-6 text-sm font-bold text-center text-[#1E6F9F] bg-blue-50 hover:bg-[#1E6F9F] hover:text-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300">
                        Afiliarme ahora
                    </a>
                </div>

                {{-- Tarjeta 2: Plan Plus ($25 USD/mes) - Destacado como "Más popular" --}}
                <div class="relative glass-card rounded-3xl p-8 sm:p-9 flex flex-col justify-between transition-all duration-300 border-2 !border-[#1E6F9F] shadow-2xl hover:-translate-y-2 lg:-translate-y-3 bg-gradient-to-b from-white via-white to-blue-50/40">
                    {{-- Badge Superior Destacado --}}
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-gradient-to-r from-[#1E6F9F] to-[#9F7AEA] text-white text-[11px] font-black uppercase tracking-widest py-1.5 px-6 rounded-full shadow-md whitespace-nowrap">
                        Más popular
                    </div>

                    <div>
                        <div class="inline-block px-3 py-1 rounded-full bg-[#1E6F9F]/10 text-[#1E6F9F] text-xs font-bold uppercase tracking-wider mb-4 mt-2">
                            Restaurativo Completo
                        </div>
                        <h3 class="text-2xl font-serif font-bold text-slate-900 mb-2">
                            Plan Plus
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 min-h-[38px] leading-relaxed">
                            El balance perfecto para quienes buscan prevención activa y solución de piezas dañadas.
                        </p>

                        <div class="my-6 pb-6 border-b border-slate-100 flex items-baseline gap-1">
                            <span class="text-4xl sm:text-5xl font-black text-[#1E6F9F]">$25</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-400">USD / mes</span>
                        </div>

                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-700 mb-8">
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-[#1E6F9F] text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>Todo lo del Plan Básico</strong> incluido</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>2 restauraciones simples</strong> al año (resina fotocurada)</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>1 prótesis básica</strong> (ajuste anatómico)</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>Mayor porcentaje de descuento</strong> en ortodoncia correctiva</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span>Agendamiento preferente en horas punta</span>
                            </li>
                        </ul>
                    </div>

                    <a href="/registro?plan=plus"
                       class="btn-shimmer block w-full py-4 px-6 text-sm font-extrabold text-center text-white bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] rounded-xl shadow-lg shadow-blue-900/20 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                        Afiliarme ahora
                    </a>
                </div>

                {{-- Tarjeta 3: Plan Premium ($40 USD/mes) --}}
                <div class="glass-card rounded-3xl p-8 sm:p-9 flex flex-col justify-between transition-all duration-300 hover:border-[#9F7AEA] hover:-translate-y-2 hover:shadow-2xl">
                    <div>
                        <div class="inline-block px-3 py-1 rounded-full bg-purple-50 text-[#9F7AEA] text-xs font-bold uppercase tracking-wider mb-4">
                            Cobertura Integral VIP
                        </div>
                        <h3 class="text-2xl font-serif font-bold text-slate-900 mb-2">
                            Plan Premium
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 min-h-[38px] leading-relaxed">
                            Máxima protección odontológica continua con beneficios clínicos de primer nivel.
                        </p>

                        <div class="my-6 pb-6 border-b border-slate-100 flex items-baseline gap-1">
                            <span class="text-4xl sm:text-5xl font-black text-slate-900">$40</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-400">USD / mes</span>
                        </div>

                        <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600 mb-8">
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-[#9F7AEA] text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>Todo lo del Plan Plus</strong> incluido</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>Cobertura extendida</strong> en prótesis fija y ortodoncia</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span><strong>Atención prioritaria inmediata</strong> sin lista de espera</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span>Consultas de urgencia dental cubiertas</span>
                            </li>
                        </ul>
                    </div>

                    <a href="/registro?plan=premium"
                       class="btn-shimmer block w-full py-3.5 px-6 text-sm font-bold text-center text-slate-800 bg-slate-100 hover:bg-[#9F7AEA] hover:text-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300">
                        Afiliarme ahora
                    </a>
                </div>

            </div>

            {{-- Leyenda legal --}}
            <div class="mt-12 text-center">
                <p class="text-xs sm:text-sm text-slate-400 italic">
                    * Plan de membresía dental. No es un seguro médico.
                </p>
            </div>

        </div>
    </section>

    {{-- Sección 7: Horarios de Atención con Parallax Suave --}}
    <section id="horarios" class="relative py-28 bg-slate-900 text-white overflow-hidden reveal">
        
        {{-- Fondo con efecto Parallax mediante background-attachment fixed --}}
        <div class="absolute inset-0 bg-cover bg-center bg-fixed opacity-20"
             style="background-image: url('https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1920&q=80');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-900/85 to-slate-950/90"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[#C8B6E2] mb-4 animate-pulse-soft">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-white">
                    Nuestros Horarios de Atención
                </h2>
                <p class="mt-3 text-base text-slate-300">
                    Atención planificada para que nunca debas posponer tu salud oral por compromisos laborales.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Lunes a Viernes --}}
                <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 sm:p-10 border border-white/15 shadow-2xl hover:border-[#C8B6E2]/50 hover:-translate-y-2 transition-all duration-300 text-center">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-[#1E6F9F] text-white text-xs font-black uppercase tracking-wider mb-5">
                        Jornada Laboral
                    </span>
                    <h3 class="text-2xl font-serif font-bold text-white mb-6">Lunes a Viernes</h3>
                    <div class="space-y-3 font-semibold text-base sm:text-lg">
                        <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10 text-slate-100">9:00 am – 12:30 pm</div>
                        <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10 text-slate-100">2:00 pm – 5:30 pm</div>
                    </div>
                </div>

                {{-- Sábados --}}
                <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 sm:p-10 border border-white/15 shadow-2xl hover:border-[#C8B6E2]/50 hover:-translate-y-2 transition-all duration-300 text-center flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-4 py-1.5 rounded-full bg-[#9F7AEA] text-white text-xs font-black uppercase tracking-wider mb-5">
                            Fin de Semana
                        </span>
                        <h3 class="text-2xl font-serif font-bold text-white mb-6">Sábados</h3>
                        <div class="p-3.5 bg-white/5 rounded-2xl border border-white/10 font-semibold text-base sm:text-lg text-slate-100">
                            9:00 am – 1:00 pm
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-6 italic">
                        * Domingos y días feriados: servicio de guardia exclusiva para emergencias de afiliados.
                    </p>
                </div>
            </div>

            {{-- CTA Directo Agendar Consulta en Horarios --}}
            <div class="mt-12 text-center">
                <a href="https://wa.me/584220584267?text=Hola%2C%20deseo%20agendar%20mi%20consulta%20odontol%C3%B3gica%20en%20el%20horario%20de%20atenci%C3%B3n."
                   target="_blank"
                   rel="noopener"
                   class="inline-flex items-center gap-3 px-8 py-4 rounded-full text-sm font-bold text-slate-900 bg-[#C8B6E2] hover:bg-[#9F7AEA] hover:text-white transition-all shadow-xl hover:scale-105">
                    <i class="fab fa-whatsapp text-lg text-emerald-600"></i>
                    <span>Agendar Consulta</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Sección 8: Estadísticas (contadores animados con Alpine.js e IntersectionObserver) --}}
    <section class="py-24 bg-white relative reveal"
             x-data="{
                 hasAnimated: false,
                 patients: 0,
                 designs: 0,
                 hours: 0,
                 implants: 0,
                 prosthetics: 0,
                 animateCounters() {
                     if (this.hasAnimated) return;
                     this.hasAnimated = true;
                     const duration = 2000;
                     const startTime = performance.now();

                     const targets = {
                         patients: 5209,
                         designs: 1499,
                         hours: 13237,
                         implants: 150,
                         prosthetics: 325
                     };

                     const step = (currentTime) => {
                         const elapsed = currentTime - startTime;
                         const progress = Math.min(elapsed / duration, 1);
                         const ease = 1 - Math.pow(1 - progress, 4);

                         this.patients = Math.floor(ease * targets.patients);
                         this.designs = Math.floor(ease * targets.designs);
                         this.hours = Math.floor(ease * targets.hours);
                         this.implants = Math.floor(ease * targets.implants);
                         this.prosthetics = Math.floor(ease * targets.prosthetics);

                         if (progress < 1) {
                             requestAnimationFrame(step);
                         } else {
                             this.patients = targets.patients;
                             this.designs = targets.designs;
                             this.hours = targets.hours;
                             this.implants = targets.implants;
                             this.prosthetics = targets.prosthetics;
                         }
                     };
                     requestAnimationFrame(step);
                 },
                 formatNumber(num) {
                     return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                 }
             }"
             x-init="
                 const observer = new IntersectionObserver((entries) => {
                     if (entries[0].isIntersecting) {
                         animateCounters();
                     }
                 }, { threshold: 0.2 });
                 observer.observe($el);
             ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs uppercase tracking-widest font-extrabold text-[#1E6F9F] bg-blue-50 px-4 py-1.5 rounded-full inline-block mb-3">
                    Evidencia Clínica
                </span>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900">
                    Nuestra Trayectoria en Cifras
                </h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-center">
                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-slate-200/80 hover:border-[#1E6F9F] hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-[#1E6F9F]" x-text="formatNumber(patients)">5.209</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-600 mt-2">Pacientes atendidos</div>
                </div>

                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-slate-200/80 hover:border-[#9F7AEA] hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-[#9F7AEA]" x-text="formatNumber(designs)">1.499</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-600 mt-2">Diseños de sonrisas</div>
                </div>

                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-slate-200/80 hover:border-[#1E6F9F] hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-[#1E6F9F]" x-text="formatNumber(hours)">13.237</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-600 mt-2">Horas de trabajo</div>
                </div>

                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-slate-200/80 hover:border-[#9F7AEA] hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-[#9F7AEA]" x-text="formatNumber(implants)">150</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-600 mt-2">Implantes dentales</div>
                </div>

                <div class="p-8 rounded-3xl bg-[#F8FAFC] border border-slate-200/80 hover:border-[#1E6F9F] hover:shadow-xl hover:-translate-y-2 transition-all duration-300 col-span-2 md:col-span-1">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-[#1E6F9F]" x-text="formatNumber(prosthetics)">325</div>
                    <div class="text-xs sm:text-sm font-semibold text-slate-600 mt-2">Estética y prótesis</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sección 9: Video de Instalaciones (Lazy Load vía Alpine.js) --}}
    <section class="py-28 bg-[#F8FAFC] reveal">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs uppercase tracking-widest font-extrabold text-[#1E6F9F] bg-blue-50 px-4 py-1.5 rounded-full inline-block mb-3">
                    Espacio Quirúrgico
                </span>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900">
                    Conoce nuestras instalaciones
                </h2>
                <p class="mt-3 text-base text-slate-600">
                    Boxes clínicos esterilizados con filtración de aire HEPA y sillones ergonómicos de última generación.
                </p>
            </div>

            <div x-data="{ videoLoaded: false }" class="relative aspect-video w-full rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-slate-900 group">
                <template x-if="!videoLoaded">
                    <div class="relative w-full h-full cursor-pointer" @click="videoLoaded = true">
                        <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1280&q=80"
                             alt="Instalaciones del centro odontológico"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90">
                        <div class="absolute inset-0 bg-slate-950/40 flex items-center justify-center">
                            <button type="button"
                                    aria-label="Reproducir video"
                                    class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#9F7AEA] hover:bg-[#C8B6E2] text-white hover:text-[#1E6F9F] flex items-center justify-center shadow-2xl hover:scale-110 transition-all duration-300">
                                <svg class="w-10 h-10 ml-1 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                        </div>
                    </div>
                </template>

                <template x-if="videoLoaded">
                    <iframe class="w-full h-full"
                            src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1"
                            title="Video de instalaciones"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </template>
            </div>
        </div>
    </section>

    {{-- Sección 10: Rediseño del Formulario de Contacto (Estilo Premium 2 Columnas) --}}
    <section id="contacto" class="py-28 bg-white relative reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                
                {{-- Columna Izquierda: Texto Persuasivo Editorial y Datos Directos --}}
                <div class="lg:col-span-5 space-y-8">
                    <div>
                        <span class="text-xs uppercase tracking-widest font-extrabold text-[#1E6F9F] bg-blue-50 px-4 py-1.5 rounded-full inline-block mb-3">
                            Atención Inmediata
                        </span>
                        <h2 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900 leading-tight">
                            ¿Listo para transformar tu sonrisa?
                        </h2>
                        <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                            Agenda tu cita de valoración diagnóstica o resuelve cualquier inquietud sobre la membresía de 6 consultas anuales. Un especialista odontológico responderá tu mensaje hoy mismo.
                        </p>
                    </div>

                    {{-- Tarjeta de Contacto Directo --}}
                    <div class="bg-[#F8FAFC] rounded-3xl p-8 border border-slate-200/80 space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.585 1.961.905 2.796.905 3.181 0 5.767-2.587 5.768-5.766.001-3.182-2.585-5.792-5.768-5.792zm0-2c4.28 0 7.767 3.486 7.767 7.768 0 4.28-3.487 7.767-7.767 7.767-1.127 0-2.348-.328-3.376-.894l-4.655 1.22 1.242-4.537c-.663-1.126-1.011-2.285-1.011-3.556 0-4.282 3.487-7.768 7.8-7.768z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs uppercase font-bold text-slate-400 block">Agendar Consulta por WhatsApp</span>
                                <a href="https://wa.me/584220584267?text=Hola%2C%20deseo%20agendar%20mi%20consulta%20odontol%C3%B3gica." target="_blank" rel="noopener" class="text-base font-bold text-slate-800 hover:text-[#1E6F9F] transition">
                                    +58 422 0584267
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-[#9F7AEA] flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <span class="text-xs uppercase font-bold text-slate-400 block">Sede Odontológica</span>
                                <p class="text-base font-bold text-slate-800">
                                    Av. Principal, Torre Médica Dental, Piso 4, Consultorio 402.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Columna Derecha: Formulario Premium con Inputs Suaves y Spinner --}}
                <div class="lg:col-span-7 bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-2xl shadow-slate-900/5"
                     x-data="{ isSubmitting: false }">
                    
                    <form action="{{ route('contacto.store') }}"
                          method="POST"
                          @submit="isSubmitting = true"
                          class="space-y-6">
                        @csrf

                        {{-- Nombre --}}
                        <div>
                            <label for="nombre" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Nombre completo <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="nombre"
                                   id="nombre"
                                   value="{{ old('nombre') }}"
                                   required
                                   placeholder="Ej. Sofía Hernández"
                                   class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('nombre') ? 'border-rose-400 bg-rose-50/50' : 'border-slate-200 bg-slate-50/40' }} focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 text-slate-900 transition-all outline-none text-sm">
                            @error('nombre')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email y Teléfono --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                    Correo electrónico <span class="text-rose-500">*</span>
                                </label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email') }}"
                                       required
                                       placeholder="sofia@ejemplo.com"
                                       class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/50' : 'border-slate-200 bg-slate-50/40' }} focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 text-slate-900 transition-all outline-none text-sm">
                                @error('email')
                                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="telefono" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                    Teléfono o WhatsApp <span class="text-rose-500">*</span>
                                </label>
                                <input type="tel"
                                       name="telefono"
                                       id="telefono"
                                       value="{{ old('telefono') }}"
                                       required
                                       placeholder="+58 422 0584267"
                                       class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('telefono') ? 'border-rose-400 bg-rose-50/50' : 'border-slate-200 bg-slate-50/40' }} focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 text-slate-900 transition-all outline-none text-sm">
                                @error('telefono')
                                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Mensaje --}}
                        <div>
                            <label for="mensaje" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                ¿En qué podemos ayudarte? <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="mensaje"
                                      id="mensaje"
                                      rows="4"
                                      required
                                      placeholder="Cuéntanos el motivo de tu consulta o el tratamiento en el que estás interesado..."
                                      class="w-full px-4 py-3.5 rounded-xl border {{ $errors->has('mensaje') ? 'border-rose-400 bg-rose-50/50' : 'border-slate-200 bg-slate-50/40' }} focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 text-slate-900 transition-all outline-none text-sm">{{ old('mensaje') }}</textarea>
                            @error('mensaje')
                                <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botón con Spinner y Hover de Gradiente Azul-Lila --}}
                        <div>
                            <button type="submit"
                                    :disabled="isSubmitting"
                                    class="w-full py-4 px-6 text-sm sm:text-base font-bold text-white bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] rounded-xl shadow-lg shadow-blue-900/15 hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 flex items-center justify-center gap-3 disabled:opacity-75">
                                <span x-show="!isSubmitting">Enviar Consulta al Equipo Clínico</span>
                                <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                    Enviando tu mensaje...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section>

    {{-- Sección 11: Footer Editorial con información y enlaces --}}
    <footer class="bg-slate-950 text-slate-300 pt-20 pb-10 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                
                {{-- Columna 1: Sobre Nosotros --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="tooth-icon w-10 h-10 rounded-2xl bg-gradient-to-br from-[#1E6F9F] to-[#9F7AEA] flex items-center justify-center text-white">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M18.8 6.5C18.2 4.4 16.7 3 14.8 3c-1.3 0-2.2.7-2.8 1.4C11.4 3.7 10.5 3 9.2 3 7.3 3 5.8 4.4 5.2 6.5 4.3 9.5 4.9 14.1 6.8 17.5c1.1 2 2.7 3.5 4 3.5.7 0 1.2-.5 1.2-1.5 0-1.2.4-2.5 1-2.5s1 1.3 1 2.5c0 1 .5 1.5 1.2 1.5 1.3 0 2.9-1.5 4-3.5 1.9-3.4 2.5-8 1.6-11z"/>
                            </svg>
                        </div>
                        <span class="font-serif text-2xl font-bold text-white">Odontología <span class="text-[#C8B6E2]">Salud</span></span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Centro especializado en prevención y rehabilitación bucodental integral. Creadores del exclusivo Plan de Membresía Dental de 6 consultas anuales.
                    </p>
                    <div class="pt-2 flex items-center gap-4">
                        <a href="https://instagram.com" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-slate-900 hover:bg-[#9F7AEA] text-slate-300 hover:text-white flex items-center justify-center transition-all hover:scale-110" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://facebook.com" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-slate-900 hover:bg-[#9F7AEA] text-slate-300 hover:text-white flex items-center justify-center transition-all hover:scale-110" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="https://wa.me/584220584267" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-slate-900 hover:bg-[#9F7AEA] text-slate-300 hover:text-white flex items-center justify-center transition-all hover:scale-110" aria-label="WhatsApp">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Columna 2: Contacto --}}
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-[#C8B6E2]">Contacto</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li>
                            <strong class="text-slate-200">Móvil / WhatsApp:</strong><br>
                            <a href="https://wa.me/584220584267" class="hover:text-white transition">+58 422 0584267</a>
                        </li>
                        <li>
                            <strong class="text-slate-200">Email:</strong><br>
                            <a href="mailto:contacto@odontologia.test" class="hover:text-white transition">contacto@odontologia.test</a>
                        </li>
                        <li>
                            <strong class="text-slate-200">Dirección:</strong><br>
                            Av. Principal, Torre Médica Dental, Piso 4, Consultorio 402.
                        </li>
                    </ul>
                </div>

                {{-- Columna 3: Horarios & Enlace Rápido al Plan --}}
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-[#C8B6E2]">Horarios</h4>
                    <div class="space-y-2.5 text-sm text-slate-400">
                        <div>
                            <span class="block text-slate-200 font-semibold">Lunes a Viernes:</span>
                            <span>9:00 am – 12:30 pm / 2:00 pm – 5:30 pm</span>
                        </div>
                        <div>
                            <span class="block text-slate-200 font-semibold">Sábados:</span>
                            <span>9:00 am – 1:00 pm</span>
                        </div>
                        <div class="pt-3">
                            <a href="{{ route('registro') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#C8B6E2] hover:text-white transition gap-1.5">
                                <span>Afíliate al plan online</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pt-8 border-t border-slate-900 text-center text-xs text-slate-500">
                <p>© 2026 Odontología [Nombre]. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    {{-- Botón Flotante de WhatsApp (Estilo robert/index.html con pulse-whatsapp y ondas expansivas) --}}
    <a href="https://wa.me/584220584267?text=Hola%2C%20deseo%20agendar%20mi%20consulta%20del%20Plan%20de%20Membres%C3%ADa%20Dental."
       target="_blank"
       rel="noopener"
       aria-label="Agendar Consulta por WhatsApp"
       class="fixed bottom-6 right-6 z-50 pulse-whatsapp blue-gradient text-white px-6 py-4 rounded-2xl flex items-center gap-3 font-bold shadow-2xl hover:scale-105 transition-all duration-300 border border-white/20">
        <i class="fab fa-whatsapp text-2xl text-emerald-400"></i>
        <span class="hidden md:inline text-sm font-bold tracking-wide">Agendar Consulta</span>
        <span class="md:hidden"><i class="fas fa-chevron-right text-xs"></i></span>
    </a>

    {{-- Inicialización de Swiper, Animaciones Scroll y Micro-interacciones (Ref: robert/index.html) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Carrusel Hero Swiper con efecto Fade y Ken Burns
            const heroSwiper = new Swiper('.heroSwiper', {
                loop: true,
                speed: 1200,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });

            // 2. Scroll Reveal con IntersectionObserver y soporte para retardo escalonado (Stagger)
            const reveals = document.querySelectorAll('.reveal');
            if ('IntersectionObserver' in window) {
                const observerOptions = {
                    root: null,
                    rootMargin: '0px 0px -40px 0px',
                    threshold: 0.12
                };

                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach((entry, idx) => {
                        if (entry.isIntersecting) {
                            // Si el elemento o sus hijos tienen data-delay, aplica retardo escalonado estilo AOS
                            const delay = entry.target.getAttribute('data-delay') || 0;
                            setTimeout(() => {
                                entry.target.classList.add('active');
                            }, delay);
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                reveals.forEach(element => revealObserver.observe(element));
            } else {
                reveals.forEach(element => element.classList.add('active'));
            }

            // 3. Efecto Parallax suave al hacer scroll en secciones con fondo fijo
            const parallaxBg = document.querySelector('.bg-fixed');
            if (parallaxBg) {
                window.addEventListener('scroll', () => {
                    const scrolled = window.pageYOffset;
                    parallaxBg.style.backgroundPositionY = -(scrolled * 0.15) + 'px';
                }, { passive: true });
            }
        });
    </script>
</body>
</html>
