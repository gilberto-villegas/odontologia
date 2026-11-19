<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'pagos';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'suscripcion_id',
        'banco',
        'referencia',
        'monto_bs',
        'monto_usd',
        'fecha_pago',
        'estado',
    ];

    /**
     * Obtener los atributos que deben ser convertidos a tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monto_bs' => 'decimal:2',
            'monto_usd' => 'decimal:2',
            'fecha_pago' => 'date',
        ];
    }

    /**
     * Relación: El pago pertenece a una suscripción.
     */
    public function suscripcion(): BelongsTo
    {
        return $this->belongsTo(Suscripcion::class, 'suscripcion_id');
    }
}
