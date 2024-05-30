<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'marca_id',
        'categorias_id',
        'unidad_medida_id',
        'is_available',
        'stock',
        'impuestos_id'
    ];

    use HasFactory;

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
    public function categorias()
    {
        return $this->belongsTo(Impuesto::class, 'categorias_id');
    }
    public function unidad_medida()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }
    public function impuestos()
    {
        return $this->belongsTo(Impuesto::class, 'impuestos_id');
    }
    public function compras_items()
    {
        return $this->hasMany(Compras_item::class);
    }
}
