{{-- resources/views/admin-pacientes.blade.php --}}
<div x-data="gestionPacientes()" class="space-y-6">

    {{-- Encabezado Principal y Acciones --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <span class="w-2.5 h-8 bg-gradient-to-b from-[#1E6F9F] to-[#C8B6E2] rounded-full"></span>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-slate-900">
                    Gestión de Pacientes
                </h1>
            </div>
            <p class="text-slate-500 text-xs sm:text-sm mt-1 ml-5">
                Administra el directorio de pacientes, estados de membresía e historias clínicas.
            </p>
        </div>

        {{-- Botón Exportar a Excel --}}
        <div class="flex items-center gap-3">
            <button type="button"
                    @click="exportarExcel()"
                    :disabled="exportando"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm shadow-sm hover:border-[#1E6F9F] hover:text-[#1E6F9F] hover:shadow-md transition-all duration-200 disabled:opacity-60">
                <template x-if="!exportando">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-file-excel text-emerald-600 text-base"></i>
                        <span>Exportar a Excel</span>
                    </span>
                </template>
                <template x-if="exportando">
                    <span class="flex items-center gap-2 text-slate-500">
                        <i class="fas fa-spinner fa-spin text-emerald-600"></i>
                        <span>Generando archivo...</span>
                    </span>
                </template>
            </button>
        </div>
    </div>

    {{-- Barra de Búsqueda y Métricas Rápidas --}}
    <div class="bg-white rounded-3xl p-4 sm:p-6 border border-slate-200/90 shadow-xl shadow-slate-900/5 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            {{-- Input de Búsqueda --}}
            <div class="relative flex-1 max-w-md">
                <input type="text"
                       x-model="search"
                       placeholder="Buscar por nombre, cédula, email o plan..."
                       class="w-full pl-11 pr-10 py-3 rounded-2xl border border-slate-200 bg-slate-50/70 text-slate-800 text-xs sm:text-sm outline-none focus:bg-white focus:border-[#1E6F9F] focus:ring-2 focus:ring-[#1E6F9F]/15 transition-all">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 text-sm">
                    <i class="fas fa-search"></i>
                </div>
                <button type="button"
                        x-show="search"
                        @click="search = ''"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 text-xs">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>

            {{-- Contadores Rápidos --}}
            <div class="flex items-center gap-2 sm:gap-4 text-xs font-semibold">
                <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 text-slate-700 border border-slate-200">
                    Total: <strong class="text-slate-900" x-text="pacientes.length"></strong>
                </span>
                <span class="px-3.5 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Activos: <strong x-text="pacientes.filter(p => p.estado === 'Activo').length"></strong>
                </span>
                <span class="px-3.5 py-1.5 rounded-xl bg-rose-50 text-rose-700 border border-rose-200">
                    Bloqueados: <strong x-text="pacientes.filter(p => p.estado === 'Bloqueado').length"></strong>
                </span>
            </div>
        </div>

        {{-- Tabla de Pacientes --}}
        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 text-[11px] uppercase tracking-wider font-bold">
                        <th class="py-3.5 px-4">Paciente</th>
                        <th class="py-3.5 px-4">Cédula</th>
                        <th class="py-3.5 px-4 hidden md:table-cell">Email</th>
                        <th class="py-3.5 px-4">Plan</th>
                        <th class="py-3.5 px-4 text-center">Consultas Restantes</th>
                        <th class="py-3.5 px-4 text-center">Estado</th>
                        <th class="py-3.5 px-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <template x-for="paciente in pacientesFiltrados" :key="paciente.id">
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            {{-- Nombre + Avatar --}}
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#1E6F9F] to-[#C8B6E2] text-white font-bold flex items-center justify-center text-xs shadow-sm flex-shrink-0"
                                         x-text="paciente.nombre.split(' ').map(n => n[0]).slice(0, 2).join('')">
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 leading-snug" x-text="paciente.nombre"></p>
                                        <p class="text-[11px] text-slate-400 md:hidden" x-text="paciente.email"></p>
                                    </div>
                                </div>
                            </td>

                            {{-- Cédula --}}
                            <td class="py-3.5 px-4 text-slate-700 font-mono text-xs whitespace-nowrap" x-text="paciente.cedula"></td>

                            {{-- Email --}}
                            <td class="py-3.5 px-4 text-slate-600 hidden md:table-cell" x-text="paciente.email"></td>

                            {{-- Plan --}}
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold"
                                      :class="{
                                          'bg-blue-50 text-[#1E6F9F] border border-blue-100': paciente.plan.includes('Básico'),
                                          'bg-purple-50 text-purple-700 border border-purple-100': paciente.plan.includes('Plus'),
                                          'bg-amber-50 text-amber-700 border border-amber-100': paciente.plan.includes('Premium')
                                      }">
                                    <i class="fas fa-crown text-[10px]"></i>
                                    <span x-text="paciente.plan"></span>
                                </span>
                            </td>

                            {{-- Consultas Restantes --}}
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <span class="font-bold px-2 py-0.5 rounded-md text-xs font-mono"
                                          :class="paciente.consultasRestantes > 2 ? 'bg-emerald-50 text-emerald-700' : (paciente.consultasRestantes > 0 ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700')"
                                          x-text="paciente.consultasRestantes + ' de ' + paciente.consultasTotales">
                                    </span>
                                </div>
                            </td>

                            {{-- Estado (Badge Verde / Rojo) --}}
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border"
                                      :class="paciente.estado === 'Activo' 
                                          ? 'bg-emerald-50 text-emerald-700 border-emerald-200' 
                                          : 'bg-rose-50 text-rose-700 border-rose-200'">
                                    <span class="w-1.5 h-1.5 rounded-full"
                                          :class="paciente.estado === 'Activo' ? 'bg-emerald-500' : 'bg-rose-500'"></span>
                                    <span x-text="paciente.estado"></span>
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    {{-- Botón Ver Ficha --}}
                                    <button type="button"
                                            @click="abrirFicha(paciente)"
                                            class="px-3 py-1.5 rounded-xl bg-blue-50 text-[#1E6F9F] hover:bg-[#1E6F9F] hover:text-white border border-blue-200/70 text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                                        <i class="fas fa-id-card"></i>
                                        <span>Ver Ficha</span>
                                    </button>

                                    {{-- Botón Bloquear / Activar --}}
                                    <button type="button"
                                            @click="toggleEstado(paciente)"
                                            :title="paciente.estado === 'Activo' ? 'Bloquear paciente' : 'Activar paciente'"
                                            class="px-3 py-1.5 rounded-xl border text-xs font-bold transition flex items-center gap-1.5 shadow-sm"
                                            :class="paciente.estado === 'Activo'
                                                ? 'bg-white border-rose-200 text-rose-600 hover:bg-rose-600 hover:text-white'
                                                : 'bg-white border-emerald-200 text-emerald-700 hover:bg-emerald-600 hover:text-white'">
                                        <i class="fas" :class="paciente.estado === 'Activo' ? 'fa-user-slash' : 'fa-user-check'"></i>
                                        <span x-text="paciente.estado === 'Activo' ? 'Bloquear' : 'Activar'"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>

                    {{-- Sin Resultados --}}
                    <tr x-show="pacientesFiltrados.length === 0">
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <i class="fas fa-user-times text-3xl mb-2 text-slate-300"></i>
                            <p class="font-bold text-slate-600 text-sm">No se encontraron pacientes</p>
                            <p class="text-xs text-slate-400 mt-0.5">Intenta con otro término de búsqueda.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- MODAL: FICHA DEL PACIENTE --}}
    {{-- ======================================================== --}}
    <div x-show="modalFicha"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.away="modalFicha = false"
             class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative max-h-[92vh] flex flex-col overflow-hidden">
            
            <template x-if="pacienteSeleccionado">
                <div class="flex-1 overflow-y-auto pr-1 space-y-6">

                    {{-- Encabezado Modal: Datos Personales Arriba --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#1E6F9F] to-[#C8B6E2] text-white font-bold flex items-center justify-center text-xl shadow-md flex-shrink-0"
                                 x-text="pacienteSeleccionado.nombre.split(' ').map(n => n[0]).slice(0, 2).join('')">
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-serif text-xl sm:text-2xl font-bold text-slate-900" x-text="pacienteSeleccionado.nombre"></h3>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border"
                                          :class="pacienteSeleccionado.estado === 'Activo' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200'"
                                          x-text="pacienteSeleccionado.estado">
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 mt-1">
                                    <span><i class="fas fa-id-card text-slate-400 mr-1"></i> <strong class="text-slate-700" x-text="pacienteSeleccionado.cedula"></strong></span>
                                    <span><i class="fas fa-envelope text-slate-400 mr-1"></i> <span x-text="pacienteSeleccionado.email"></span></span>
                                    <span><i class="fas fa-phone text-slate-400 mr-1"></i> <span x-text="pacienteSeleccionado.telefono"></span></span>
                                </div>
                            </div>
                        </div>

                        {{-- Botón Cerrar --}}
                        <button type="button"
                                @click="modalFicha = false"
                                class="self-start sm:self-center w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-700 flex items-center justify-center transition">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>

                    {{-- Tabs con Alpine.js --}}
                    <div class="flex items-center gap-2 border-b border-slate-200">
                        <button type="button"
                                @click="tabFicha = 'plan'"
                                class="pb-3 px-4 text-xs sm:text-sm font-bold border-b-2 transition flex items-center gap-2"
                                :class="tabFicha === 'plan' 
                                    ? 'border-[#1E6F9F] text-[#1E6F9F]' 
                                    : 'border-transparent text-slate-400 hover:text-slate-700'">
                            <i class="fas fa-gem"></i>
                            <span>Detalles del Plan</span>
                        </button>

                        <button type="button"
                                @click="tabFicha = 'historial'"
                                class="pb-3 px-4 text-xs sm:text-sm font-bold border-b-2 transition flex items-center gap-2"
                                :class="tabFicha === 'historial' 
                                    ? 'border-[#1E6F9F] text-[#1E6F9F]' 
                                    : 'border-transparent text-slate-400 hover:text-slate-700'">
                            <i class="fas fa-notes-medical"></i>
                            <span>Historial Clínico</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600"
                                  x-text="pacienteSeleccionado.historial.length"></span>
                        </button>
                    </div>

                    {{-- CONTENIDO TAB 1: PLAN --}}
                    <div x-show="tabFicha === 'plan'" class="space-y-6">
                        
                        {{-- Tarjeta de Información del Plan --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-[#1E6F9F] block">Plan Actual</span>
                                <strong class="text-base font-bold text-slate-900 block mt-1" x-text="pacienteSeleccionado.plan"></strong>
                                <span class="text-xs text-slate-500" x-text="'$' + pacienteSeleccionado.precioPlan + ' USD / mes'"></span>
                            </div>

                            <div class="p-4 rounded-2xl bg-purple-50/60 border border-purple-100">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-purple-700 block">Consultas Disponibles</span>
                                <div class="flex items-baseline gap-1 mt-1">
                                    <strong class="text-xl font-bold text-purple-900" x-text="pacienteSeleccionado.consultasRestantes"></strong>
                                    <span class="text-xs text-purple-600" x-text="'de ' + pacienteSeleccionado.consultasTotales + ' anuales'"></span>
                                </div>
                                {{-- Barra de progreso --}}
                                <div class="w-full bg-purple-200/80 rounded-full h-1.5 mt-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-[#1E6F9F] to-[#9F7AEA] h-1.5 rounded-full"
                                         :style="'width: ' + ((pacienteSeleccionado.consultasRestantes / pacienteSeleccionado.consultasTotales) * 100) + '%'"></div>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Vencimiento Membresía</span>
                                <strong class="text-sm font-bold text-slate-800 block mt-1" x-text="pacienteSeleccionado.fechaVencimiento"></strong>
                                <span class="text-[11px] text-slate-400" x-text="'Afiliado el ' + pacienteSeleccionado.fechaAfiliacion"></span>
                            </div>
                        </div>

                        {{-- Botón para desplegar formulario de Extensión --}}
                        <div class="flex items-center justify-between pt-2">
                            <p class="text-xs text-slate-500">
                                ¿El paciente requiere consultas adicionales o renovar su vigencia?
                            </p>
                            <button type="button"
                                    @click="mostrarFormExtension = !mostrarFormExtension"
                                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] text-white text-xs font-bold shadow-md transition flex items-center gap-2">
                                <i class="fas fa-plus-circle"></i>
                                <span x-text="mostrarFormExtension ? 'Ocultar Extensión' : 'Extender Membresía'"></span>
                            </button>
                        </div>

                        {{-- Sub-formulario: Extender Membresía --}}
                        <div x-show="mostrarFormExtension"
                             x-collapse
                             class="bg-slate-50/90 rounded-2xl p-5 border border-slate-200 space-y-4">
                            <div class="flex items-center gap-2 text-slate-800 font-bold text-xs uppercase tracking-wider">
                                <i class="fas fa-calendar-plus text-[#1E6F9F]"></i>
                                <span>Añadir Consultas o Modificar Vencimiento</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Sumar consultas adicionales
                                    </label>
                                    <select x-model.number="formExtension.consultasExtra"
                                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs font-semibold outline-none focus:border-[#1E6F9F]">
                                        <option value="1">+1 Consulta adicional</option>
                                        <option value="2">+2 Consultas adicionales</option>
                                        <option value="3">+3 Consultas adicionales</option>
                                        <option value="6">+6 Consultas (Renovación anual)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Nueva fecha de vencimiento
                                    </label>
                                    <input type="date"
                                           x-model="formExtension.nuevaFechaVencimiento"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs font-semibold outline-none focus:border-[#1E6F9F]">
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-2 pt-2">
                                <button type="button"
                                        @click="mostrarFormExtension = false"
                                        class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-200/60 transition">
                                    Cancelar
                                </button>
                                <button type="button"
                                        @click="guardarExtension()"
                                        class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md transition flex items-center gap-1.5">
                                    <i class="fas fa-check"></i>
                                    <span>Aplicar Extensión</span>
                                </button>
                            </div>
                        </div>

                    </div>

                    {{-- CONTENIDO TAB 2: HISTORIAL CLÍNICO --}}
                    <div x-show="tabFicha === 'historial'" class="space-y-6">

                        {{-- Antecedentes Médicos y Alergias --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-2xl bg-amber-50/40 border border-amber-200/70 text-xs">
                            <div>
                                <span class="font-bold text-amber-800 uppercase tracking-wider block mb-1">
                                    <i class="fas fa-notes-medical mr-1"></i> Antecedentes Médicos
                                </span>
                                <p class="text-slate-700 font-medium" x-text="pacienteSeleccionado.antecedentes || 'Sin antecedentes reportados'"></p>
                            </div>
                            <div>
                                <span class="font-bold text-rose-800 uppercase tracking-wider block mb-1">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Alergias Registradas
                                </span>
                                <p class="text-slate-700 font-medium" x-text="pacienteSeleccionado.alergias || 'Ninguna alergia conocida'"></p>
                            </div>
                        </div>

                        {{-- Barra de Acción: Botón Añadir Registro --}}
                        <div class="flex items-center justify-between">
                            <h4 class="font-serif text-lg font-bold text-slate-800">
                                Evoluciones y Procedimientos
                            </h4>
                            <button type="button"
                                    @click="mostrarFormRegistro = !mostrarFormRegistro"
                                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-[#1E6F9F] to-[#16567C] hover:from-[#1E6F9F] hover:to-[#9F7AEA] text-white text-xs font-bold shadow-md transition flex items-center gap-2">
                                <i class="fas fa-file-medical"></i>
                                <span x-text="mostrarFormRegistro ? 'Cerrar Formulario' : 'Añadir Registro'"></span>
                            </button>
                        </div>

                        {{-- Formulario para Antecedentes / Procedimiento / Notas --}}
                        <div x-show="mostrarFormRegistro"
                             x-collapse
                             class="bg-slate-50/90 rounded-2xl p-5 border border-slate-200 space-y-4">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">
                                Nuevo Registro de Atención Clínica
                            </span>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Fecha</label>
                                    <input type="date"
                                           x-model="nuevoHistorial.fecha"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs outline-none focus:border-[#1E6F9F]">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Doctor Tratante</label>
                                    <input type="text"
                                           x-model="nuevoHistorial.doctor"
                                           placeholder="Dr. Roberto Méndez"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs outline-none focus:border-[#1E6F9F]">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Procedimiento Realizado</label>
                                <input type="text"
                                       x-model="nuevoHistorial.procedimiento"
                                       placeholder="Ej: Profilaxis profunda, Restauración con resina compuesta..."
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs outline-none focus:border-[#1E6F9F]">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Actualizar Antecedentes</label>
                                    <input type="text"
                                           x-model="nuevoHistorial.antecedentes"
                                           placeholder="Ej: Hipertensión controlada"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs outline-none focus:border-[#1E6F9F]">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-600 mb-1">Actualizar Alergias</label>
                                    <input type="text"
                                           x-model="nuevoHistorial.alergias"
                                           placeholder="Ej: Penicilina, anestesia local"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs outline-none focus:border-[#1E6F9F]">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Notas de Evolución y Recomendaciones</label>
                                <textarea x-model="nuevoHistorial.notas"
                                          rows="3"
                                          placeholder="Detalle el estado periodontal, piezas tratadas, prescripción..."
                                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs outline-none focus:border-[#1E6F9F]"></textarea>
                            </div>

                            <div class="flex items-center justify-end gap-2 pt-2">
                                <button type="button"
                                        @click="mostrarFormRegistro = false"
                                        class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-200/60 transition">
                                    Cancelar
                                </button>
                                <button type="button"
                                        @click="agregarRegistroHistorial()"
                                        class="px-5 py-2 rounded-xl bg-[#1E6F9F] hover:bg-[#16567C] text-white text-xs font-bold shadow-md transition flex items-center gap-1.5">
                                    <i class="fas fa-save"></i>
                                    <span>Guardar en Historial</span>
                                </button>
                            </div>
                        </div>

                        {{-- Lista de Registros Previos (Timeline) --}}
                        <div class="space-y-3">
                            <template x-for="(item, idx) in pacienteSeleccionado.historial" :key="idx">
                                <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-sm hover:border-[#1E6F9F]/30 transition">
                                    <div class="flex items-center justify-between text-xs mb-1.5">
                                        <span class="font-bold text-slate-900 flex items-center gap-2">
                                            <i class="fas fa-calendar-check text-[#1E6F9F]"></i>
                                            <span x-text="item.fecha"></span>
                                        </span>
                                        <span class="text-slate-400 font-semibold" x-text="item.doctor"></span>
                                    </div>
                                    <h5 class="font-bold text-sm text-[#1E6F9F] mb-1" x-text="item.procedimiento"></h5>
                                    <p class="text-xs text-slate-600 leading-relaxed" x-text="item.notas"></p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            Cubierto por Membresía
                                        </span>
                                    </div>
                                </div>
                            </template>

                            <template x-if="pacienteSeleccionado.historial.length === 0">
                                <div class="py-8 text-center text-slate-400">
                                    <i class="fas fa-folder-open text-2xl text-slate-300 mb-1"></i>
                                    <p class="text-xs">No hay consultas ni procedimientos registrados aún.</p>
                                </div>
                            </template>
                        </div>

                    </div>

                    {{-- Footer del Modal: Zona de Peligro --}}
                    <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                        <button type="button"
                                @click="modalEliminar = true"
                                class="px-4 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 text-xs font-bold transition flex items-center gap-2">
                            <i class="fas fa-trash-alt"></i>
                            <span>Eliminar Paciente</span>
                        </button>

                        <button type="button"
                                @click="modalFicha = false"
                                class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition">
                            Cerrar Ficha
                        </button>
                    </div>

                </div>
            </template>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- MODAL DE CONFIRMACIÓN: ELIMINAR PACIENTE --}}
    {{-- ======================================================== --}}
    <div x-show="modalEliminar"
         x-cloak
         class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div @click.away="modalEliminar = false"
             class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 text-center space-y-4">
            
            <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-2xl mx-auto shadow-inner">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

            <div>
                <h3 class="font-serif text-xl font-bold text-slate-900">¿Eliminar Paciente?</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Esta acción eliminará la ficha de <strong class="text-slate-800" x-text="pacienteSeleccionado?.nombre"></strong>, su plan de membresía y todo el historial clínico registrado. Esta acción no se puede deshacer.
                </p>
            </div>

            <div class="flex items-center justify-center gap-3 pt-2">
                <button type="button"
                        @click="modalEliminar = false"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Cancelar
                </button>
                <button type="button"
                        @click="eliminarPaciente()"
                        class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-900/20 transition flex items-center gap-1.5">
                    <i class="fas fa-trash-alt"></i>
                    <span>Sí, Eliminar</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Toast de Notificación Reactiva --}}
    <div x-show="toast"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         class="fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-5 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 text-xs sm:text-sm font-semibold border border-white/10 max-w-sm">
        <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs flex-shrink-0">
            <i class="fas fa-check"></i>
        </div>
        <span x-text="toastMsg"></span>
    </div>

</div>

{{-- Script de Alpine.js con Datos Reactivos Simulados --}}
<script>
    function gestionPacientes() {
        return {
            search: '',
            exportando: false,
            toast: false,
            toastMsg: '',
            modalFicha: false,
            modalEliminar: false,
            tabFicha: 'plan',
            mostrarFormExtension: false,
            mostrarFormRegistro: false,
            pacienteSeleccionado: null,

            nuevoHistorial: {
                fecha: new Date().toISOString().split('T')[0],
                doctor: 'Dr. Roberto Méndez',
                procedimiento: '',
                antecedentes: '',
                alergias: '',
                notas: ''
            },

            formExtension: {
                consultasExtra: 2,
                nuevaFechaVencimiento: '2027-02-15'
            },

            pacientes: [
                {
                    id: 1,
                    nombre: 'Sofía Martínez',
                    cedula: 'V-20.123.456',
                    email: 'sofia.martinez@ejemplo.com',
                    telefono: '0412-1234567',
                    plan: 'Plan Plus',
                    precioPlan: 25,
                    consultasRestantes: 6,
                    consultasTotales: 6,
                    estado: 'Activo',
                    fechaAfiliacion: '15/01/2026',
                    fechaVencimiento: '15/01/2027',
                    antecedentes: 'Sin enfermedades sistémicas relevantes.',
                    alergias: 'Penicilina (reacción leve reportada en 2021).',
                    historial: [
                        {
                            fecha: '12/02/2026',
                            doctor: 'Dra. Valentina Torres',
                            procedimiento: 'Limpieza Dental Ultrasónica & Profilaxis',
                            notas: 'Higiene oral adecuada. Retiro de cálculo supragingival en piezas inferiores.'
                        },
                        {
                            fecha: '18/01/2026',
                            doctor: 'Dr. Roberto Méndez',
                            procedimiento: 'Consulta Diagnóstica de Ingreso + Odontograma',
                            notas: 'Revisión general del plan de membresía. Piezas 16 y 26 en observación.'
                        }
                    ]
                },
                {
                    id: 2,
                    nombre: 'Carlos Mendoza',
                    cedula: 'V-18.452.901',
                    email: 'carlos.mendoza@gmail.com',
                    telefono: '0414-9876543',
                    plan: 'Plan Plus',
                    precioPlan: 25,
                    consultasRestantes: 4,
                    consultasTotales: 6,
                    estado: 'Activo',
                    fechaAfiliacion: '05/11/2025',
                    fechaVencimiento: '05/11/2026',
                    antecedentes: 'Hipertensión arterial controlada con Losartán 50mg.',
                    alergias: 'Ninguna conocida.',
                    historial: [
                        {
                            fecha: '10/01/2026',
                            doctor: 'Dr. Roberto Méndez',
                            procedimiento: 'Restauración con Resina Fotocurada (Pieza 36)',
                            notas: 'Cavidad oclusal clase I resuelta satisfactoriamente. Oclusión ajustada.'
                        },
                        {
                            fecha: '15/11/2025',
                            doctor: 'Dra. Valentina Torres',
                            procedimiento: 'Limpieza e Higiene General Anual',
                            notas: 'Tártaro moderado lingual. Paciente instruido en uso de hilo dental.'
                        }
                    ]
                },
                {
                    id: 3,
                    nombre: 'María Elena Gómez',
                    cedula: 'V-14.789.012',
                    email: 'maria.gomez@hotmail.com',
                    telefono: '0424-5551234',
                    plan: 'Plan Premium',
                    precioPlan: 40,
                    consultasRestantes: 5,
                    consultasTotales: 6,
                    estado: 'Activo',
                    fechaAfiliacion: '20/12/2025',
                    fechaVencimiento: '20/12/2026',
                    antecedentes: 'Tratamiento previo de ortodoncia concluido en 2023.',
                    alergias: 'Aines (Ibuprofeno).',
                    historial: [
                        {
                            fecha: '08/01/2026',
                            doctor: 'Dr. Roberto Méndez',
                            procedimiento: 'Control de Contención y Evaluación Oclusal',
                            notas: 'Retenedor inferior adaptado correctamente. Buena estabilidad dental.'
                        }
                    ]
                },
                {
                    id: 4,
                    nombre: 'Alejandro Rivas',
                    cedula: 'V-23.654.890',
                    email: 'alejandro.rivas@yahoo.com',
                    telefono: '0416-3334455',
                    plan: 'Plan Básico',
                    precioPlan: 15,
                    consultasRestantes: 1,
                    consultasTotales: 6,
                    estado: 'Bloqueado',
                    fechaAfiliacion: '02/03/2025',
                    fechaVencimiento: '02/03/2026',
                    antecedentes: 'Bruxismo nocturno leve.',
                    alergias: 'Ninguna.',
                    historial: [
                        {
                            fecha: '14/10/2025',
                            doctor: 'Dra. Valentina Torres',
                            procedimiento: 'Extracción Simple de Resto Radicular (Pieza 38)',
                            notas: 'Procedimiento bajo anestesia local sin complicaciones. Cicatrización favorable.'
                        }
                    ]
                },
                {
                    id: 5,
                    nombre: 'Laura Castillo',
                    cedula: 'V-26.980.123',
                    email: 'laura.castillo@outlook.com',
                    telefono: '0414-7778899',
                    plan: 'Plan Plus',
                    precioPlan: 25,
                    consultasRestantes: 6,
                    consultasTotales: 6,
                    estado: 'Activo',
                    fechaAfiliacion: '02/02/2026',
                    fechaVencimiento: '02/02/2027',
                    antecedentes: 'Sin antecedentes patológicos.',
                    alergias: 'Ninguna.',
                    historial: [
                        {
                            fecha: '05/02/2026',
                            doctor: 'Dr. Roberto Méndez',
                            procedimiento: 'Evaluación y Diagnóstico Inicial',
                            notas: 'Paciente ingresa al Plan Plus con su cuota de 6 consultas intacta.'
                        }
                    ]
                },
                {
                    id: 6,
                    nombre: 'Andrés Quintero',
                    cedula: 'V-19.321.456',
                    email: 'andres.quintero@gmail.com',
                    telefono: '0412-8889900',
                    plan: 'Plan Premium',
                    precioPlan: 40,
                    consultasRestantes: 3,
                    consultasTotales: 6,
                    estado: 'Activo',
                    fechaAfiliacion: '11/08/2025',
                    fechaVencimiento: '11/08/2026',
                    antecedentes: 'Fumador ocasional.',
                    alergias: 'Polvo / polen.',
                    historial: [
                        {
                            fecha: '15/12/2025',
                            doctor: 'Dr. Roberto Méndez',
                            procedimiento: 'Mantenimiento Periodontal y Pulido de Superficies',
                            notas: 'Eliminación de manchas extrínsecas por tabaco.'
                        }
                    ]
                }
            ],

            get pacientesFiltrados() {
                if (!this.search.trim()) {
                    return this.pacientes;
                }
                const q = this.search.toLowerCase();
                return this.pacientes.filter(p => 
                    p.nombre.toLowerCase().includes(q) ||
                    p.cedula.toLowerCase().includes(q) ||
                    p.email.toLowerCase().includes(q) ||
                    p.plan.toLowerCase().includes(q)
                );
            },

            toggleEstado(paciente) {
                paciente.estado = (paciente.estado === 'Activo') ? 'Bloqueado' : 'Activo';
                this.mostrarToast(
                    paciente.estado === 'Activo' 
                        ? `Paciente ${paciente.nombre} ha sido activado.` 
                        : `Paciente ${paciente.nombre} ha sido bloqueado.`
                );
            },

            abrirFicha(paciente) {
                this.pacienteSeleccionado = paciente;
                this.tabFicha = 'plan';
                this.mostrarFormExtension = false;
                this.mostrarFormRegistro = false;
                this.nuevoHistorial = {
                    fecha: new Date().toISOString().split('T')[0],
                    doctor: 'Dr. Roberto Méndez',
                    procedimiento: '',
                    antecedentes: paciente.antecedentes || '',
                    alergias: paciente.alergias || '',
                    notas: ''
                };
                this.modalFicha = true;
            },

            guardarExtension() {
                if (!this.pacienteSeleccionado) return;
                
                const extra = parseInt(this.formExtension.consultasExtra) || 0;
                this.pacienteSeleccionado.consultasRestantes += extra;
                this.pacienteSeleccionado.consultasTotales += extra;

                if (this.formExtension.nuevaFechaVencimiento) {
                    const partes = this.formExtension.nuevaFechaVencimiento.split('-');
                    if (partes.length === 3) {
                        this.pacienteSeleccionado.fechaVencimiento = `${partes[2]}/${partes[1]}/${partes[0]}`;
                    }
                }

                this.mostrarFormExtension = false;
                this.mostrarToast(`Membresía extendida: +${extra} consultas añadidas.`);
            },

            agregarRegistroHistorial() {
                if (!this.nuevoHistorial.procedimiento.trim()) {
                    alert('Por favor ingresa el procedimiento realizado.');
                    return;
                }

                const fechaFormateada = this.nuevoHistorial.fecha 
                    ? this.nuevoHistorial.fecha.split('-').reverse().join('/') 
                    : new Date().toLocaleDateString('es-VE');

                this.pacienteSeleccionado.historial.unshift({
                    fecha: fechaFormateada,
                    doctor: this.nuevoHistorial.doctor || 'Dr. Roberto Méndez',
                    procedimiento: this.nuevoHistorial.procedimiento,
                    notas: this.nuevoHistorial.notas || 'Sin observaciones adicionales.'
                });

                if (this.nuevoHistorial.antecedentes) {
                    this.pacienteSeleccionado.antecedentes = this.nuevoHistorial.antecedentes;
                }
                if (this.nuevoHistorial.alergias) {
                    this.pacienteSeleccionado.alergias = this.nuevoHistorial.alergias;
                }

                // Descontar una consulta restante si tiene disponibles
                if (this.pacienteSeleccionado.consultasRestantes > 0) {
                    this.pacienteSeleccionado.consultasRestantes -= 1;
                }

                this.mostrarFormRegistro = false;
                this.mostrarToast('Nuevo registro clínico añadido exitosamente.');
            },

            eliminarPaciente() {
                if (!this.pacienteSeleccionado) return;
                const nombre = this.pacienteSeleccionado.nombre;
                this.pacientes = this.pacientes.filter(p => p.id !== this.pacienteSeleccionado.id);
                this.modalEliminar = false;
                this.modalFicha = false;
                this.pacienteSeleccionado = null;
                this.mostrarToast(`Paciente ${nombre} eliminado del sistema.`);
            },

            exportarExcel() {
                this.exportando = true;

                // Simular generación y descarga de archivo CSV / Excel
                setTimeout(() => {
                    const headers = ['ID', 'Nombre', 'Cedula', 'Email', 'Telefono', 'Plan', 'Consultas Restantes', 'Estado', 'Vencimiento'];
                    const rows = this.pacientes.map(p => [
                        p.id,
                        `"${p.nombre}"`,
                        `"${p.cedula}"`,
                        `"${p.email}"`,
                        `"${p.telefono}"`,
                        `"${p.plan}"`,
                        p.consultasRestantes,
                        `"${p.estado}"`,
                        `"${p.fechaVencimiento}"`
                    ]);

                    const csvContent = 'data:text/csv;charset=utf-8,\uFEFF' 
                        + [headers.join(','), ...rows.map(e => e.join(','))].join('\n');

                    const encodedUri = encodeURI(csvContent);
                    const link = document.createElement('a');
                    link.setAttribute('href', encodedUri);
                    link.setAttribute('download', 'directorio_pacientes_odontologia.csv');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    this.exportando = false;
                    this.mostrarToast('Archivo Excel descargado con éxito.');
                }, 800);
            },

            mostrarToast(msg) {
                this.toastMsg = msg;
                this.toast = true;
                setTimeout(() => this.toast = false, 3500);
            }
        }
    }
</script>
