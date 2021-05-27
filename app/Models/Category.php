<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function subcategory(){
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function params(){
        return $this->hasMany(catParameter::class, 'cat_id');
    }

    public function auctions(){
        return $this->hasMany(Auction::class,'cat_id');
    }
    
    public function auction_details(){
        return $this->hasMany(AuctionDetials::class,'cat_id');
    }
}
