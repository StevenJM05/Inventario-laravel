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
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id'); // Debes especificar el nombre del campo de la clave foránea
    }
    public function ventas_items()
    {
        return $this->hasMany(Ventas_items::class);
    }
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
}
