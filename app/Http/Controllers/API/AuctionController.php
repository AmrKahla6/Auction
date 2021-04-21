<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Member;
use App\Models\Auction;
use App\Models\AuctionType;
use App\Models\AuctionImage;
use App\Models\catParameter;
use Illuminate\Http\Request;
use App\Models\AuctionDetials;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;

class AuctionController extends BaseController
{
    public function auctionType(){
        $type = AuctionType::select("id","type_name_" .app()->getLocale() . ' as Acution Type')->get();
        if($type){
            return $this->returnData('Acution Type', $type);
        }
    }

    public function storeAcution(Request $request){
        $user = Member::where('id', $request->member_id)->first();
        if ($user) {
            $validator = Validator::make(
                $request->all(),
                [
                    'address'            => 'required',
                    'price'              => 'required',
                    'price_opining'      => 'required',
                    'price_closing'      => 'nullable',
                    'start_data'         => 'required',
                    'end_data'           => 'required',
                    'start_time'         => 'required',
                    'end_time'           => 'required',
                    'detials'            => 'required',
                    'cat_id'             => 'required',
                    'type_id'            => 'required',
                ],
                [
                    'address.required'             => __("user.address"),
                    'price.required'               => __("user.price"),
                    'price_opining.required'       => __("user.price_opining"),
                    'start_data.required'          => __("user.start_data"),
                    'end_data.required'            => __("user.end_data"),
                    'start_time.required'          => __("user.start_time"),
                    'end_time.required'            => __("user.end_time"),
                    'cat_id.required'              => __("user.cat_id"),
                    'type_id.required'             => __("user.type_id"),
                ]
            );

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $newauction                     = new Auction;
            $newauction->member_id          = $request['member_id'];
            $newauction->address            = $request['address'];
            $newauction->price              = $request['price'];
            $newauction->price_opining      = $request['price_opining'];
            $newauction->price_closing      = $request['price_closing'];
            $newauction->start_data         = $request['start_data'];
            $newauction->end_data           = $request['end_data'];
            $newauction->start_time         = $request['start_time'];
            $newauction->end_time           = $request['end_time'];
            $newauction->detials            = $request['detials'];
            $newauction->cat_id             = $request['cat_id'];
            $newauction->type_id            = $request['type_id'];
            $newauction->save();
            if ($request->hasFile('imagesarr')) {
                $images = $request['imagesarr'];
                if($images){
                    foreach ($images as $image) {
                        $newimg = new AuctionImage;
                        $img_name = rand(55556, 99999) . '.' . $image->getClientOriginalExtension();
                        $image->move(base_path('/public/uploads/acution/'), $img_name);
                        $newimg->img         = $img_name;
                        $newimg->auction_id  = $newauction->id;
                        $newimg->save();
                    }
                }
            }
            if ($request->paramsarr) {
                $catParams = catParameter::select('id',"param_name_ar","param_name_en")->where('cat_id',$request->cat_id)->get();
                if($catParams){
                    $p_value = $request->paramsarr;
                    for ($i=0; $i <count($catParams) ; $i++) {
                        $newdetials = new AuctionDetials;
                        $newdetials->auction_id     = $newauction->id;
                        $newdetials->param_name_ar  = $catParams[$i]['param_name_ar'];
                        $newdetials->param_name_en  = $catParams[$i]['param_name_en'];
                        $newdetials->param_value    = $p_value[$i];
                        $newdetials->save();
                    }
                }
            }

            $message = __("user.auction_success");
            return $this->returnData('Acution', $message);
        } else {
            return $this -> returnError('',__('user.usernotexist'));
        }
    }
}
