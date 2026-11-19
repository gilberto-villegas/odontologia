@php
    $pagosData = isset($pagos) ? $pagos->map(function($p) {
        return [
            'id' => $p->id,
            'fecha' => $p->created_at ? $p->created_at->format('d/m/Y · h:i A') : ($p->fecha_pago ? date('d/m/Y', strtotime($p->fecha_pago)) : 'N/A'),
            'paciente' => ($p->suscripcion && $p->suscripcion->usuario) ? $p->suscripcion->usuario->nombre . ' ' . $p->suscripcion->usuario->apellido : 'Paciente',
            'cedula' => ($p->suscripcion && $p->suscripcion->usuario) ? $p->suscripcion->usuario->cedula : 'V-00.000.000',
            'telefono' => ($p->suscripcion && $p->suscripcion->usuario) ? ($p->suscripcion->usuario->telefono ?? '0414-0000000') : '0414-0000000',
            'banco' => $p->banco ?? 'Pago Móvil',
            'plan' => ($p->suscripcion && $p->suscripcion->plan) ? $p->suscripcion->plan->nombre : 'Membresía',
            'referencia' => (string)$p->referencia,
            'montoBs' => number_format($p->monto_bs, 2, ',', '.'),
            'montoUsd' => (float)$p->monto_usd,
            'estado' => ucfirst(strtolower($p->estado)),
        ];
    })->values() : [
        [ 'id' => 1, 'fecha' => 'Hoy · 04:12 PM', 'paciente' => 'Carlos Mendoza', 'cedula' => 'V-18.452.901', 'telefono' => '0414-9876543', 'banco' => 'Banesco', 'plan' => 'Plan Plus', 'referencia' => '859421', 'montoBs' => '22.944,38', 'montoUsd' => 25, 'estado' => 'Pendiente' ],
        [ 'id' => 2, 'fecha' => 'Hoy · 02:45 PM', 'paciente' => 'María Elena Gómez', 'cedula' => 'V-25.789.012', 'telefono' => '0424-5551234', 'banco' => 'Mercantil', 'plan' => 'Plan Premium', 'referencia' => '994821', 'montoBs' => '36.711,00', 'montoUsd' => 40, 'estado' => 'Pendiente' ],
        [ 'id' => 3, 'fecha' => 'Hoy · 11:15 AM', 'paciente' => 'Javier Delgado', 'cedula' => 'V-19.882.100', 'telefono' => '0412-3334455', 'banco' => 'Banco de Venezuela', 'plan' => 'Plan Básico', 'referencia' => '314205', 'montoBs' => '13.766,63', 'montoUsd' => 15, 'estado' => 'Pendiente' ],
        [ 'id' => 4, 'fecha' => 'Ayer · 06:30 PM', 'paciente' => 'Sofía Martínez', 'cedula' => 'V-20.123.456', 'telefono' => '0412-1234567', 'banco' => 'Banesco', 'plan' => 'Plan Plus', 'referencia' => '112948', 'montoBs' => '22.944,38', 'montoUsd' => 25, 'estado' => 'Aprobado' ],
        [ 'id' => 5, 'fecha' => 'Ayer · 03:10 PM', 'paciente' => 'Andrés Suárez', 'cedula' => 'V-22.341.990', 'telefono' => '0416-8889900', 'banco' => 'BBVA Provincial', 'plan' => 'Plan Básico', 'referencia' => '742189', 'montoBs' => '13.766,63', 'montoUsd' => 15, 'estado' => 'Aprobado' ],
        [ 'id' => 6, 'fecha' => '16 Feb · 01:20 PM', 'paciente' => 'Patricia Blanco', 'cedula' => 'V-16.700.111', 'telefono' => '0414-0001122', 'banco' => 'Bancamiga', 'plan' => 'Plan Plus', 'referencia' => '004182', 'montoBs' => '22.944,38', 'montoUsd' => 25, 'estado' => 'Rechazado' ]
    ];
@endphp

