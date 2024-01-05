<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes,InteractsWithMedia;
    protected $guarded = [];

    public function getImage(){
        return ($this->getFirstMediaUrl('product-image')) ? $this->getFirstMediaUrl('product-image') : asset('cipuk/img/default.png');
    }
    
    public function categories(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function variants(){
        return $this->hasMany(Variant::class);
    }
}