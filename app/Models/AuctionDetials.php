<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionDetials extends Model
{
    protected $guarded = [];

    public function auction(){
        return $this->belongsTo(Auction::class,'auction_id');
    }

    public function auctionWithImages(){
        return $this->belongsTo(Auction::class,'auction_id')->with('images');
    }

    public function param(){
        return $this->belongsTo(selectParams::class,'param_value_id');
    }

    public function type(){
        return $this->belongsTo(selectParams::class,'type_id');
    }

}
