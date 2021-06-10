<?php

namespace App\Models;

use App\Models\Auction;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function auction(){
        return $this->belongsTo(Auction::class)->with('images');
    }
}
