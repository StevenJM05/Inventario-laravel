<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'marca_id',
        'categorias_id',
        'Unidad_medida_id',
        'is_available',
        'stock',
        'impuesto_id',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'categorias_id');
    }

    public function unidad_medida()
    {
        return $this->belongsTo(UnidadMedida::class, 'Unidad_medida_id');
    }

    public function impuestos()
    {
        return $this->belongsTo(Impuesto::class, 'impuesto_id');
    }
    
    public function compras_items()
    {
        return $this->hasMany(Compras_item::class);
    }
}
