<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Afiliación | Odontología Especializada</title>
    <meta name="description" content="Paso 3: Confirmación de tu membresía dental en proceso de activación.">

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
<body class="bg-[#F8FAFC] min-h-screen text-slate-700 antialiased py-12 px-4 sm:px-6 lg:px-8 flex flex-col justify-between"
      x-data="{
          plan: '{{ request('plan', 'plus') }}',
          getPlanName() {
              if (this.plan === 'basico') return 'Plan Básico ($15/mes)';
              if (this.plan === 'premium') return 'Plan Premium ($40/mes)';
              return 'Plan Plus ($25/mes)';
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

    {{-- Tarjeta de Confirmación Centrada --}}
    <main class="max-w-xl mx-auto w-full">
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-2xl shadow-slate-900/5 text-center">
            
            {{-- Icono de Éxito con Animación Suave --}}
            <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-emerald-400 to-emerald-500 text-white flex items-center justify-center mx-auto mb-6 shadow-xl shadow-emerald-500/20 text-3xl">
                <i class="fas fa-check"></i>
            </div>

            {{-- Mensaje de Bienvenida --}}
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900 mb-3">
                ¡Bienvenido a Odontología Salud!
            </h1>

            <p class="text-slate-600 text-base leading-relaxed mb-8">
                Estamos muy felices de acompañarte a cuidar tu sonrisa con nuestro modelo de odontología preventiva.
            </p>

            {{-- Resumen del Estado del Plan --}}
            <div class="p-6 rounded-2xl bg-[#F8FAFC] border border-slate-200/80 mb-8 text-left space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200/80">
                    <span class="text-xs uppercase font-bold text-slate-400">Estado de Membresía</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                        En proceso de activación
                    </span>
                </div>

                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 block mb-1">Plan Solicitado</span>
                    <p class="text-base font-bold text-[#1E6F9F]" x-text="'Tu plan ' + getPlanName() + ' está en proceso de activación'"></p>
                </div>

                <div class="pt-2 text-xs text-slate-500 leading-relaxed">
                    Nuestro equipo administrativo validará la referencia de tu Pago Móvil en un lapso no mayor a 24 horas hábiles. Recibirás tu confirmación y credencial digital directamente en tu correo electrónico.
                </div>
            </div>

            {{-- Botón Ir a Mi Cuenta --}}
            <a href="/dashboard-paciente"
               class="inline-flex items-center justify-center gap-2.5 w-full py-4 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] shadow-lg shadow-blue-900/15 hover:shadow-2xl hover:scale-[1.01] transition-all duration-300">
                <i class="fas fa-home text-sm"></i>
                <span>Ir a mi cuenta</span>
            </a>

            <div class="mt-6 text-xs text-slate-400">
                ¿Tienes dudas con tu pago? Contáctanos de inmediato por 
                <a href="https://wa.me/584220584267" target="_blank" class="font-bold text-[#1E6F9F] underline hover:text-[#9F7AEA]">
                    WhatsApp (+58 422 0584267)
                </a>.
            </div>

        </div>
    </main>

    {{-- Footer Simple --}}
    <footer class="mt-8 text-center text-xs text-slate-400">
        © 2026 Odontología Especializada. Todos los derechos reservados.
    </footer>

</body>
</html>