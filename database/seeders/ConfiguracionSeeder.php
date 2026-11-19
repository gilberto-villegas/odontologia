<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configuraciones = [
            [
                'clave' => 'horario_lunes_viernes',
                'valor' => '9:00 am a 12:30 pm y 2:00 pm a 5:30 pm',
            ],
            [
                'clave' => 'horario_sabados',
                'valor' => '9:00 am a 1:00 pm',
            ],
            [
                'clave' => 'direccion_sede',
                'valor' => 'Av. Principal, Torre Médica Dental, Piso 4, Consultorio 402',
            ],
            [
                'clave' => 'telefono_contacto',
                'valor' => '+58 422 0584267',
            ],
        ];

        foreach ($configuraciones as $config) {
            Configuracion::updateOrCreate(
                ['clave' => $config['clave']],
                ['valor' => $config['valor']]
            );
        }
    }
}
