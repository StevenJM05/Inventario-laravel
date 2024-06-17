<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'usuario_id',
        'descuentos_adicionales',
        'cantidad_total',
        'subtotal',
        'descuentos_totales',
        'total_impuestos',
        'total'
    ];
    use HasFactory;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id'); 
    }
    public function ventas_items()
    {
        return $this->hasMany(VentasItem::class, 'venta_id');
    }
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }

    public function kardex()
    {
        return $this->morphMany(Kardex::class, 'transaccionable');
    }
}
