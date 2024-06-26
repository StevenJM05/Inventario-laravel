<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marca';
    protected $fillable = [
        'nombre'
    ];

    use HasFactory;

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
