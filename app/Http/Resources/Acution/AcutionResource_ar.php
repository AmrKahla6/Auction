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
        if($this->is_finished == 1){
            $finish = true;
        }else{
            $finish = false;
        }
        return [
            'id'              => $this->id,
            'member_id'       => $this->member_id,
            'title'           => $this->auction_title,
            'member_name'     => $this->member->username,
            'address'         => $this->address,
            'gover_id'        => $this->gover_id,
            'governorate'     => $this->governorate->governorate_name_ar,
            'city_id'         => $this->city_id,
            'city'            => $this->city->city_name_ar,
            'price'           => $this->price,
            'price_opining'   => $this->price_opining,
            'price_closing'   => $this->price_closing,
            'start_data'      => $this->start_data,
            'end_data'        => $this->end_data,
            'is_finished'     => $finish,
            'detials'         => $this->detials,
            'cat_id'          => $this->cat_id,
            'cat_name'        => $this->category->category_name_ar,
            'created_at'      => $this->created_at,
            'cat_detidals'    => DetialsResource::collection($this->more_detials),
            'images'          => ImageResource::collection($this->images),
        ];
    }
}
