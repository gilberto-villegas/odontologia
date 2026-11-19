<div class="space-y-8" x-data="{ nombre: '{{ auth()->user()->name ?? 'Dr. Roberto Méndez' }}' }">
    
    {{-- Saludo y Encabezado del Dashboard --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#1E6F9F] bg-blue-50 px-3 py-1 rounded-full border border-blue-100 mb-2">
                Resumen Operativo
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900">
                Buenas tardes, <span x-text="nombre"></span>
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Panel central de control del Plan de Membresías y gestión clínica.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button"
                    @click="tab = 'pagos'"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-[#1E6F9F] hover:bg-[#16567C] text-white text-xs font-bold shadow-lg shadow-blue-900/15 hover:shadow-xl transition-all">
                <i class="fas fa-check-double text-xs"></i>
                <span>Revisar Pagos (<span x-text="pagosPendientesCount"></span>)</span>
            </button>
        </div>
    </div>

    {{-- 3 Tarjetas de Acceso Rápido (Basadas en el Layout de Referencia) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Tarjeta 1: Gestión de Citas --}}
        <div class="bg-white rounded-3xl p-7 border border-slate-200/90 shadow-xl shadow-slate-900/5 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center text-2xl mb-5 group-hover:scale-110 group-hover:bg-[#1E6F9F] group-hover:text-white transition-all shadow-sm">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold text-slate-900 mb-2">
                    Gestión de Citas
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                    Agenda diaria, confirmación de horarios por box y control de especialistas asignados.
                </p>
            </div>
            
            <button type="button"
                    @click="tab = 'citas'"
                    class="w-full py-3.5 px-5 rounded-2xl bg-slate-50 hover:bg-[#1E6F9F] text-slate-700 hover:text-white font-bold text-xs flex items-center justify-between transition-all group-hover:shadow-md">
                <span>Entrar al Calendario</span>
                <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
            </button>
        </div>

        {{-- Tarjeta 2: Validar Pagos Móviles (PRIORITARIA) --}}
        <div class="bg-white rounded-3xl p-7 border-2 border-[#1E6F9F] shadow-2xl shadow-blue-900/10 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
            <div class="absolute -top-3 right-6 bg-rose-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-sm">
                Prioritario
            </div>

            <div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-5 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                    <i class="fas fa-receipt"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold text-slate-900 mb-2 flex items-center gap-2">
                    <span>Validar Pagos Móviles</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                    Verifica transferencias reportadas por pacientes para activar automáticamente sus cupos de consultas.
                </p>
            </div>
            
            <button type="button"
                    @click="tab = 'pagos'"
                    class="w-full py-3.5 px-5 rounded-2xl bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] text-white font-bold text-xs flex items-center justify-between transition-all shadow-md">
                <span x-text="'Entrar a Validar (' + pagosPendientesCount + ')'"></span>
                <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
            </button>
        </div>

        {{-- Tarjeta 3: Pacientes Activos --}}
        <div class="bg-white rounded-3xl p-7 border border-slate-200/90 shadow-xl shadow-slate-900/5 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-purple-50 text-[#9F7AEA] flex items-center justify-center text-2xl mb-5 group-hover:scale-110 group-hover:bg-[#9F7AEA] group-hover:text-white transition-all shadow-sm">
                    <i class="fas fa-id-card-alt"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold text-slate-900 mb-2">
                    Pacientes Activos
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                    Directorio completo de historias clínicas digitales, consumos de cupo y estados de membresía.
                </p>
            </div>
            
            <button type="button"
                    @click="tab = 'pacientes'"
                    class="w-full py-3.5 px-5 rounded-2xl bg-slate-50 hover:bg-[#1E6F9F] text-slate-700 hover:text-white font-bold text-xs flex items-center justify-between transition-all group-hover:shadow-md">
                <span>Entrar al Directorio</span>
                <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
            </button>
        </div>

    </div>

    {{-- Métricas Estadísticas del Sistema --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#1E6F9F] flex items-center justify-center text-xl flex-shrink-0">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-bold uppercase">Afiliados Totales</span>
                <strong class="text-2xl font-serif font-bold text-slate-900 block">1.420</strong>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-bold uppercase">Por Verificar</span>
                <strong class="text-2xl font-serif font-bold text-amber-600 block" x-text="pagosPendientesCount"></strong>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-bold uppercase">Recaudación Mes</span>
                <strong class="text-2xl font-serif font-bold text-emerald-600 block">$35.500</strong>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-[#9F7AEA] flex items-center justify-center text-xl flex-shrink-0">
                <i class="fas fa-tooth"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-bold uppercase">Consultas del Mes</span>
                <strong class="text-2xl font-serif font-bold text-[#9F7AEA] block">428</strong>
            </div>
        </div>
    </div>

    {{-- Vista Rápida: Últimos Pagos Pendientes --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl shadow-slate-900/5">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-serif text-2xl font-bold text-slate-900">
                    Atención Inmediata de Pagos Móviles
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Pacientes esperando activación de sus 6 consultas anuales.
                </p>
            </div>
            <button type="button" @click="tab = 'pagos'" class="text-xs font-bold text-[#1E6F9F] hover:underline">
                Ver todos los pagos →
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="pb-3 font-bold">Fecha</th>
                        <th class="pb-3 font-bold">Paciente</th>
                        <th class="pb-3 font-bold">Plan</th>
                        <th class="pb-3 font-bold">Referencia</th>
                        <th class="pb-3 font-bold">Monto</th>
                        <th class="pb-3 font-bold text-right">Acción Rápida</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-4 text-xs font-medium text-slate-500">Hoy · 04:12 PM</td>
                        <td class="py-4">
                            <strong class="text-slate-800 block">Carlos Mendoza</strong>
                            <span class="text-xs text-slate-400">V-18.452.901</span>
                        </td>
                        <td class="py-4 font-semibold text-[#1E6F9F]">Plan Plus</td>
                        <td class="py-4 font-mono font-bold text-slate-800">#859421</td>
                        <td class="py-4 font-bold text-slate-900">Bs. 22.944,38 <span class="text-[11px] text-slate-400 font-normal">($25)</span></td>
                        <td class="py-4 text-right">
                            <button type="button" @click="tab = 'pagos'" class="px-4 py-2 rounded-xl bg-blue-50 text-[#1E6F9F] hover:bg-[#1E6F9F] hover:text-white text-xs font-bold transition">
                                Validar Comprobante
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-4 text-xs font-medium text-slate-500">Hoy · 02:45 PM</td>
                        <td class="py-4">
                            <strong class="text-slate-800 block">María Elena Gómez</strong>
                            <span class="text-xs text-slate-400">V-25.789.012</span>
                        </td>
                        <td class="py-4 font-semibold text-slate-800">Plan Premium</td>
                        <td class="py-4 font-mono font-bold text-slate-800">#994821</td>
                        <td class="py-4 font-bold text-slate-900">Bs. 36.711,00 <span class="text-[11px] text-slate-400 font-normal">($40)</span></td>
                        <td class="py-4 text-right">
                            <button type="button" @click="tab = 'pagos'" class="px-4 py-2 rounded-xl bg-blue-50 text-[#1E6F9F] hover:bg-[#1E6F9F] hover:text-white text-xs font-bold transition">
                                Validar Comprobante
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>