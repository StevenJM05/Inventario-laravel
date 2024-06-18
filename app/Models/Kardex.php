<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'kardex';

    protected $fillable = [
        'producto_id',
        'transaccionable_id',
        'transaccionable_type',
        'cantidad',
        'precio_unitario',
        'total',
        'tipo_movimiento',
        'stock_anterior',
        'stock_actual',
        'fecha',
    ];

    public function transaccionable()
    {
        return $this->morphTo();
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