<div x-data="gestionPagos()" class="space-y-6">

    {{-- Encabezado de la Sección --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-block text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100 mb-2">
                Control de Conciliación
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-slate-900">
                Validar Pagos Móviles
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Aprueba o rechaza los comprobantes reportados para la activación inmediata de los planes.
            </p>
        </div>

        {{-- Filtros Rápidos (Alpine.js) --}}
        <div class="flex items-center gap-1.5 p-1.5 bg-white rounded-2xl border border-slate-200/90 shadow-sm self-start sm:self-auto text-xs font-bold">
            <button type="button"
                    @click="filtro = 'todos'"
                    class="px-3.5 py-2 rounded-xl transition"
                    :class="filtro === 'todos' ? 'bg-[#1E6F9F] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'">
                Todos (<span x-text="pagos.length"></span>)
            </button>
            <button type="button"
                    @click="filtro = 'pendiente'"
                    class="px-3.5 py-2 rounded-xl transition flex items-center gap-1.5"
                    :class="filtro === 'pendiente' ? 'bg-amber-500 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'">
                <span>Pendientes</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px]" :class="filtro === 'pendiente' ? 'bg-amber-700 text-white' : 'bg-amber-100 text-amber-800'" x-text="pagosPendientesCount"></span>
            </button>
            <button type="button"
                    @click="filtro = 'aprobado'"
                    class="px-3.5 py-2 rounded-xl transition"
                    :class="filtro === 'aprobado' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'">
                Aprobados
            </button>
            <button type="button"
                    @click="filtro = 'rechazado'"
                    class="px-3.5 py-2 rounded-xl transition"
                    :class="filtro === 'rechazado' ? 'bg-rose-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'">
                Rechazados
            </button>
        </div>
    </div>

    {{-- Tabla Principal de Validación de Pagos --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl shadow-slate-900/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="pb-3.5 font-bold">Fecha / Hora</th>
                        <th class="pb-3.5 font-bold">Paciente & Datos</th>
                        <th class="pb-3.5 font-bold">Plan Suscrito</th>
                        <th class="pb-3.5 font-bold">Referencia & Banco</th>
                        <th class="pb-3.5 font-bold">Monto Transferido</th>
                        <th class="pb-3.5 font-bold">Estado Actual</th>
                        <th class="pb-3.5 font-bold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="item in pagosFiltrados()" :key="item.id">
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            
                            {{-- Fecha --}}
                            <td class="py-4 text-xs font-semibold text-slate-500 whitespace-nowrap" x-text="item.fecha"></td>

                            {{-- Paciente --}}
                            <td class="py-4">
                                <strong class="text-slate-900 text-sm font-bold block" x-text="item.paciente"></strong>
                                <span class="text-xs text-slate-400 block" x-text="item.cedula + ' · ' + item.telefono"></span>
                            </td>

                            {{-- Plan --}}
                            <td class="py-4 whitespace-nowrap">
                                <span class="font-bold text-xs px-3 py-1 rounded-full bg-blue-50 text-[#1E6F9F] border border-blue-100"
                                      x-text="item.plan">
                                </span>
                            </td>

                            {{-- Referencia y Banco --}}
                            <td class="py-4">
                                <span class="font-mono font-bold text-sm text-slate-800 block" x-text="'#' + item.referencia"></span>
                                <span class="text-xs text-slate-400 block" x-text="item.banco"></span>
                            </td>

                            {{-- Monto --}}
                            <td class="py-4 whitespace-nowrap">
                                <strong class="text-slate-900 font-bold block" x-text="'Bs. ' + item.montoBs"></strong>
                                <span class="text-xs text-slate-400" x-text="'($' + item.montoUsd + ' USD)'"></span>
                            </td>

                            {{-- Estado con badge animado según estado --}}
                            <td class="py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold"
                                      :class="{
                                          'bg-amber-50 text-amber-700 border border-amber-200': item.estado === 'Pendiente',
                                          'bg-emerald-50 text-emerald-700 border border-emerald-200': item.estado === 'Aprobado',
                                          'bg-rose-50 text-rose-700 border border-rose-200': item.estado === 'Rechazado'
                                      }">
                                    <span class="w-1.5 h-1.5 rounded-full"
                                          :class="{
                                              'bg-amber-500 animate-ping': item.estado === 'Pendiente',
                                              'bg-emerald-500': item.estado === 'Aprobado',
                                              'bg-rose-500': item.estado === 'Rechazado'
                                          }"></span>
                                    <span x-text="item.estado"></span>
                                </span>
                            </td>

                            {{-- Botones de Acción: Aprobar / Rechazar --}}
                            <td class="py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    {{-- Botón Aprobar (Verde/Azul) --}}
                                    <button type="button"
                                            @click="aprobarPago(item)"
                                            :disabled="item.estado === 'Aprobado'"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl font-bold text-xs transition-all shadow-sm"
                                            :class="item.estado === 'Aprobado' ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-emerald-700/20 hover:scale-105'">
                                        <i class="fas fa-check text-[11px]"></i>
                                        <span>Aprobar</span>
                                    </button>

                                    {{-- Botón Rechazar (Rojo) --}}
                                    <button type="button"
                                            @click="rechazarPago(item)"
                                            :disabled="item.estado === 'Rechazado'"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl font-bold text-xs transition-all"
                                            :class="item.estado === 'Rechazado' ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-200'">
                                        <i class="fas fa-times text-[11px]"></i>
                                        <span>Rechazar</span>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    </template>

                    {{-- Estado vacío si no hay registros en la vista o filtro actual --}}
                    <tr x-show="pagosFiltrados().length === 0">
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <i class="fas fa-check-circle text-4xl text-slate-200 mb-3 block"></i>
                            <span class="font-medium text-sm">No hay pagos pendientes ni registros en esta categoría.</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-400">
            <span>* Al hacer clic en <strong>Aprobar</strong>, el sistema carga automáticamente las 6 consultas al expediente del paciente.</span>
            <span class="font-bold text-slate-600" x-text="'Mostrando ' + pagosFiltrados().length + ' registros'"></span>
        </div>
    </div>

</div>

<script>
    function gestionPagos() {
        return {
            filtro: 'todos',
            pagosPendientesCount: 0,
            pagos: @json($pagosData),
            init() {
                this.recalcularPendientes();
            },
            aprobarPago(item) {
                item.estado = 'Aprobado';
                this.recalcularPendientes();

                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                fetch(`/admin/pagos/${item.id}/aprobar`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).catch(err => console.error('Error al aprobar pago:', err));

                if (typeof showToast === 'function') {
                    showToast('¡Pago de ' + item.paciente + ' aprobado! Se activaron 6 consultas anuales.');
                }
            },
            rechazarPago(item) {
                item.estado = 'Rechazado';
                this.recalcularPendientes();

                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                fetch(`/admin/pagos/${item.id}/rechazar`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).catch(err => console.error('Error al rechazar pago:', err));

                if (typeof showToast === 'function') {
                    showToast('Pago #' + item.referencia + ' rechazado.');
                }
            },
            recalcularPendientes() {
                this.pagosPendientesCount = this.pagos.filter(p => p.estado.toLowerCase() === 'pendiente').length;
                window.dispatchEvent(new CustomEvent('actualizar-pagos-pendientes', { detail: this.pagosPendientesCount }));
            },
            pagosFiltrados() {
                if (this.filtro === 'todos') return this.pagos;
                return this.pagos.filter(p => p.estado.toLowerCase() === this.filtro.toLowerCase());
            }
        };
    }
</script>
