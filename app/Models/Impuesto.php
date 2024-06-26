<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    use HasFactory;
    protected $table = 'impuestos';
    protected $fillable = ['nombre', 'porcentaje'];
    
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
