<?php

namespace App\Http\Resources\AppSetting;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
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
            'link' => $this->link,
            'img'  => asset('uploads/advertisement/'.$this->img),
        ];
    }
}
