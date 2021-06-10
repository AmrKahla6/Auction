<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionDetials extends Model
{
    protected $guarded = [];


    public function auction(){
        return $this->belongsTo(Auction::class,'auction_id');
    }
    public function cat_parm(){
        return $this->belongsTo(catParameter::class,'param_value_id','id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'cat_id');
    }


    public function auctionWithImages(){
        return $this->belongsTo(Auction::class,'auction_id')->with('images');
    }

 /*   public function param(){
        return $this->belongsTo(selectParams::class,'param_value_id','id');
    }*/


    public function type(){
        return $this->belongsTo(selectParams::class,'type_id');
    }


    public function type(){
        return $this->belongsTo(selectParams::class,'type_id','id');
    }

}
