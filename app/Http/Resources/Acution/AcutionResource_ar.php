<?php

namespace App\Http\Resources\Acution;

use Illuminate\Http\Resources\Json\JsonResource;

class AcutionResource_ar extends JsonResource
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
            'id'              => $this->id,
            'member_id'       => $this->member_id,
            'member_name'     => $this->member->username,
            'city_id'         => $this->city_id,
            'address'         => $this->city->city_name_ar,
            'price'           => $this->price,
            'price_opining'   => $this->price_opining,
            'price_closing'   => $this->price_closing,
            'start_data'      => $this->start_data,
            'end_data'        => $this->end_data,
            'start_time'      => $this->start_time,
            'end_time'        => $this->end_time,
            'detials'         => $this->detials,
            'cat_id'          => $this->cat_id,
            'cat_name'        => $this->category->category_name_ar,
            'created_at'      => $this->created_at,
            'more_detials'    => $this->more_detials,
            'images'          => ImageResource::collection($this->images),
        ];
    }
}
