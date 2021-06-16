<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class MainCategoryResource_en extends JsonResource
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
            'id'            => $this->id,
            'category_name' => $this->category_name_en,
            'img'           => asset('uploads/category/'.$this->img),
            'price'         => $this->price,
        ];
    }
}
