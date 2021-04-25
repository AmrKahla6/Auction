<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function auction(){
        return $this->belongsTo(Auction::class,'auction_id');
    }
}
