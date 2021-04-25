<?php

namespace App\Http\Resources\Tender;

use Illuminate\Http\Resources\Json\JsonResource;

class TenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'member_id'         => $this->member_id,
            'member'            => $this->member->username,
            'member_email'      => $this->member->email,
            'price'             => $this->price,
            'auction_id'        => $this->auction_id,
            'auction_title'     => $this->auction->auction_title,
            'auction_ending'    => $this->auction->end_data,
            'created_at'        => $this->created_at,
        ];
    }
}
