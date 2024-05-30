<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = [
        'fecha',
        'cliente',
        'numero_factura',
        'total',
        'impuesto',
        'total_con_impuesto'

    ];
    use HasFactory;

    public function ventas(){
        return $this->hasOne(Venta::class);
    }
}
