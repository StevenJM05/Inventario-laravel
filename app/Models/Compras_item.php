<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compras_item extends Model
{
    protected $fillable = [
        'compra_id',
        'producto_id',
        'cantidad',
        'descuento',
        'precio_unitario',
        'total'

    ];
    use HasFactory;

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }
    public function Producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
