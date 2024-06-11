<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentasItem extends Model
{
    
    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'decuento',
        'precio_unidad',
        'impuesto',
        'total'
    ];
    use HasFactory;
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id'); 
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id'); 
    }
}
