<?php

namespace App\Http\Resources\Acution;

use Illuminate\Http\Resources\Json\JsonResource;

class sliderResource_en extends JsonResource
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
            'description'     => $this->desc_en,
            'price_opining'   => $this->price_opining,
            'price_closing'   => $this->price_closing,
            'start_data'      => $this->start_data,
            'end_data'        => $this->end_data,
            'created_at'      => $this->created_at,
            'images'          => ImageResource::collection($this->images),
        ];
    }
}
