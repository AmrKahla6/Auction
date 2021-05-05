<?php

namespace App\Http\Resources\Acution;

use Illuminate\Http\Resources\Json\JsonResource;

class DetialsResource extends JsonResource
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
            'id'             => $this->id,
            'param_name_ar'  => $this->param_name_ar,
            'param_name_en'  => $this->param_name_en,
            'param_value'    => $this->param_value,
            'param_value_id' => $this->param_value_id,
            'auction_id'     => $this->auction_id,
            'cat_id'         => $this->cat_id,
        ];
    }
}
