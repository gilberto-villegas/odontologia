<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planes = [
            [
                'nombre' => 'Plan Básico',
                'precio' => 15.00,
                'descripcion' => '6 consultas anuales (limpieza + revisión diagnóstica), extracciones simples y descuentos preferenciales en ortodoncia y prótesis.',
                'caracteristicas' => [
                    '6 consultas anuales (limpieza + revisión diagnóstica)',
                    'Extracciones simples cubiertas',
                    'Descuentos preferenciales en ortodoncia y prótesis',
                    'Historial clínico digital y recordatorios',
                    'Agenda en línea 24/7',
                ],
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Plus',
                'precio' => 25.00,
                'descripcion' => 'Todo lo del Plan Básico + 2 restauraciones simples al año + 1 prótesis básica, con mayor porcentaje de descuento en ortodoncia correctiva.',
                'caracteristicas' => [
                    'Todo lo del Plan Básico incluido',
                    '2 restauraciones simples al año (resina fotocurada)',
                    '1 prótesis básica (ajuste anatómico)',
                    'Mayor porcentaje de descuento en ortodoncia correctiva',
                    'Agendamiento preferente en horas punta',
                ],
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Premium',
                'precio' => 40.00,
                'descripcion' => 'Todo lo del Plan Plus + cobertura extendida en prótesis fija y ortodoncia, con atención prioritaria inmediata sin listas de espera.',
                'caracteristicas' => [
                    'Todo lo del Plan Plus incluido',
                    'Cobertura extendida en prótesis fija y ortodoncia',
                    'Atención prioritaria inmediata sin lista de espera',
                    'Consultas de urgencia dental cubiertas',
                ],
                'activo' => true,
            ],
        ];

        foreach ($planes as $plan) {
            Plan::updateOrCreate(
                ['nombre' => $plan['nombre']],
                $plan
            );
        }
    }
}
