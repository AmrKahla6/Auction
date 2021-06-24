<?php

namespace App\Http\Controllers\API;

use Validator;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Member;
use App\Models\Tender;
use App\Models\Auction;
use App\Models\Country;
use App\Models\Category;
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
        $res = Auction::with('images');
        if ($request->search) {
            $res= $res->where('auction_title','like', '%' . $request->search . '%');
        }
        // if ($request->city_id) {
        //     $res= $res->where('city_id', $request->city_id);
        // }
        // if ($request->cat_id) {
        //     $res= $res->where('cat_id', $request->cat_id);
        // }
        $res = $res->paginate(10);

        if($request->lang == "en"){
            return $this->returnData('search',  AcutionResource_en::collection($res));
        }else{
            return $this->returnData('search',  AcutionResource_ar::collection($res));
        }
    }

    public function filter(Request $request){

        $validator = Validator::make(
            $request->all(),
            [
                'category_id' => 'required',
            ],
            [
                'category_id.required' => __("user.cat_id"),
            ]
        );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        if($request->category_id && $request->params && $request->min_price && $request->max_price){
            $auction_details = AuctionDetials::whereHas('auctionWithImages', function ($q) use ($request){
                $q->whereBetween('price_opining', [$request->min_price, $request->max_price]) ;
            })->
            when(count($request->params) > 0 , function($q) use ($request){
                return $q->whereIn('param_value_id',array_keys($request->params));
            })->when(count($request->params) > 0 , function($q) use ($request){
                return $q->whereIn('type_id',$request->params);
            })->where('cat_id',$request->category_id)->get();

        }

        elseif($request->category_id && $request->params && $request->min_price){
            $auction_details = AuctionDetials::whereHas('auctionWithImages', function ($q) use ($request){
                $q->where('price_opining', '>=', $request->min_price) ;
            })->
            when(count($request->params) > 0 , function($q) use ($request){
                return $q->whereIn('param_value_id',array_keys($request->params));
            })->when(count($request->params) > 0 , function($q) use ($request){
                return $q->whereIn('type_id',$request->params);
            })->where('cat_id',$request->category_id)->get();

        }


        elseif($request->category_id && $request->params && $request->max_price){
            $auction_details = AuctionDetials::whereHas('auctionWithImages', function ($q) use ($request){
                $q->where('price_opining', '<=', $request->max_price) ;
            })->
            when(count($request->params) > 0 , function($q) use ($request){
                return $q->whereIn('param_value_id',array_keys($request->params));
            })->when(count($request->params) > 0 , function($q) use ($request){
                return $q->whereIn('type_id',$request->params);
            })->where('cat_id',$request->category_id)->get();

        }


        elseif($request->category_id && $request->params){
            $auction_details = AuctionDetials::with('auctionWithImages')->when(count($request->params) > 0 , function($q) use ($request){
                return $q->whereIn('param_value_id',array_keys($request->params));
            })->when(count($request->params) > 0 , function($q) use ($request){
                return $q->whereIn('type_id',$request->params);
            })
            ->whereHas('auction',function($qu)  {
                $qu->where('is_finished',0);
            })
            ->where('cat_id',$request->category_id)->get();
        }


        elseif($request->category_id && $request->min_price && $request->max_price){
            $auction_details = AuctionDetials::whereHas('auctionWithImages', function ($q) use ($request){
                $q->WhereBetween('price_opining', [$request->min_price, $request->max_price])
                ->where('cat_id',$request->category_id);
            })
            ->whereHas('auction',function($qu)  {
                $qu->where('is_finished',0);
            })->
            get();
        }

        elseif($request->category_id && $request->min_price ){
            $auction_details = AuctionDetials::whereHas('auctionWithImages', function ($q) use ($request){
                $q->where('price_opining', '>=', $request->min_price)
                ->where('cat_id',$request->category_id);
            })
            ->whereHas('auction',function($qu)  {
                $qu->where('is_finished',0);
            })->
            get();
        }

        elseif($request->category_id && $request->max_price ){
            $auction_details = AuctionDetials::whereHas('auctionWithImages', function ($q) use ($request){
                $q->where('price_opining', '<=', $request->max_price)
                ->where('cat_id',$request->category_id);
            })
            ->whereHas('auction',function($qu)  {
                $qu->where('is_finished',0);
            })->
            get();
        }

        else{
            $auction_details = AuctionDetials::with('auctionWithImages')->when($request->category_id , function ($q) use ($request){
                return $q->where('cat_id' , 'like' , '%'. $request->category_id. '%');
            })
            ->whereHas('auction',function($qu)  {
                $qu->where('is_finished',0);
            })
            ->where('cat_id',$request->category_id)->distinct('auction_id')->get();
        }

        //return $auction_details;

        $auctions = [];
        $ids      = [];
        foreach ($auction_details as $key => $auction_detail) {
            if(in_array($auction_detail->auction->id ,$ids) ) {
                continue;
            }

            array_push($ids,$auction_detail->auction->id);
            array_push(
                $auctions,
                $auction_detail = $auction_detail->auctionWithImages
            );
        }
        // $hasDuplicates = count($auctions) > count(array_unique($auctions))
        // foreach ($auction_details as $key => $auction_detail) {
        //    $auctions[$auction_detail->auction->id] = $auction_detail->auction;
        // }


        return $this->returnData('filters', $auctions);
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
        $governorate = Governorate::select("id","governorate_name_" .app()->getLocale() . ' as governorate name')->get();
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



    /**
     * Store new Acution
     */
    public function storeAcution(Request $request){

        // return $request->all();
        $user = Member::where('id', $request->member_id)->first();
        if ($user) {
            $validator = Validator::make(
                $request->all(),
                [
                    'auction_title'      => 'required',
                    'address'            => 'required',
                    'gover_id'           => 'required',
                    'city_id'            => 'required',
                    'price_opining'      => 'required',
                    'price_closing'      => 'nullable',
                    'start_data'         => 'required',
                    // 'end_data'           => 'required',
                    'detials'            => 'required',
                    'cat_id'             => 'required',
                    'type_id'            => 'required',
                    'imagesarr'          => 'required',
                ],
                [
                    'auction_title.required'       => __("user.auction_title"),
                    'address.required'             => __("user.address"),
                    'gover_id.required'            => __("user.gover_id"),
                    'city_id.required'             => __("user.city_id"),
                    'price_opining.required'       => __("user.price_opining"),
                    'start_data.required'          => __("user.start_data"),
                    // 'end_data.required'            => __("user.end_data"),
                    'cat_id.required'              => __("user.cat_id"),
                    'type_id.required'             => __("user.type_id"),
                    'imagesarr.required'           => __("user.imagesarr"),
                ]
            );

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $sub_cat  = Category::where('id',$request['cat_id'])->first();
            $main_cat = Category::where('id',$sub_cat->parent_id)->first();

            if($user->balance < $main_cat->price){
                return $this -> returnError('',__('user.balance_price'));
            }else{
                $user->balance = $user->balance - $main_cat->price;
                $user->save();
            }

            $newauction                     = new Auction;
            $newauction->auction_title      = $request['auction_title'];
            $newauction->address            = $request['address'];
            $newauction->gover_id           = $request['gover_id'];
            $newauction->city_id            = $request['city_id'];
            $newauction->member_id          = $request['member_id'];
            $newauction->price              = 0;
            $newauction->price_opining      = $request['price_opining'];
            $newauction->price_closing      = $request['price_closing'];
            $newauction->share_location     = $request['share_location'];

            //Start & end date time
            $startDateTime             = $request['start_data'];
            $startdate                 = date('y/m/d/H-i-s', strtotime($startDateTime));
            $newauction->start_data    = $startdate;
            $endDateTime               = $request['end_data'];
            $enddate                   = date('y/m/d/H-i-s', strtotime($endDateTime));
            $newauction->end_data      = date("Y-m-d H:i:s", strtotime('+24 hours', strtotime($startDateTime)));

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
                foreach ($request->paramsarr as $key => $value) {
                    //TODO:: check if key exist in cat_params
                    $cat_param = catParameter::find($key);
                    if($cat_param){
                        $newdetials = new AuctionDetials;
                        $newdetials->auction_id      = $newauction->id;
                        $newdetials->cat_id          = $request['cat_id'];
                        $newdetials->param_value_id  = $key;
                        if($cat_param->type == 1){
                            $newdetials->param_value     = $value;
                        }else{
                            $newdetials->type_id = $value;
                        }
                        $newdetials->save();
                    }else{
                        return $this -> returnError('',__('user.notexist'));
                    }
                }
                // $catParams = catParameter::select('id',"param_name_ar","param_name_en")->where('cat_id',$request->cat_id)->get();
                // if($catParams){
                //     $p_value = $request->paramsarr;
                //     for ($i=0; $i <count($catParams) ; $i++) {
                //         $newdetials = new AuctionDetials;
                //         $newdetials->auction_id     = $newauction->id;
                //         $newdetials->cat_id         = $request['cat_id'];
                //         $newdetials->param_name_ar  = $catParams[$i]['param_name_ar'];
                //         $newdetials->param_name_en  = $catParams[$i]['param_name_en'];
                //         $newdetials->param_value    = $p_value[$i];
                //         $newdetials->save();
                //     }
                // }
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
                'auction_title'      => 'required',
                'address'            => 'required',
                'gover_id'           => 'required',
                'city_id'            => 'required',
                'price_opining'      => 'required',
                'price_closing'      => 'nullable',
                'start_data'         => 'required',
                // 'end_data'           => 'required',
                'start_time'         => 'required',
                'end_time'           => 'required',
                'detials'            => 'required',
                'cat_id'             => 'required',
                'type_id'            => 'required',
            ],
            [
                'auction_title.required'       => __("user.auction_title"),
                'address.required'             => __("user.address"),
                'gover_id.required'            => __("user.gover_id"),
                'city_id.required'             => __("user.city_id"),
                'price_opining.required'       => __("user.price_opining"),
                'start_data.required'          => __("user.start_data"),
                // 'end_data.required'            => __("user.end_data"),
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
                $upAcution->auction_title = $request->auction_title;
                $upAcution->address       = $request->address;
                $upAcution->gover_id      = $request->gover_id;
                $upAcution->city_id       = $request->city_id;
                $upAcution->price         = $upAcution->price;
                $upAcution->price_opining = $request->price_opining;
                $upAcution->price_closing = $request->price_closing;
                $upAcution->start_data    = $request->start_data;
                $upAcution->end_data      = date("Y-m-d H:i:s", strtotime('+24 hours', strtotime($request->start_data)));
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
                    foreach ($request->paramsarr as $key => $value) {
                        //TODO:: check if key exist in cat_params
                        $cat_param = catParameter::find($key);
                        if($cat_param){
                            $newdetials = new AuctionDetials;
                            $newdetials->auction_id      = $newauction->id;
                            $newdetials->cat_id          = $request['cat_id'];
                            $newdetials->param_value_id  = $key;
                            if($cat_param->type == 1){
                                $newdetials->param_value     = $value;
                            }else{
                                $newdetials->type_id = $value;
                            }
                            $newdetials->save();
                        }else{
                            return $this -> returnError('',__('user.notexist'));
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
        $validator = Validator::make(
            $request->all(),
            [
                'member_id' => 'required'
            ],[
                'member_id.required' => __('user.member_id'),
            ]
        );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }


        $aucs = Auction::get();
        if($aucs){
            if($request->lang == "en"){
                $auctions = AcutionResource_en::collection(Auction::where('status',0)->paginate(8));
            }else{
                 $auctions = AcutionResource_ar::collection(Auction::where('status',0)->paginate(8));
            }
            return $this->returnData('success', $auctions);
        }
            return $this->returnError('error', __('user.no_auctions'));
        }

    public function getAcution(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'member_id' => 'required'
            ],[
                'member_id.required' => __('user.member_id'),
            ]
        );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

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
            $auction  = Auction::where('id',$request->auction_id)->first();

            // IF Balance Of Member < Balance Of main Category
            $sub_cat  = Category::where('id',$auction->cat_id)->first();
            $main_cat = Category::where('id',$sub_cat->parent_id)->first();
            if($member->balance < $main_cat->price){
                return $this->returnError('error', __("user.balance_price"));
            }else{
                $member->balance = $member->balance - $main_cat->price;
                $member->save();
            }


            //if auction price > member request price or member input price < auction price opining
            if($auction->price > $request->price or $request->price < $auction->price_opining){
                return $this -> returnError('',__('user.low_price'));
            }

            //IF member repate price to the same auction
            $oldTenders = Tender::where('is_winner',0)->where('auction_id',$request->auction_id)->get();
            foreach($oldTenders as $old){
                if($old->member_id == $member->id && $old->price == $request->price){
                    return $this -> returnError('',__('live.price_exist'));
                }
            }

            //Store New Bide
            $tender  = new Tender;

            //If Win Bide
            if($request->price >= $auction->price_closing){
                $tender->is_winner    = 1;
                $auction->is_finished = 1;

                //return price to member bide
                $old_tender = Tender::with('member')->select('id','member_id')->where('auction_id',$auction->id)->get()->unique('member_id');
                foreach($old_tender as $old_t){
                    $balance = $old_t->member->balance + $main_cat->price;
                    $old_t->member->update(array("balance" => $balance));
                }
                // Return price to auction owner
                $auctiom_owner = Member::where('id',$auction->member_id)->first();
                $auctiom_owner->balance = $auctiom_owner->balance + $main_cat->price;
                $auctiom_owner->save();
            }else{
                $tender->is_winner    = 0;
                $exists = Tender::where('auction_id',$auction->id)->exists();
                if(!$exists){
                    $member->balance      = $member->balance - $main_cat->price;
                    $member->save();
                }
            }

            //If Price Of Bide > Price Auction store it in Price Auction this is the hight price of auction
            if($request->price > $auction->price){
                $auction->price = $request->price;
            }

            $tender->price      = $request->price;
            $tender->member_id  = $member->id;
            $tender->auction_id = $auction->id;

            $auction->save();
            $tender->save();


            //Show message
            if($tender->is_winner == 1){
                $successMeg = __('user.winner');
            }else{
                $successMeg = __('user.tendersucc');
            }
            return $this->returnData('success', $successMeg);

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
                $auction = AcutionResource_en::collection(Auction::where('is_finished',1)->paginate(8));
             }else{
                $auction = AcutionResource_ar::collection(Auction::where('is_finished',1)->paginate(8));
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
                    $auction = AcutionResource_en::collection(Auction::where('member_id',$request->member_id)->where('is_finished',1)->paginate(8));
                 }else{
                    $auction = AcutionResource_ar::collection(Auction::where('member_id',$request->member_id)->where('is_finished',1)->paginate(8));
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
                $tender = TenderResource::collection(Tender::where('member_id',$request->member_id)->where('is_winner',1)->paginate(8));
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
                $tender = TenderResource::collection(Tender::where('member_id',$request->member_id)->where('is_winner',0)->paginate(8));
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

     /**
      * Latest Acutions
      */

      public function latestAcutions(Request $request){
        if($request->lang == 'en'){
            $auctions = AcutionResource_en::collection(Auction::where('is_finished',0)->orderBy('created_at', 'DESC')->take(3)->get());
        }else{
            $auctions = AcutionResource_ar::collection(Auction::where('is_finished',0)->orderBy('created_at', 'DESC')->take(3)->get());
        }

        return $this->returnData('success', $auctions);
      }

        /**
      * Latest Tenders
      */

      public function latestTenders(){
        $tenders = TenderResource::collection(Tender::orderBy('created_at', 'DESC')->take(3)->get());
        return $this->returnData('success', $tenders);
      }

      /**
       * Get Add Acution From Request Category_id
       */

       public function acutionCategory(Request $request){
        $auctions = Auction::where('cat_id',$request->cat_id)->where('is_finished',0)->get();
        if($request->lang == 'en'){
            $auctions = AcutionResource_en::collection(Auction::where('cat_id',$request->cat_id)->where('is_finished',0)->paginate(8));
        }else{
            $auctions = AcutionResource_ar::collection(Auction::where('cat_id',$request->cat_id)->where('is_finished',0)->paginate(8));
        }
        return $this->returnData('success', $auctions);
       }

       /**
        * Latest Tenders in acution
        */

        public function latestTendersAcution(Request $request){
            $tenders = Tender::where('auction_id',$request->auction_id)->get();
            if($tenders){
                $tender = TenderResource::collection(Tender::where('auction_id',$request->auction_id)->orderBy('created_at', 'DESC')->take(3)->get());
                return $this->returnData('success', $tender);
            }

        }
}
