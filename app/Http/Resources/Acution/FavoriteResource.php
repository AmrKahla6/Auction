<?php

namespace App\Http\Resources\Acution;

use App\Models\Member;
use App\Models\Auction;
use App\Models\AuctionImage;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $member   = Member::where('id',$this->auction->member_id)->first();
        $username = $member->username;



        $image = ImageResource::collection(AuctionImage::where('auction_id',$this->auction_id)->get());
        return [
            'id'               => $this->id,
            'member_id'        => $this->member_id,
            'member'           => $this->member->username,
            'is_like'          => $this->is_like,
            'auction_id'       => $this->auction_id,
            'acution_owner'    => $username,
            'title'            => $this->auction->auction_title ,
            'price'            => $this->auction->price ,
            'price_closing'    => $this->auction->price_closing ,
            'start_data'       => $this->auction->start_data ,
            'end_data'         => $this->auction->end_data ,
            'detials'          => $this->auction->detials,
            'is_finished'      => $this->auction->is_finished,
            "images"           => $image,
        ];
    }
}
