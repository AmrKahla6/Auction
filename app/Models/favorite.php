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

    public static   function is_favorite($auction_id){
      $member_id =  Member::find(auth()->guard('members')->id());
     // dd($member_id);
     $ucation = Auction::find($auction_id);
     $count = $ucation->favorites()->get()->count();

      if($count > 0){
        return true;
      }else{
         return false;
      }

    }
}
