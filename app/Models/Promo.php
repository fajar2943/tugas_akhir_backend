<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Promo extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;
    protected $guarded = [];

    public function getImage(){
        return ($this->getFirstMediaUrl('promo-banner')) ? $this->getFirstMediaUrl('promo-banner') : asset('cipuk/img/default2.png');
    }
}
