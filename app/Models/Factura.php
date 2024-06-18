<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'factura';
    protected $fillable = [
        'fecha',
        'cliente',
        'numero_factura',
        'total',
        'impuesto',
        'total_con_impuesto',
        'ventas_id',
        'usuario_id'

    ];
    use HasFactory;

    public function ventas(){
        return $this->hasOne(Venta::class, 'ventas_id');
    }
}
