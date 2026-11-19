<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'edad',
        'email',
        'password',
        'rol',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Obtener los atributos que deben ser convertidos a tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'edad' => 'integer',
        ];
    }

    /**
     * Relación: Un usuario tiene muchas suscripciones.
     */
    public function suscripciones(): HasMany
    {
        return $this->hasMany(Suscripcion::class, 'usuario_id');
    }

    /**
     * Relación: Un usuario tiene muchas citas médicas.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'usuario_id');
    }

    /**
     * Relación: Un usuario tiene muchas historias médicas.
     */
    public function historiasMedicas(): HasMany
    {
        return $this->hasMany(HistoriaMedica::class, 'usuario_id');
    }
}
