<div class="space-y-8"
     x-data="{
         guardando: false,
         planes: {
             basico: {
                 activo: true,
                 precio: 15,
                 beneficios: '6 consultas anuales (limpieza + revisión diagnóstica)\nExtracciones simples cubiertas\nDescuentos preferenciales en ortodoncia y prótesis\nHistoria clínica digital y recordatorios'
             },
             plus: {
                 activo: true,
                 precio: 25,
                 beneficios: 'Todo lo del Plan Básico incluido\n2 restauraciones simples al año (resina fotocurada)\n1 prótesis básica (ajuste anatómico)\nMayor porcentaje de descuento en ortodoncia correctiva\nAgendamiento preferente en horas punta'
             },
             premium: {
                 activo: true,
                 precio: 40,
                 beneficios: 'Todo lo del Plan Plus incluido\nCobertura extendida en prótesis fija y ortodoncia\nAtención prioritaria inmediata sin lista de espera\nConsultas de urgencia dental cubiertas'
             }
         },
         horarios: {
             semana: '9:00 am – 12:30 pm / 2:00 pm – 5:30 pm',
             sabados: '9:00 am – 1:00 pm'
         },
         ubicacion: {
             direccion: 'Av. Principal, Torre Médica Dental, Piso 4, Consultorio 402.',
             telefono: '+58 422 0584267',
             email: 'contacto@odontologia.test'
         },
         guardarConfiguracion() {
             this.guardando = true;
             setTimeout(() => {
                 this.guardando = false;
                 showToast('¡Configuración guardada con éxito! Los cambios se han aplicado a la landing page.');
             }, 600);
         }
     }">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#9F7AEA] bg-purple-50 px-3 py-1 rounded-full border border-purple-100 mb-2">
                Gestor de Contenidos
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900">
                Configuración de la Landing Page
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Personaliza los precios de tus membresías, horarios de atención y datos de contacto en vivo.
            </p>
        </div>

        <button type="button"
                @click="guardarConfiguracion()"
                :disabled="guardando"
                class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] text-white text-xs font-bold shadow-lg shadow-blue-900/15 hover:shadow-xl transition-all self-start sm:self-auto disabled:opacity-75">
            <i class="fas" :class="guardando ? 'fa-spinner fa-spin' : 'fa-save'"></i>
            <span x-text="guardando ? 'Guardando...' : 'Guardar Cambios'"></span>
        </button>
    </div>

    {{-- Alertas Flash --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Formulario Central de Configuración Backend + Frontend --}}
    <form action="{{ route('admin.configuracion.update') }}" method="POST" class="space-y-8">
        @csrf
        
        {{-- ==================== SECCIÓN 1: PLANES DE MEMBRESÍA ==================== --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl shadow-slate-900/5 space-y-6">
            <div class="flex items-center gap-3 pb-5 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center text-lg">
                    <i class="fas fa-gem"></i>
                </div>
                <div>
                    <h2 class="font-serif text-2xl font-bold text-slate-900">Planes de Membresía</h2>
                    <p class="text-xs text-slate-500">Estructura de precios y beneficios activos para afiliación en línea</p>
                </div>
            </div>

            {{-- Grid de Configuración de los 3 Planes con Switches --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- 1. Tarjeta Configuración: Plan Básico --}}
                <div class="p-5 rounded-2xl border transition-all duration-200 space-y-4"
                     :class="planes.basico.activo 
                         ? 'border-slate-200 bg-[#F8FAFC]' 
                         : 'border-slate-300 bg-slate-100/75 opacity-75'">
                    
                    {{-- Encabezado con Switch --}}
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Nivel 1</span>
                            <span class="text-xs font-bold text-[#1E6F9F]">Plan Básico</span>
                        </div>

                        {{-- Switch (Toggle) Alpine.js --}}
                        <div class="flex items-center gap-2">
                            <span x-show="planes.basico.activo" class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                Visible
                            </span>
                            <span x-show="!planes.basico.activo" x-cloak class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                                Oculto en Landing
                            </span>
                            <button type="button"
                                    @click="planes.basico.activo = !planes.basico.activo"
                                    :class="planes.basico.activo ? 'bg-[#1E6F9F]' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                    role="switch"
                                    :aria-checked="planes.basico.activo">
                                <span :class="planes.basico.activo ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Precio --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Precio Mensual ($ USD)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-bold">$</span>
                            <input type="number"
                                   x-model="planes.basico.precio"
                                   class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 font-bold text-sm outline-none focus:border-[#1E6F9F]">
                        </div>
                    </div>

                    {{-- Beneficios --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Beneficios (un beneficio por línea)
                        </label>
                        <textarea x-model="planes.basico.beneficios"
                                  rows="5"
                                  class="w-full p-3 rounded-xl border border-slate-200 bg-white text-slate-700 text-xs leading-relaxed outline-none focus:border-[#1E6F9F]"></textarea>
                    </div>
                </div>

                {{-- 2. Tarjeta Configuración: Plan Plus --}}
                <div class="p-5 rounded-2xl border-2 transition-all duration-200 space-y-4"
                     :class="planes.plus.activo 
                         ? 'border-[#1E6F9F] bg-white shadow-md' 
                         : 'border-slate-300 bg-slate-100/75 opacity-75 shadow-none'">
                    
                    {{-- Encabezado con Switch --}}
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#1E6F9F] block">Nivel 2 (Popular)</span>
                            <span class="text-xs font-bold text-slate-900">Plan Plus</span>
                        </div>

                        {{-- Switch (Toggle) Alpine.js --}}
                        <div class="flex items-center gap-2">
                            <span x-show="planes.plus.activo" class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                Visible
                            </span>
                            <span x-show="!planes.plus.activo" x-cloak class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                                Oculto en Landing
                            </span>
                            <button type="button"
                                    @click="planes.plus.activo = !planes.plus.activo"
                                    :class="planes.plus.activo ? 'bg-[#1E6F9F]' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                    role="switch"
                                    :aria-checked="planes.plus.activo">
                                <span :class="planes.plus.activo ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Precio --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Precio Mensual ($ USD)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-bold">$</span>
                            <input type="number"
                                   x-model="planes.plus.precio"
                                   class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-[#1E6F9F] font-bold text-sm outline-none focus:border-[#1E6F9F]">
                        </div>
                    </div>

                    {{-- Beneficios --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Beneficios (un beneficio por línea)
                        </label>
                        <textarea x-model="planes.plus.beneficios"
                                  rows="5"
                                  class="w-full p-3 rounded-xl border border-slate-200 bg-white text-slate-700 text-xs leading-relaxed outline-none focus:border-[#1E6F9F]"></textarea>
                    </div>
                </div>

                {{-- 3. Tarjeta Configuración: Plan Premium --}}
                <div class="p-5 rounded-2xl border transition-all duration-200 space-y-4"
                     :class="planes.premium.activo 
                         ? 'border-slate-200 bg-[#F8FAFC]' 
                         : 'border-slate-300 bg-slate-100/75 opacity-75'">
                    
                    {{-- Encabezado con Switch --}}
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#9F7AEA] block">Nivel 3 (VIP)</span>
                            <span class="text-xs font-bold text-slate-900">Plan Premium</span>
                        </div>

                        {{-- Switch (Toggle) Alpine.js --}}
                        <div class="flex items-center gap-2">
                            <span x-show="planes.premium.activo" class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                                Visible
                            </span>
                            <span x-show="!planes.premium.activo" x-cloak class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                                Oculto en Landing
                            </span>
                            <button type="button"
                                    @click="planes.premium.activo = !planes.premium.activo"
                                    :class="planes.premium.activo ? 'bg-[#1E6F9F]' : 'bg-slate-300'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                    role="switch"
                                    :aria-checked="planes.premium.activo">
                                <span :class="planes.premium.activo ? 'translate-x-5' : 'translate-x-0'"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Precio --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Precio Mensual ($ USD)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-bold">$</span>
                            <input type="number"
                                   x-model="planes.premium.precio"
                                   class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 font-bold text-sm outline-none focus:border-[#1E6F9F]">
                        </div>
                    </div>

                    {{-- Beneficios --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Beneficios (un beneficio por línea)
                        </label>
                        <textarea x-model="planes.premium.beneficios"
                                  rows="5"
                                  class="w-full p-3 rounded-xl border border-slate-200 bg-white text-slate-700 text-xs leading-relaxed outline-none focus:border-[#1E6F9F]"></textarea>
                    </div>
                </div>

            </div>

            {{-- Previsualización en Vivo de la Landing Page --}}
            <div class="pt-6 border-t border-slate-200/80">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-eye text-[#1E6F9F]"></i>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700">
                            Previsualización en la Landing Page (Efecto en Vivo del Switch)
                        </span>
                    </div>
                    <span class="text-[11px] text-slate-400">
                        Los planes con switch apagado se muestran deshabilitados y no disponibles para afiliación.
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200/90">
                    
                    {{-- Preview: Básico --}}
                    <div class="p-4 rounded-xl border transition-all duration-300 relative flex flex-col justify-between"
                         :class="planes.basico.activo 
                             ? 'bg-white border-slate-200 shadow-sm' 
                             : 'bg-slate-100 border-dashed border-slate-300 opacity-60'">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-slate-800">Plan Básico</span>
                                <span x-show="!planes.basico.activo" class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                                    Oculto en Landing
                                </span>
                            </div>
                            <div class="text-xl font-black text-[#1E6F9F] mb-2" x-text="'$' + planes.basico.precio + ' USD/mes'"></div>
                            <p class="text-[11px] text-slate-500 mb-3">6 consultas anuales, profilaxis y diagnósticos preventivos.</p>
                        </div>
                        <div>
                            <button type="button"
                                    :disabled="!planes.basico.activo"
                                    :class="planes.basico.activo 
                                        ? 'bg-blue-50 text-[#1E6F9F] hover:bg-[#1E6F9F] hover:text-white cursor-pointer shadow-sm' 
                                        : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                                    class="w-full py-2 px-3 rounded-lg text-xs font-bold transition">
                                <span x-text="planes.basico.activo ? 'Afiliarme ahora' : 'No disponible'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Preview: Plus --}}
                    <div class="p-4 rounded-xl border-2 transition-all duration-300 relative flex flex-col justify-between"
                         :class="planes.plus.activo 
                             ? 'bg-white border-[#1E6F9F] shadow-md' 
                             : 'bg-slate-100 border-dashed border-slate-300 opacity-60 shadow-none'">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-slate-900">Plan Plus</span>
                                <span x-show="planes.plus.activo" class="text-[10px] font-bold text-white bg-[#1E6F9F] px-2 py-0.5 rounded-full">
                                    Más popular
                                </span>
                                <span x-show="!planes.plus.activo" class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                                    Oculto en Landing
                                </span>
                            </div>
                            <div class="text-xl font-black text-[#1E6F9F] mb-2" x-text="'$' + planes.plus.precio + ' USD/mes'"></div>
                            <p class="text-[11px] text-slate-500 mb-3">Todo lo del básico + restauraciones de resina y prótesis.</p>
                        </div>
                        <div>
                            <button type="button"
                                    :disabled="!planes.plus.activo"
                                    :class="planes.plus.activo 
                                        ? 'bg-[#1E6F9F] text-white hover:bg-[#16567C] cursor-pointer shadow-md' 
                                        : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                                    class="w-full py-2 px-3 rounded-lg text-xs font-bold transition">
                                <span x-text="planes.plus.activo ? 'Afiliarme ahora' : 'No disponible'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Preview: Premium --}}
                    <div class="p-4 rounded-xl border transition-all duration-300 relative flex flex-col justify-between"
                         :class="planes.premium.activo 
                             ? 'bg-white border-slate-200 shadow-sm' 
                             : 'bg-slate-100 border-dashed border-slate-300 opacity-60'">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-slate-800">Plan Premium</span>
                                <span x-show="!planes.premium.activo" class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                                    Oculto en Landing
                                </span>
                            </div>
                            <div class="text-xl font-black text-[#1E6F9F] mb-2" x-text="'$' + planes.premium.precio + ' USD/mes'"></div>
                            <p class="text-[11px] text-slate-500 mb-3">Cobertura extendida en prótesis, ortodoncia y urgencias.</p>
                        </div>
                        <div>
                            <button type="button"
                                    :disabled="!planes.premium.activo"
                                    :class="planes.premium.activo 
                                        ? 'bg-purple-50 text-[#9F7AEA] hover:bg-[#9F7AEA] hover:text-white cursor-pointer shadow-sm' 
                                        : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                                    class="w-full py-2 px-3 rounded-lg text-xs font-bold transition">
                                <span x-text="planes.premium.activo ? 'Afiliarme ahora' : 'No disponible'"></span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- ==================== SECCIÓN 2: HORARIOS DE ATENCIÓN ==================== --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl shadow-slate-900/5">
            <div class="flex items-center gap-3 pb-5 border-b border-slate-100 mb-6">
                <div class="w-10 h-10 rounded-2xl bg-purple-50 text-[#9F7AEA] flex items-center justify-center text-lg">
                    <i class="far fa-clock"></i>
                </div>
                <div>
                    <h2 class="font-serif text-2xl font-bold text-slate-900">2. Horarios de Atención al Público</h2>
                    <p class="text-xs text-slate-500">Horarios reflejados en la tarjeta Parallax de la landing y en el footer.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Lunes a Viernes
                    </label>
                    <input type="text"
                           x-model="horarios.semana"
                           placeholder="Ej. 9:00 am – 12:30 pm / 2:00 pm – 5:30 pm"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Sábados
                    </label>
                    <input type="text"
                           x-model="horarios.sabados"
                           placeholder="Ej. 9:00 am – 1:00 pm"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all font-medium">
                </div>
            </div>
        </div>

        {{-- ==================== SECCIÓN 3: UBICACIÓN Y CONTACTO ==================== --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl shadow-slate-900/5">
            <div class="flex items-center gap-3 pb-5 border-b border-slate-100 mb-6">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h2 class="font-serif text-2xl font-bold text-slate-900">3. Ubicación y Líneas Telefónicas</h2>
                    <p class="text-xs text-slate-500">Dirección física de la clínica y número oficial de WhatsApp Clínico.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Dirección de la Sede Odontológica
                    </label>
                    <input type="text"
                           x-model="ubicacion.direccion"
                           placeholder="Ej. Av. Principal, Torre Médica Dental, Piso 4, Consultorio 402."
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        WhatsApp Oficial
                    </label>
                    <input type="text"
                           x-model="ubicacion.telefono"
                           placeholder="+58 422 0584267"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/20 transition-all font-mono font-bold">
                </div>
            </div>
        </div>

        {{-- Botón Guardar Inferior --}}
        <div class="flex justify-end pt-2">
            <button type="submit"
                    :disabled="guardando"
                    class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] text-white text-sm font-bold shadow-lg shadow-blue-900/15 hover:shadow-2xl hover:scale-105 transition-all flex items-center justify-center gap-2 disabled:opacity-75">
                <i class="fas" :class="guardando ? 'fa-spinner fa-spin' : 'fa-check-circle'"></i>
                <span x-text="guardando ? 'Guardando cambios...' : 'Guardar y Publicar en Landing'"></span>
            </button>
        </div>

    </form>

</div>