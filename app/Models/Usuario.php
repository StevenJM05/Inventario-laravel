<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'user',
        'password'
    ];
    use HasFactory;

    public function Ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
