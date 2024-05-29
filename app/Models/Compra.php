<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'cantidad',
        'subtotal',
        'descuento',
        'total'
        
    ];

    use HasFactory;

    public function compra_items()
    {
        return $this->hasMany(Compra_items::class);
    }
}
