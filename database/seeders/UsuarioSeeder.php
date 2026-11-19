<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::updateOrCreate(
            ['email' => 'admin@odontologia.test'],
            [
                'nombre' => 'Dr. Roberto',
                'apellido' => 'Méndez',
                'cedula' => 'V-10200300',
                'edad' => 45,
                'email' => 'admin@odontologia.test',
                'password' => Hash::make('admin123'),
                'rol' => 'administrador',
            ]
        );
    }
}
