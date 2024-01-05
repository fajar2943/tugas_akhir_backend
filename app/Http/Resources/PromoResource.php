<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'discount' => discount($this->value, $this->type),
            'min_price' => rupiah($this->min_price),
            'max_discount' => rupiah($this->max_discount),
            'start_date' => tgltime($this->start_date),
            'finish_date' => tgltime($this->finish_date),
            'code' => $this->code,
            'image' => $this->getImage(),
            'default_image' => asset('cipuk/img/default2.png'),
        ];
    }
}
