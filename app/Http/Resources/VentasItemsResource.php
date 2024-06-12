<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VentasItemsResource extends JsonResource
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
            'venta_id' => $this->venta_id,
            'nombre_producto' => $this->producto->nombre,
            'cantidad'=> $this->cantidad,
            'precio_unidad' => $this->precio_unidad,
            'impuesto' => $this->impuesto,
            'total'=> $this->total
        ];
    }
}
