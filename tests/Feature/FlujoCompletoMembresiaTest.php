<?php

namespace Tests\Feature;

use App\Models\Cita;
use App\Models\Configuracion;
use App\Models\HistoriaMedica;
use App\Models\Pago;
use App\Models\Plan;
use App\Models\Suscripcion;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FlujoCompletoMembresiaTest extends TestCase
{
    /**
     * Prueba integral del flujo del paciente y administrador.
     */
    public function test_recorrido_completo_paciente_y_administrador(): void
    {
        // 0. Preparar datos base
        $planPlus = Plan::firstOrCreate(
            ['nombre' => 'Plan Plus'],
            [
                'precio' => 25.00,
                'descripcion' => 'Plan Plus Restaurativo',
                'caracteristicas' => ['6 consultas anuales', '2 resinas'],
                'activo' => true,
            ]
        );

        $admin = Usuario::firstOrCreate(
            ['email' => 'admin@odontologia.test'],
            [
                'nombre' => 'Dr. Roberto',
                'apellido' => 'Méndez',
                'cedula' => 'V-10200300',
                'edad' => 45,
                'password' => Hash::make('admin123'),
                'rol' => 'administrador',
            ]
        );

        // ==========================================
        // 1. FLUJO PACIENTE: Registro
        // ==========================================
        $responseRegistro = $this->post(route('registro.post'), [
            'nombre' => 'Elena',
            'apellido' => 'Ramos',
            'cedula' => 'V-28999888',
            'edad' => 26,
            'email' => 'elena.ramos@test.com',
            'password' => 'secret123',
            'plan_id' => $planPlus->id,
            'terminos' => '1',
        ]);

        $responseRegistro->assertRedirect();
        $paciente = Usuario::where('email', 'elena.ramos@test.com')->first();
        $this->assertNotNull($paciente);
        $this->assertEquals('paciente', $paciente->rol);

        $suscripcion = Suscripcion::where('usuario_id', $paciente->id)->first();
        $this->assertNotNull($suscripcion);
        $this->assertEquals('pendiente', $suscripcion->estado);

        // ==========================================
        // 2. FLUJO PACIENTE: Sube Pago Móvil
        // ==========================================
        $responsePago = $this->actingAs($paciente)->post(route('pago.store'), [
            'suscripcion_id' => $suscripcion->id,
            'banco' => 'Banesco',
            'referencia' => '7845129',
            'monto_bs' => 22944.38,
            'monto_usd' => 25.00,
            'fecha_pago' => now()->toDateString(),
        ]);

        $responsePago->assertRedirect(route('pago.exitoso'));
        $pago = Pago::where('suscripcion_id', $suscripcion->id)->first();
        $this->assertNotNull($pago);
        $this->assertEquals('pendiente', $pago->estado);

        // ==========================================
        // 3. FLUJO ADMIN: Concilia y Aprueba Pago
        // ==========================================
        $responseAprobar = $this->actingAs($admin)->post(route('admin.pagos.aprobar', $pago));
        $responseAprobar->assertRedirect();

        $pago->refresh();
        $suscripcion->refresh();
        $this->assertEquals('aprobado', $pago->estado);
        $this->assertEquals('activa', $suscripcion->estado);
        $this->assertEquals(6, $suscripcion->consultas_disponibles);

        // ==========================================
        // 4. FLUJO PACIENTE: Inicia sesión y Agenda Cita (de 6 pasa a 5)
        // ==========================================
        $fechaCita = now()->addDays(2)->toDateString();
        $horaCita = '10:30:00';

        $responseCita = $this->actingAs($paciente)->post(route('paciente.citas.store'), [
            'fecha' => $fechaCita,
            'hora' => $horaCita,
            'motivo' => 'Limpieza y Profilaxis Ultrasónica',
            'nombre_doctor' => 'Dr. Roberto Méndez',
        ]);

        $responseCita->assertRedirect(route('paciente.dashboard'));
        $suscripcion->refresh();
        $this->assertEquals(5, $suscripcion->consultas_disponibles, 'Las consultas disponibles deben bajar a 5');

        $cita = Cita::where('usuario_id', $paciente->id)->first();
        $this->assertNotNull($cita);
        $this->assertEquals('confirmada', $cita->estado);

        // ==========================================
        // 5. CUELLO DE BOTELLA: Evitar doble reserva misma hora
        // ==========================================
        $responseCitaDuplicada = $this->actingAs($paciente)->post(route('paciente.citas.store'), [
            'fecha' => $fechaCita,
            'hora' => $horaCita,
            'motivo' => 'Revisión por Dolor',
        ]);
        $responseCitaDuplicada->assertSessionHas('error');
        $suscripcion->refresh();
        $this->assertEquals(5, $suscripcion->consultas_disponibles, 'No debe descontar consulta en cita rechazada por colisión');

        // ==========================================
        // 6. FLUJO ADMIN: Llena Historia Clínica
        // ==========================================
        $responseHistoria = $this->actingAs($admin)->post(route('admin.historias.store'), [
            'usuario_id' => $paciente->id,
            'cita_id' => $cita->id,
            'alergias' => 'Ninguna conocida',
            'antecedentes' => 'Sin antecedentes sistémicos',
            'procedimiento_realizado' => 'Profilaxis completa con ultrasonido y pulido con pasta fluorada',
            'notas' => 'Piezas sanas, encía marginal sin sangrado',
            'fecha_registro' => now()->toDateString(),
        ]);

        $responseHistoria->assertRedirect();
        $historia = HistoriaMedica::where('usuario_id', $paciente->id)->first();
        $this->assertNotNull($historia);
        $this->assertStringContainsString('Profilaxis', $historia->procedimiento_realizado);

        // ==========================================
        // 7. FLUJO ADMIN: Bloquea Paciente (No puede agendar)
        // ==========================================
        $responseToggle = $this->actingAs($admin)->post(route('admin.pacientes.toggle', $paciente));
        $responseToggle->assertRedirect();
        $suscripcion->refresh();
        $this->assertEquals('suspendida', $suscripcion->estado);

        // El paciente intenta agendar estando suspendido:
        $responseIntentoBloqueado = $this->actingAs($paciente)->post(route('paciente.citas.store'), [
            'fecha' => now()->addDays(5)->toDateString(),
            'hora' => '14:00:00',
            'motivo' => 'Revisión',
        ]);
        $responseIntentoBloqueado->assertSessionHas('error');

        // ==========================================
        // 8. FLUJO ADMIN: Modifica Configuración y Planes
        // ==========================================
        $responseConfig = $this->actingAs($admin)->post(route('admin.configuracion.update'), [
            'horario_lunes_viernes' => '8:30 am a 1:00 pm y 2:00 pm a 6:00 pm',
            'planes' => [
                $planPlus->id => [
                    'precio' => 28.00,
                    'activo' => 'on',
                    'caracteristicas' => "6 consultas anuales\n2 restauraciones\n1 prótesis básica",
                ],
            ],
        ]);
        $responseConfig->assertRedirect();

        $planPlus->refresh();
        $this->assertEquals(28.00, $planPlus->precio);
        $this->assertTrue($planPlus->activo);
    }
}
