<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_name' => $this->variant->product->name,
            'name' => $this->variant->name,
            'qty' => $this->qty,
            'price' => $this->price,
            'discount' => $this->discount,
            'subtotal' => $this->total,
        ];
    }
}
