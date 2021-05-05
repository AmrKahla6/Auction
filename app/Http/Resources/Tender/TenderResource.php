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
        if($this->is_winner == 0){
            $winner = __('user.nowinner');
        }else{
            $winner = __('user.is_winner');
        }

        return [
            'id'                => $this->id,
            'member_id'         => $this->member_id,
            'member'            => $this->member->username,
            'member_email'      => $this->member->email,
            'winner'            => $winner,
            'price'             => $this->price,
            'auction_id'        => $this->auction_id,
            'auction_title'     => $this->auction->auction_title,
            'ending_date'       => $this->auction->end_data,
            'created_at'        => $this->created_at,
        ];
    }
}
