<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
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
            'product_name' => $this->product->name,
            'name' => $this->name,
            'real_price' => rupiah($this->price),
            'is_discount' => ($this->discount->value == 0 or $this->discount->status == 'OFF') ? false : true,
            'discount' => discount($this->discount->value, $this->discount->type),
            'price' => $this->price - discount($this->discount->value, $this->discount->type, $this->price),
            'rupiah' => rupiah($this->price - discount($this->discount->value, $this->discount->type, $this->price)),
            'stock' => $this->stock,
            'image' => $this->getImage(),
        ];
    }
}
