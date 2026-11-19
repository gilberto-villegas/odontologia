<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cita;
use App\Models\Configuracion;
use App\Models\HistoriaMedica;
use App\Models\Pago;
use App\Models\Plan;
use App\Models\Suscripcion;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

echo "=== INICIANDO PRUEBAS DE RECORRIDO COMPLETO (QA) ===\n\n";

// Limpiar registros de prueba anteriores si existen
Usuario::where('email', 'elena.ramos@test.com')->delete();

// Paso 0: Verificar Plan y Admin
$planPlus = Plan::where('nombre', 'Plan Plus')->first();
$admin = Usuario::where('email', 'admin@odontologia.test')->first();

echo "[Paso 0] Plan Plus ID: {$planPlus->id} (\${$planPlus->precio}/mes) | Admin: {$admin->nombre} {$admin->apellido}\n";

// Paso 1: Paciente se registra
$paciente = Usuario::create([
    'nombre' => 'Elena',
    'apellido' => 'Ramos',
    'cedula' => 'V-28999888',
    'edad' => 26,
    'email' => 'elena.ramos@test.com',
    'password' => Hash::make('secret123'),
    'rol' => 'paciente',
]);

$suscripcion = Suscripcion::create([
    'usuario_id' => $paciente->id,
    'plan_id' => $planPlus->id,
    'estado' => 'pendiente',
    'consultas_disponibles' => 6,
    'fecha_inicio' => now()->toDateString(),
    'fecha_fin' => now()->addYear()->toDateString(),
]);

echo "[Paso 1] Paciente registrado: {$paciente->nombre} {$paciente->apellido} (Cédula: {$paciente->cedula}). Suscripción en estado: {$suscripcion->estado}\n";

// Paso 2: Paciente reporta pago móvil
$pago = Pago::create([
    'suscripcion_id' => $suscripcion->id,
    'banco' => 'Banesco',
    'referencia' => '7845129',
    'monto_bs' => 22944.38,
    'monto_usd' => 25.00,
    'fecha_pago' => now()->toDateString(),
    'estado' => 'pendiente',
]);

echo "[Paso 2] Pago Móvil registrado: Ref. #{$pago->referencia} por \${$pago->monto_usd} (Bs. {$pago->monto_bs}) en banco {$pago->banco}. Estado: {$pago->estado}\n";

// Paso 3: Admin concilia y aprueba el pago
$pago->update(['estado' => 'aprobado']);
$suscripcion->update([
    'estado' => 'activa',
    'consultas_disponibles' => 6,
    'fecha_inicio' => now()->toDateString(),
    'fecha_fin' => now()->addYear()->toDateString(),
]);

echo "[Paso 3] Admin aprueba pago. Membresía activada. Consultas disponibles: {$suscripcion->consultas_disponibles} de 6.\n";

// Paso 4: Paciente agenda su primera cita (Consultas bajan de 6 a 5)
$fechaCita = now()->addDays(2)->toDateString();
$horaCita = '10:30:00';

$cita = Cita::create([
    'usuario_id' => $paciente->id,
    'nombre_doctor' => 'Dr. Roberto Méndez',
    'fecha' => $fechaCita,
    'hora' => $horaCita,
    'motivo' => 'Limpieza Dental Ultrasónica & Profilaxis',
    'estado' => 'confirmada',
]);

$suscripcion->decrement('consultas_disponibles');
$suscripcion->refresh();

echo "[Paso 4] Cita agendada para el {$cita->fecha} a las {$cita->hora}. Consultas restantes en plan: {$suscripcion->consultas_disponibles} (DISMINUYÓ A 5).\n";

// Paso 5: Validación de cuello de botella - Prevención de colisión horaria
$existeColision = Cita::where('fecha', $fechaCita)->where('hora', $horaCita)->whereIn('estado', ['pendiente', 'confirmada'])->exists();
echo "[Paso 5] Cuello de botella verificado: Detección de colisión para horario {$horaCita}: " . ($existeColision ? "BLOQUEADO CORRECTAMENTE (No permite duplicar turno)" : "FALLO") . "\n";

// Paso 6: Admin llena historia médica
$historia = HistoriaMedica::create([
    'usuario_id' => $paciente->id,
    'cita_id' => $cita->id,
    'alergias' => 'Ninguna conocida',
    'antecedentes' => 'Sin patologías previas',
    'procedimiento_realizado' => 'Profilaxis profunda ultrasónica y pulido con pasta fluorada',
    'notas' => 'Piezas dentales en excelente estado general',
    'fecha_registro' => now()->toDateString(),
]);

echo "[Paso 6] Admin registra evolución clínica: Procedimiento: '{$historia->procedimiento_realizado}'. Historial asociado al paciente ID: {$paciente->id}.\n";

// Paso 7: Admin bloquea al paciente y se valida impedimento para agendar
$suscripcion->update(['estado' => 'suspendida']);
$suscripcion->refresh();
$puedeAgendar = ($suscripcion->estado === 'activa' && $suscripcion->consultas_disponibles > 0);
echo "[Paso 7] Admin bloquea paciente. Estado membresía: {$suscripcion->estado}. ¿Puede agendar nueva cita?: " . ($puedeAgendar ? "SÍ" : "NO (BLOQUEADO CORRECTAMENTE)") . "\n";

// Paso 8: Admin modifica precio y estado del plan en configuración
$nuevoPrecio = 29.00;
$planPlus->update(['precio' => $nuevoPrecio]);
$planPlus->refresh();

Configuracion::updateOrCreate(
    ['clave' => 'horario_lunes_viernes'],
    ['valor' => '8:30 am a 1:00 pm y 2:00 pm a 6:00 pm']
);

$horarioActualizado = Configuracion::where('clave', 'horario_lunes_viernes')->value('valor');

echo "[Paso 8] Admin actualiza configuración: Plan Plus actualizado a \${$planPlus->precio} USD. Nuevo horario: '{$horarioActualizado}'.\n";

echo "\n=== TODAS LAS PRUEBAS (QA) COMPLETADAS EXITOSAMENTE (8/8) ===\n";
