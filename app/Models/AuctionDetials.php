<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionDetials extends Model
{
    protected $guarded = [];

    public function auction(){
        return $this->belongsTo(Auction::class,'auction_id');
    }

}
