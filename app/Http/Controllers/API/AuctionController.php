<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Member;
use App\Models\Tender;
use App\Models\Auction;
use App\Models\AuctionType;
use App\Models\AuctionImage;
use App\Models\catParameter;
use Illuminate\Http\Request;
use App\Models\AuctionDetials;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Acution\AcutionResource_ar;
use App\Http\Resources\Acution\AcutionResource_en;
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
            $newauction->price              = 0;
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
                        $newdetials->cat_id         = $request['cat_id'];
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

    /**
     * Update Acution
     */

     public function updateAcution(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'address'            => 'required',
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

        $user = Member::where('id', $request->member_id)->first();
        if($user){
            $upAcution = Auction::where('id', $request->auction_id)->where('member_id',$request->member_id)->first();

            if($upAcution){
                $upAcution->address       = $request->address;
                $upAcution->price         = $upAcution->price;
                $upAcution->price_opining = $request->price_opining;
                $upAcution->price_closing = $request->price_closing;
                $upAcution->start_data    = $request->start_data;
                $upAcution->end_data      = $request->end_data;
                $upAcution->start_time    = $request->start_time;
                $upAcution->end_time      = $request->end_time;
                $upAcution->detials       = $request->detials;
                $upAcution->cat_id        = $request->cat_id;
                $upAcution->type_id       = $request->type_id;
                $upAcution->save();
                //Update Images
                if ($request->hasFile('imagesarr')) {
                    $images = $request['imagesarr'];
                    if($images){
                        foreach ($images as $image) {
                            $newimg = new AuctionImage;
                            $img_name = rand(0, 999) . '.' . $image->getClientOriginalExtension();
                            $image->move(base_path('/public/uploads/acution/'), $img_name);
                            $newimg->img        = $img_name;
                            $newimg->auction_id = $upAcution->id;
                            $newimg->save();
                        }
                    }
                }
                if ($request->paramsarr) {
                    $catParams = catParameter::select('id',"param_name_ar","param_name_en")->where('cat_id',$request->cat_id)->get();
                    if($catParams){
                        $p_value = $request->paramsarr;
                        $updetials = AuctionDetials::where('auction_id',$request->auction_id)->get();
                        for ($i=0; $i <count($catParams) ; $i++) {
                            $updetials[$i]->param_name_ar  = $catParams[$i]['param_name_ar'];
                            $updetials[$i]->param_name_en  = $catParams[$i]['param_name_en'];
                            $updetials[$i]->param_value    = $p_value[$i];
                            $updetials[$i]->save();
                        }
                    }
                }

                return $this->returnData('success', __("user.upAcution"));
            }else{
                return $this -> returnError('',__('user.acutionnitexists'));
            }
        }else{
            return $this -> returnError('',__('user.usernotexist'));
        }
     }

    /**
    * Cancle Auction
    */

    public function cancleAuction(Request $request){
        $member = Member::where('id',$request->member_id)->first();
        if($member){
            $auction = Auction::where("id", $request->auction_id)->first();
            if($auction){
                if($auction->status == 1){
                    return $this -> returnError('error',__("user.auction_ar_cancle"));
               }
               $auction->status = 1;
               $auction->save();
               return $this->returnData('success', __("user.insur_cancle"));
            }else{
                return $this -> returnError('error',__("user.acutionnitexists"));
            }
        }else{
            return $this->sendError('success', __("user.usernotexist"));
        }
    }

    /**
     * Delete Auction image
     */

    public function delimage(Request $request)
    {
        $image = AuctionImage::where('id', $request->image_id)->first();
        $img   = AuctionImage::find($image->id)->img;
        if($image){
            Storage::disk('uploads')->delete('acution/' . $img);
            $image->delete();
            return $this->returnData('success', __('user.delimage'));
        }else{
            return $this->returnError('error', __('user.imagenotexsist'));
        }
    }


    public function getAll(Request $request){
        $aucs = Auction::where('status',0)->get();

        if($aucs){
            if($request->lang == "en"){
                $auctions = AcutionResource_en::collection(Auction::where('status',0)->get());
            }else{
                $auctions = AcutionResource_ar::collection(Auction::where('status',0)->get());
            }
            return $this->returnData('success', $auctions);
        }
            return $this->returnError('error', __('user.no_auctions'));
        }

    public function getAcution(Request $request){
        $auc = Auction::where('id', $request->auction_id)->where('status',0)->first();
        if($auc){
            if($request->lang == "en"){
                $auction = new AcutionResource_en(Auction::where('id', $request->auction_id)->first());
            }else{
                $auction = new AcutionResource_ar(Auction::where('id', $request->auction_id)->first());
            }
            return $this->returnData('success', $auction);
        }else{
            return $this->returnError('error', __('user.no_auctions'));
        }
    }


    /**
     * tender function
    */

    public function tender(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'price' => 'required',
            ],
            [
                'address.required' => __("user.price"),
            ]
        );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $member = Member::where('id',$request->member_id)->first();
        if($member){
            $auction = Auction::where('id',$request->auction_id)->first();
            if($request->member_id == $auction->member_id){
                return $this -> returnError('',__('user.can_not_tender'));
            }
            if($request->price < $auction->price_opining){
                return $this -> returnError('',__('user.low_price'));
            }
            if($auction){
                $newtender = new Tender;
                $newtender->member_id   = $request['member_id'];
                $newtender->auction_id  = $request['auction_id'];
                $newtender->price       = $request['price'];
                $newtender->save();

                if($request['price'] > $auction->price){
                    $auction->price = $request['price'];
                    $auction->save();
                }
                $successMeg = __('user.tendersucc');
                return $this->returnData('success', $successMeg);
            }else{
                return $this -> returnError('',__('user.acutionnitexists'));
            }
        }else{
            return $this->sendError('success', __("user.usernotexist"));
        }
    }

}
