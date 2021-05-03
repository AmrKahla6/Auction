<?php

namespace App\Http\Controllers\API;

use Validator;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Member;
use App\Models\Tender;
use App\Models\Auction;
use App\Models\Country;
use App\Models\AuctionType;
use App\Models\Governorate;
use App\Models\AuctionImage;
use App\Models\catParameter;
use Illuminate\Http\Request;
use App\Models\AuctionDetials;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Tender\TenderResource;
use App\Http\Resources\Acution\sliderResource_ar;
use App\Http\Resources\Acution\sliderResource_en;
use App\Http\Resources\Acution\AcutionResource_ar;
use App\Http\Resources\Acution\AcutionResource_en;
use App\Http\Controllers\API\BaseController as BaseController;

class AuctionController extends BaseController
{

    /**
     * Search function
     */
    public function search(Request $request){
        // return Auction::find(1)->load('images');
        $res = Auction::with('images');
        if ($request->auction_title) {
            // return 1;

            $res= $res->where('auction_title','like', '%' . $request->auction_title . '%');
        }
        if ($request->city_id) {
            $res= $res->where('city_id', $request->city_id);
        }
        if ($request->cat_id) {
            $res= $res->where('cat_id', $request->cat_id);
        }
        return $res = $res->paginate(10);
        // $auctions = Auction::has('images')->when($request->auction_title, function ($q) use ($request) {
        //     return $q->where('auction_title', '%' . $request->auction_title . '%');
        // })->when($request->city_id, function ($q) use ($request) {
        //     return $q->where('city_id', $request->city_id);
        // })->when($request->category_id, function ($q) use ($request) {
        //     return $q->where('cat_id', $request->category_id);
        // })->get();

        if($request->lang == "en"){
            return $this->returnData('search',  AcutionResource_en::collection($res));
        }else{
            return $this->returnData('search',  AcutionResource_ar::collection($res));
        }
    }

    /**
     * Get Type
     */
    public function auctionType(){
        $type = AuctionType::select("id","type_name_" .app()->getLocale() . ' as acution type')->get();
        if(count($type) > 0){
            return $this->returnData('Acution Type', $type);
        }
    }

     /**
      * country
      */

      public function country(){
        $country = Country::select("id","country_name_" .app()->getLocale() . ' as country name')->get();
        if(count($country) > 0 ){
            return $this->returnData('country', $country);
        }
    }


    /**
     * Get Governorate
     */

     public function governorate(Request $request){
        $governorate = Governorate::select("id","governorate_name_" .app()->getLocale() . ' as governorate name')->where('country_id',$request->country_id)->get();
            if(count($governorate) > 0 ){
                return $this->returnData('Governorate', $governorate);
            }
     }

     /**
      * Get Cities
     */

     public function cities(Request $request){
        $cities = City::select('id','governorate_id',"city_name_" .app()->getLocale() . ' as city name')->where('governorate_id',$request->governorate_id)->get();
        if(count($cities) > 0){
            return $this->returnData('city', $cities);
        }else{
            return $this -> returnError('',__('user.no_cities'));
        }
     }


