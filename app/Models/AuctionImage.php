<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionImage extends Model
{
  protected $guarded = [];

  public function auction(){
    return $this->belongsTo(AuctionImage::class,'auction_id');
}
}
