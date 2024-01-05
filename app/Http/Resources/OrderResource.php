<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'inv' => 'INV'.str_pad($this->id, 4, '0', STR_PAD_LEFT),
            'total_price' => rupiah($this->total_price),
            'status' => $this->status,
            'status_color' => statusColor($this->status),
            'created_at' => tgltime($this->created_at),
            'is_promo' => ($this->promos) ? true : false,
            'promo_name' => ($this->promos) ? $this->promos->name : '',
            'promo' => ($this->promos) ? discount($this->promos->value, $this->promos->type, $this->detail->sum('total')) : 0,
            'saving' => angka($this->detail->sum('discount') + $this->discount_promo),
        ];
    }
}
