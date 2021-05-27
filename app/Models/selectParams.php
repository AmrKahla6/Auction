<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class selectParams extends Model
{
    protected $guarded = [];

    public function param(){
        return $this->belongsTo(catParameter::class,'param_id');
    }

    public function auction_detail(){
        return $this->hasMany(AuctionDetials::class,'param_value_id');
    }
}
