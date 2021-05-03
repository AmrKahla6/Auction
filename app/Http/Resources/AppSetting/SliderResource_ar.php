<?php

namespace App\Http\Resources\AppSetting;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource_ar extends JsonResource
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
            'title' => $this->title_ar,
            'body'  => $this->body_ar,
            'img'   => asset('uploads/slider/'.$this->img),
        ];
    }
}
