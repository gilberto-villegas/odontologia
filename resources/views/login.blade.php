<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Portal del Paciente</title>
    <meta name="description" content="Accede a tu portal para gestionar tus consultas anuales, citas y plan de membresía dental.">

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
<body class="bg-[#F8FAFC] min-h-screen text-slate-700 antialiased py-10 px-4 sm:px-6 lg:px-8 flex flex-col justify-between"
      x-data="{
          email: 'admin@odontologia.test',
          password: '••••••••',
          rol: 'admin',
          showPassword: false,
          isSubmitting: false,
          modalRecuperar: false,
          emailRecuperar: '',
          toastRecuperar: false,
          setRol(nuevoRol) {
              this.rol = nuevoRol;
              if (nuevoRol === 'admin') {
                  this.email = 'admin@odontologia.test';
              } else {
                  this.email = 'sofia.martinez@ejemplo.com';
              }
          },
          login() {
              this.isSubmitting = true;
              setTimeout(() => {
                  if (this.email.toLowerCase().includes('admin') || this.rol === 'admin') {
                      window.location.href = '/admin';
                  } else {
                      window.location.href = '/dashboard-paciente';
                  }
              }, 600);
          },
          solicitarRecuperacion() {
              if (!this.emailRecuperar) {
                  alert('Por favor ingresa tu correo electrónico.');
                  return;
              }
              this.modalRecuperar = false;
              this.emailRecuperar = '';
              this.toastRecuperar = true;
              setTimeout(() => this.toastRecuperar = false, 4000);
          }
      }">

    {{-- Header Minimalista con Logo --}}
    <header class="max-w-md mx-auto w-full mb-8 text-center">
        <a href="/" class="inline-flex items-center gap-3 group focus:outline-none">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#1E6F9F] to-[#9F7AEA] flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform">
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                    <path d="M18.8 6.5C18.2 4.4 16.7 3 14.8 3c-1.3 0-2.2.7-2.8 1.4C11.4 3.7 10.5 3 9.2 3 7.3 3 5.8 4.4 5.2 6.5 4.3 9.5 4.9 14.1 6.8 17.5c1.1 2.7 3.5 4 3.5.7 0 1.2-.5 1.2-1.5 0-1.2.4-2.5 1-2.5s1 1.3 1 2.5c0 1 .5 1.5 1.2 1.5 1.3 0 2.9-1.5 4-3.5 1.9-3.4 2.5-8 1.6-11z"/>
                </svg>
            </div>
            <div class="text-left">
                <span class="font-serif text-2xl font-bold tracking-tight text-[#1E6F9F]">Odontología <span class="text-[#9F7AEA]">Salud</span></span>
                <span class="block text-[10px] uppercase font-bold tracking-widest text-slate-400 -mt-1">Portal del Paciente</span>
            </div>
        </a>
    </header>

    {{-- Tarjeta Principal Centrada --}}
    <main class="max-w-md mx-auto w-full">
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-2xl shadow-slate-900/5">
            
            {{-- Encabezado --}}
            <div class="mb-6 text-center">
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#1E6F9F] bg-blue-50 px-3 py-1 rounded-full border border-blue-100 mb-3">
                    Acceso al Sistema
                </span>
                <h1 class="font-serif text-3xl font-bold text-slate-900">
                    Inicia Sesión en tu Portal
                </h1>
                <p class="text-sm text-slate-500 mt-2">
                    Ingresa con tu cuenta de paciente o administrador.
                </p>
            </div>

            {{-- Selector Rápido de Demo / Rol --}}
            <div class="mb-6 p-1.5 bg-slate-100 rounded-2xl flex items-center gap-1.5 border border-slate-200">
                <button type="button"
                        @click="setRol('admin')"
                        :class="rol === 'admin' ? 'bg-[#1E6F9F] text-white shadow-md' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60'"
                        class="flex-1 py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5">
                    <i class="fas fa-shield-alt"></i>
                    <span>Administrador</span>
                </button>
                <button type="button"
                        @click="setRol('paciente')"
                        :class="rol === 'paciente' ? 'bg-[#1E6F9F] text-white shadow-md' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60'"
                        class="flex-1 py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5">
                    <i class="fas fa-user"></i>
                    <span>Paciente</span>
                </button>
            </div>

            {{-- Mensajes de Alerta Flash --}}
            @if(session('success'))
                <div class="mb-5 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Formulario de Inicio de Sesión --}}
            <form action="{{ route('login.post') }}" method="POST" @submit="isSubmitting = true" class="space-y-5">
                @csrf
                
                {{-- Correo Electrónico --}}
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Correo electrónico
                    </label>
                    <div class="relative">
                        <input type="email"
                               name="email"
                               id="email"
                               x-model="email"
                               value="{{ old('email', 'admin@odontologia.test') }}"
                               required
                               placeholder="tu.correo@ejemplo.com"
                               class="w-full pl-4 pr-10 py-3.5 rounded-xl border @error('email') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-600 font-bold mt-1.5 flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Contraseña con Toggle de Ojo --}}
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Contraseña
                    </label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'"
                               name="password"
                               id="password"
                               x-model="password"
                               required
                               placeholder="Tu contraseña secreta"
                               class="w-full pl-4 pr-11 py-3.5 rounded-xl border @error('password') border-rose-400 bg-rose-50/30 @else border-slate-200 bg-slate-50/50 @enderror text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-[#1E6F9F] transition-colors focus:outline-none"
                                :title="showPassword ? 'Ocultar contraseña' : 'Ver contraseña'">
                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-600 font-bold mt-1.5 flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Recordarme y Enlace Olvidé mi Contraseña --}}
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" checked class="w-4 h-4 text-[#1E6F9F] rounded border-slate-300 focus:ring-[#1E6F9F]">
                        <span class="text-slate-600">Recordarme</span>
                    </label>

                    <a href="#"
                       @click.prevent="modalRecuperar = true"
                       class="font-bold text-[#1E6F9F] hover:text-[#9F7AEA] hover:underline transition">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                {{-- Botón Ingresar con Spinner --}}
                <div class="pt-2">
                    <button type="submit"
                            :disabled="isSubmitting"
                            class="w-full py-4 px-6 text-sm font-bold text-white bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] rounded-xl shadow-lg shadow-blue-900/15 hover:shadow-2xl hover:scale-[1.01] transition-all duration-300 flex items-center justify-center gap-2.5 disabled:opacity-75">
                        <span x-show="!isSubmitting">Ingresar al Portal</span>
                        <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                            <i class="fas fa-spinner fa-spin text-sm"></i>
                            Accediendo a tu cuenta...
                        </span>
                    </button>
                </div>

            </form>

            {{-- Enlace de Afiliación --}}
            <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
                <span>¿No tienes cuenta?</span>
                <a href="/registro" class="font-bold text-[#1E6F9F] hover:text-[#9F7AEA] hover:underline ml-1">
                    Afíliate aquí a tu plan
                </a>
            </div>

            <div class="mt-4 text-center text-xs text-slate-400">
                <a href="/" class="hover:text-slate-600 transition inline-flex items-center gap-1">
                    <i class="fas fa-arrow-left text-[10px]"></i> Volver a la página de inicio
                </a>
            </div>

        </div>
    </main>

    {{-- Modal Recuperar Contraseña (Alpine.js) --}}
    <div x-show="modalRecuperar"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="modalRecuperar = false"
             class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="font-serif text-xl font-bold text-slate-900">Recuperar Contraseña</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Te enviaremos un enlace seguro a tu correo.</p>
                </div>
                <button type="button" @click="modalRecuperar = false" class="text-slate-400 hover:text-slate-700 text-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form @submit.prevent="solicitarRecuperacion()" class="space-y-4 text-sm">
                <div>
                    <label for="emailRec" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Correo registrado
                    </label>
                    <input type="email"
                           id="emailRec"
                           x-model="emailRecuperar"
                           required
                           placeholder="tu.correo@ejemplo.com"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm outline-none focus:border-[#1E6F9F]">
                </div>

                <div class="p-3.5 rounded-xl bg-blue-50/70 border border-blue-100 text-xs text-[#1E6F9F] leading-relaxed">
                    Si tu correo coincide con una cuenta activa, recibirás un mensaje con las instrucciones de restablecimiento en menos de 5 minutos.
                </div>

                <div class="pt-2 flex items-center justify-end gap-3">
                    <button type="button" @click="modalRecuperar = false" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#1E6F9F] text-white text-xs font-bold hover:bg-[#16567C] shadow-md transition">
                        Enviar Enlace
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Toast Notificación Recuperación (Alpine.js) --}}
    <div x-show="toastRecuperar"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         class="fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-5 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 text-sm font-semibold border border-white/10 max-w-sm">
        <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs flex-shrink-0">
            <i class="fas fa-check"></i>
        </div>
        <span class="text-xs">¡Instrucciones enviadas! Revisa tu bandeja de entrada o spam.</span>
    </div>

    {{-- Footer Simple --}}
    <footer class="mt-8 text-center text-xs text-slate-400">
        © 2026 Odontología Especializada · Plan de Membresía Dental de 6 Consultas Anuales.
    </footer>

</body>
</html>