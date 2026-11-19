<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Renombrar tabla users a usuarios si existe
        if (Schema::hasTable('users') && !Schema::hasTable('usuarios')) {
            Schema::rename('users', 'usuarios');
        }

        // Si no existe, crear la tabla usuarios
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('apellido');
                $table->string('cedula')->unique();
                $table->integer('edad');
                $table->string('email')->unique();
                $table->string('password');
                $table->enum('rol', ['administrador', 'paciente'])->default('paciente');
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            // Modificar columnas de la tabla renombrada
            Schema::table('usuarios', function (Blueprint $table) {
                if (Schema::hasColumn('usuarios', 'name') && !Schema::hasColumn('usuarios', 'nombre')) {
                    $table->renameColumn('name', 'nombre');
                }
                if (!Schema::hasColumn('usuarios', 'apellido')) {
                    $table->string('apellido')->default('')->after('nombre');
                }
                if (!Schema::hasColumn('usuarios', 'cedula')) {
                    $table->string('cedula')->nullable()->unique()->after('apellido');
                }
                if (!Schema::hasColumn('usuarios', 'edad')) {
                    $table->integer('edad')->default(18)->after('cedula');
                }
                if (!Schema::hasColumn('usuarios', 'rol')) {
                    $table->enum('rol', ['administrador', 'paciente'])->default('paciente')->after('password');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('usuarios')) {
            Schema::table('usuarios', function (Blueprint $table) {
                if (Schema::hasColumn('usuarios', 'nombre')) {
                    $table->renameColumn('nombre', 'name');
                }
                $table->dropColumn(array_filter(['apellido', 'cedula', 'edad', 'rol'], function ($col) {
                    return Schema::hasColumn('usuarios', $col);
                }));
            });

            Schema::rename('usuarios', 'users');
        }
    }
};
