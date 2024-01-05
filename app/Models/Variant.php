<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Variant extends Model implements HasMedia
{
    use HasFactory, SoftDeletes,InteractsWithMedia;
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function discount(){
        return $this->belongsTo(Discount::class,'discount_id');
    }
    public function getImage(){
        return ($this->getFirstMediaUrl('variant-image')) ? $this->getFirstMediaUrl('variant-image') : asset('cipuk/img/default.png');
    }
}
