<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    protected $fillable = [
        'porcentaje'
    ];

    use HasFactory;

    public function ventas()
    {
        return $this->hasMany(Ventas::class);
    }
}
