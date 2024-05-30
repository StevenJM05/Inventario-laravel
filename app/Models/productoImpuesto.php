<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productoImpuesto extends Model
{
    protected $fillable = [
        'producto_id',
        'impuesto_id'
    ];
    use HasFactory;

    public function productos()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function impuesto()
    {
        return $this->belongsTo(Impuesto::class, 'impuesto_id');
    }
}
