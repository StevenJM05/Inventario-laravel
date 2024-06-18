<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompraItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'compra_id' => $this->compra_id,
            'nombre_producto' => $this->producto->nombre,
            'cantidad'=> $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'total'=> $this->total
        ];
    }
}
