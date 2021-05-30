<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catParameter extends Model
{
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class,'cat_id');
    }
    public function auction_detail(){
        return $this->hasMany(AuctionDetials::class,'param_value_id');
    }

    public function selected(){
        return $this->hasMany(selectParams::class, 'param_id');
    }
}
