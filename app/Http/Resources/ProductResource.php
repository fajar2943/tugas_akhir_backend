<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $min = $this->variants->min('price');
        $max = $this->variants->max('price'); 
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->categories->name,
            'price' => ($min == $max) ? "Rp ". angka($min) : "Rp ". angka($min). " - ". angka($max),
            'image' => $this->getImage(),
            'discount' => $this->_max_discount($this->variants)
        ];
    }

    private function _max_discount($variants){
        $result = 0;
        $max = 0;
        foreach($variants as $variant){
            $value = $variant->discount->value;
            $type = $variant->discount->type;
            $discount = discount($value, $type, $variant->price);
            if($variant->discount->status == 'ON' && $discount > $max){
                $max = $discount;
                $result = ($type == 'Percent') ? $value.'%' : ($value/1000).'K';
            }
        }
        return $result;
    }
}