    public function storeAcution(Request $request){
        $user = Member::where('id', $request->member_id)->first();
        if ($user) {
            $validator = Validator::make(
                $request->all(),
                [
                    'auction_title'      => 'required',
                    'city_id'            => 'required',
                    'price_opining'      => 'required',
                    'price_closing'      => 'nullable',
                    'start_data'         => 'required',
                    'end_data'           => 'required',
                    'detials'            => 'required',
                    'cat_id'             => 'required',
                    'type_id'            => 'required',
                ],
                [
                    'auction_title.required'       => __("user.auction_title"),
                    'city_id.required'             => __("user.address"),
                    'price_opining.required'       => __("user.price_opining"),
                    'start_data.required'          => __("user.start_data"),
                    'end_data.required'            => __("user.end_data"),
                    'cat_id.required'              => __("user.cat_id"),
                    'type_id.required'             => __("user.type_id"),
                ]
            );

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $newauction                     = new Auction;
            $newauction->auction_title      = $request['auction_title'];
            $newauction->member_id          = $request['member_id'];
            $newauction->city_id            = $request['city_id'];
            $newauction->price              = 0;
            $newauction->price_opining      = $request['price_opining'];
            $newauction->price_closing      = $request['price_closing'];

            //Start & end date time
            $startDateTime             = $request['start_data'];
            $startdate                 = date('y/m/d/h-i-s', strtotime($startDateTime));
            $newauction->start_data    = $startdate;
            $endDateTime               = $request['end_data'];
            $enddate                   = date('y/m/d/h-i-s', strtotime($endDateTime));
            $newauction->end_data      = $enddate;

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
            // $newStartDate = Carbon::now();
            // if (Carbon::now()->isSameDay($newStartDate) > $auction->end_data) {
            //     $auction->is_finished = 1;
            //     $auction->save();
            //     $successMeg = __('user.date_ended');
            //     return $this->returnData('success', $successMeg);
            // }
            if($request->member_id == $auction->member_id){
                return $this -> returnError('',__('user.can_not_tender'));
            }
            if($request->price < $auction->price_opining){
                return $this -> returnError('',__('user.low_price'));
            }
            if($request->price >= $auction->price_closing){
                $auction->is_finished = 1;
                $auction->save();
            }
            if($auction){
                $tender = Tender::where('auction_id',$request->auction_id)->get();
                for ($i=0; $i <count($tender) ; $i++) {
                    if($tender[$i]->is_winner == 1){
                        return $this -> returnError('',__('user.endedacutions'));
                    }
                }
                $newtender = new Tender;
                $newtender->member_id   = $request['member_id'];
                $newtender->auction_id  = $request['auction_id'];
                $newtender->price       = $request['price'];
                if($request->price >= $auction->price_closing){
                    $newtender->is_winner = 1;
                }
                $newtender->save();

                if($request['price'] > $auction->price){
                    $auction->price = $request['price'];
                    $auction->save();
                }

                //Show message
                if($newtender->is_winner == 1){
                    $successMeg = __('user.winner');
                }else{
                    $successMeg = __('user.tendersucc');
                }
                return $this->returnData('success', $successMeg);
            }else{
                return $this -> returnError('',__('user.acutionnitexists'));
            }
        }else{
            return $this->sendError('success', __("user.usernotexist"));
        }
    }

    /**
     * Ended Acutions
     */

     public function endedAuction(Request $request){
         $auctions = Auction::where('is_finished',1)->get();
         if(count($auctions) > 0){
             if($request->lang == "en"){
                $auction = AcutionResource_en::collection(Auction::where('is_finished',1)->get());
             }else{
                $auction = AcutionResource_ar::collection(Auction::where('is_finished',1)->get());
             }

             return $this->returnData('success', $auction);
         }else{
            return $this->sendError('success', __("user.notendedacutions"));
         }
     }

     /**
      * Member ended Acutions
      */

     public function myEndedAuction(Request $request){
        $member = Member::where('id',$request->member_id)->first();
        if($member){
            $auctions = Auction::where('member_id',$request->member_id)->where('is_finished',1)->get();
            if(count($auctions) > 0){
                if($request->lang == "en"){
                    $auction = AcutionResource_en::collection(Auction::where('member_id',$request->member_id)->where('is_finished',1)->get());
                 }else{
                    $auction = AcutionResource_ar::collection(Auction::where('member_id',$request->member_id)->where('is_finished',1)->get());
                 }
                 return $this->returnData('success', $auction);
            }else{
                return $this->sendError('success', __("user.notendedacutions"));
            }
        }else{
            return $this->sendError('success', __("user.usernotexist"));
        }
     }

     /**
      * My wining Auctions
      */

     public function myWiningAuctions(Request $request){
        $member = Member::where('id',$request->member_id)->first();
        if($member){
            $tenders = Tender::get();
            if(count($tenders) > 0){
                $tender = TenderResource::collection(Tender::where('member_id',$request->member_id)->where('is_winner',1)->get());
                return $this->returnData('success', $tender);
            }else{
                return $this->sendError('success', __("user.notwinnercutions"));
            }
        }else{
            return $this->sendError('success', __("user.usernotexist"));
        }
     }

     /**
      * My Watting Auctions
      */

     public function myWattingAuctions(Request $request){
        $member = Member::where('id',$request->member_id)->first();
        if($member){
            $tenders = Tender::get();
            if(count($tenders) > 0){
                $tender = TenderResource::collection(Tender::where('member_id',$request->member_id)->where('is_winner',0)->get());
                return $this->returnData('success', $tender);
            }else{
                return $this->sendError('success', __("user.notwattingcutions"));
            }
        }else{
            return $this->sendError('success', __("user.usernotexist"));
        }
     }


     /**
      * Acution Slider
      */

     public function acutionSlider(Request $request){
        $auctions = Auction::where('is_finished',0)->where('is_slider',1)->get();
        if($auctions){
            if($request->lang == 'en'){
                $auctions = sliderResource_en::collection(Auction::where('is_finished',0)->where('is_slider',1)->get());
            }else{
                $auctions = sliderResource_ar::collection(Auction::where('is_finished',0)->where('is_slider',1)->get());
            }
         }
         return $this->returnData('success', $auctions);
     }
}
