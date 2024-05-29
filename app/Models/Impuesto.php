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

    public function productos()
    {
        return $this->hasMany(Productos::class);
    }
}
