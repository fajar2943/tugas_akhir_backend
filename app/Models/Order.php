<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function promos(){
        return $this->belongsTo(Promo::class,'promo_id');
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function admin(){
        return $this->belongsTo(User::class,'updated_by');
    }
    public function detail(){
        return $this->hasMany(Detail::class,'order_id');
    }
}
