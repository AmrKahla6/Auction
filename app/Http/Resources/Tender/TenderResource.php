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
            'id'         => $this->id,
            'member_id'  => $this->member_id,
            'member'     => $this->member->username,
            'auction_id' => $this->auction_id,
            'created_at' => $this->created_at,
        ];
    }
}
