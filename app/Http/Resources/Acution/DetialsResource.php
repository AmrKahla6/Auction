<?php

namespace App\Http\Resources\Acution;

use App\Models\catParameter;
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


        $cat_parameters = catParameter::where('id',$this->param->id)->first();
        if($request->lang == "en"){
            $cat_name =  $cat_parameters->param_name_en;
        }else{
            $cat_name =  $cat_parameters->param_name_ar;
        }

        if($this->type_id){
            if($request->lang == "en"){
                $type = $this->type->param_name_en;
            }else{
                $type = $this->type->param_name_ar;
            }
        }else{
            $type = "";
        }

        if($this->param_value){
            $value = $this->param_value;
        }else{
            $value = "";
        }


        return [
            'id'             => $this->id,
            'param_value'    => $value,
            "select_value"   => $type,
            'param_value_id' => $this->param_value_id,
            'auction_id'     => $this->auction_id,
            'cat_id'         => $this->cat_id,
            'type_name'      => $cat_name,
        ];
    }
}
