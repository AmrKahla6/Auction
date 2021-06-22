<?php

namespace App\Http\Controllers\Onlin;


use Str;
use Auth;
use Carbon\Carbon;
use App\Models\DaysOF;
use App\Models\Member;
use App\Models\Tender;
use App\Models\Auction;
use App\Models\Country;
use App\Models\Category;
use App\Models\Favorite;
use LaravelLocalization;
use App\Models\AuctionType;
use App\Models\Governorate;
use App\Models\StaticDayOF;
use App\Models\AuctionImage;
use App\Models\catParameter;
use App\Models\selectParams;
use Illuminate\Http\Request;
use App\Models\AuctionDetials;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;

class Profile extends BaseController
{
    // my profile
    public function profile()
    {
        $data['member'] = Member::find(auth()->guard('members')->id());
        if (!empty($data['member'])) {
            // dd($data['member']);
            return view('online.profile.myprofile')->with($data);
        } else {
            return redirect('live/login');
        }
    }
// my auctions
    public function myauctions(Request $request)
    {
        $data['member'] = Member::find(auth()->guard('members')->id());
        if (!empty($data['member'])) {
            return view('online.profile.myauctions');
        } else {
            return redirect('live/login');
        }
    }

    public function my_tenders()
    {
        $member = Member::find(auth()->guard('members')->id());
        if (!empty($member)) {
            $data['active_tenders'] = $member->tenders()->where('is_winner', 1)->get();
            $data['dis_tenders'] = $member->tenders()->where('is_winner', 0)->get();
            $data['member'] =$member;
            return view('online.profile.my_tenders')->with($data);
        } else {
            return redirect('live/login');
        }
    }

    public function add_auctions(Request $request)
    {
        if ($request->session()->exists('member')) {
            $data['categories'] = Category::select('id', 'category_name_' . LaravelLocalization::getCurrentLocale() . ' as name', )->where('parent_id', '!=' ,0)
                                    ->get();
            $data['types'] = AuctionType::select('id', 'type_name_' . LaravelLocalization::getCurrentLocale() . ' as name')->get();
            $data['governorate'] = Governorate::select('id', 'governorate_name_' . LaravelLocalization::getCurrentLocale() . ' as name')->get();

            return view('online.profile.addauctions')->with($data);
        } else {
            return redirect('live/login');
        }
    }

    public function get_cites($gover_id)
    {
        $gover = Governorate::find($gover_id);
        $cities = $gover->cities()->select('id', 'city_name_' . LaravelLocalization::getCurrentLocale() . ' as name')->get();
        $total_row = $cities->count();

        if ($total_row > 0) {
            $output = '<option disabled="disabled" value="-"> اختر المدينة</option>';
            foreach ($cities as $index => $row) {
         $output .= '
        <option value="' . $row->id . '">' . $row->name . '</option>';
            }
        } else {
            $output = '<option value="-" selected disabled> لم تسجل أي مدينة </option>';
        }
        return response($output);
        // dd($cities);

    }

    public function get_params($cat_id)
    {
        $cat = Category::find($cat_id);
        $params = $cat->params()->select('id', 'type', 'param_name_ar', 'param_name_en' )
            ->with(['selected'])->get();
         //dd($params);
        $total_row = $params->count();
        $output = '';

        if ($total_row > 0) {
            foreach ($params as $index => $pram) {
                if(LaravelLocalization::getCurrentLocale()=="ar"){
                    $param_value = $pram->param_name_ar;
                }else{

                    $param_value = $pram->param_name_en;

                    $param_value = $pram->param_name_en;

                }
                if ($pram->type == 1) {
                    $output .= '<div class="form-group">
            <input  value="' . $pram->id . '"  class="hide" type="number" name="auction_detials[' . $index . '][param_value_id]">
            <input  value="' . null . '"  class="hide" type="number" name="auction_detials[' . $index . '][type_id]">
            <input value="" class="form-control" type="text" name="auction_detials[' . $index . '][param_value]" placeholder="' . $param_value . '"></div>';
                } elseif ($pram->type == 2) {
                    //get select values
                    $selected_rows = $pram->selected()->get();
                    if ($selected_rows->count() > 0) {
                        $output .= '<div class="form-group">
        <input  value="'.$pram->id.'"   class="hide" type="number" name="auction_detials[' . $index . '][param_value_id]">
        <input value="' . $param_value . '" class="hide" type="text" name="auction_detials[' . $index . '][param_value]">
        <select  name="auction_detials[' . $index . '][type_id]"  class="form-control">
        <option disabled="disabled">' . $param_value . '</option>';
                        foreach ($selected_rows as $single) {
                            if(LaravelLocalization::getCurrentLocale()=="ar"){
                                $p_param_value = $single->param_name_ar;
                            }else{
             $p_param_value = $single->param_name_en;

                                $p_param_value = $single->param_name_en;

                            }
                            $output .= '<option value="' . $single->id . '">' . $p_param_value . '</option>';
                        }
                        $output .= '</select></div>';
                    }

                }
            }

        }
        return response($output);
    }

    public function post_auctions(Request $request)
    {
        //dd($request['auction_detials']);
        if ($request->session()->exists('member')) {
            $data = $request->validate([
                'auction_title' => ['required', 'string', 'max:255'],
                'address' => ['required'],
                'price_opining' => ['required'],
                'price_closing' => ['required'],
                //   'start_data' => ['required'],
                // 'end_data' => ['required'],
                'detials' => ['required'],
                'cat_id' => ['required'],
                'type_id' => ['required'],
                'gover_id' => ['required'],
                'city_id' => ['required'],
                'status' => [],
                'is_slider' => [],
                'desc_ar' => [],
                'desc_en' => [],
                'is_finished' => [],
                'share_location' => [],

            ],
                [
                    'auction_title.required' => __("auctions.auction_title"),
                    'address.required' => __("auctions.address"),
                    'price_opining.required' => __("auctions.price_opining"),
                    'price_closing.required' => __("auctions.price_closing"),
                    // 'end_data.required' => __("auctions.end_data"),
                    'detials.required' => __("auctions.detials"),

                    'cat_id.required' => __("auctions.cat_id"),
                    'type_id.required' => __("auctions.type_id"),
                    'gover_id.required' => __("auctions.gover_id"),
                    'city_id.required' => __("auctions.city_id"),
                ]
            );
            $data['member_id'] = $request->session()->get('member')->id;
            $sub_cat  = Category::where('id',$data['cat_id'])->first();
            $main_cat = Category::where('id',$sub_cat->parent_id)->first();
            $member   = Member::where('id',$request->session()->exists('member'))->first();

            if($member->balance < $main_cat->price){
                session()->flash('error', __('user.balance_price'));
                return redirect()->back();
            }else{
                $member->balance = $member->balance - $main_cat->price;
                $member->save();
            }


            if($member)
            $data['price']     = 0;
            if ($request->type_id == 1) {
                $data['start_data'] = Carbon::now();
            }else {
                $data['start_data'] = $request->start_data;
            }

            $data['end_data']  = date("Y-m-d H:i:s", strtotime('+24 hours', strtotime($data['start_data'])));
            $object = Auction::create($data);
            //image parts
            if ($request->hasfile('auction_images')) {
                $images = $request->file('auction_images');
                foreach ($images as $image) {
                   $image_name=$this->save_img($image,'uploads/acution');
                    AuctionImage::create([
                        'img' => $image_name,
                        'auction_id' => $object->id,
                    ]);
                }
            }


            //auction_detials part
            if ($request['auction_detials']!=null) {
              //   dd($request['auction_detials']);
                foreach ($request['auction_detials'] as $auction_detials) {
                    if ($auction_detials['type_id'] === null) {
                        $auction_detials['auction_id'] = $object->id;
                        $auction_detials['cat_id'] = $object->cat_id;
                    } elseif ($auction_detials['type_id'] != null) {
                        $auction_detials['auction_id'] = $object->id;
                        $auction_detials['cat_id'] = $object->cat_id;
                        //   dd($auction_detials);
                    }
                }

            //auction_detials part
            if ($request['auction_detials']!=null) {
              //   dd($request['auction_detials']);
                foreach ($request['auction_detials'] as $key => $auction_detials) {

                    if ($auction_detials['type_id'] === null) {
                        $auction_detials['auction_id'] = $object->id;
                        $auction_detials['cat_id'] = $object->cat_id;
                        AuctionDetials::create($auction_detials);
                    } elseif ($auction_detials['type_id'] != null) {
                        $auction_detials['auction_id']  = $object->id;
                        $auction_detials['cat_id']      = $object->cat_id;
                        $auction_detials['param_value'] = null;
                        AuctionDetials::create($auction_detials);
                     //   dd($auction_detials);

                    }
                }

            }
            session()->flash('success', __('auctions.auction_success'));
            return redirect('live/registerd');

        } else {
            return redirect('live/login');
        }
    }
}

    public function single_auction($id)
    {
        $data['auction']      = Auction::with('category')->where('id', $id)->with(['more_detials', 'more_detials.cat_parm', 'tenders', 'images'])->first();
        $data['main_cats']    = Category::select('id','price')->where('id',$data['auction']->category->parent_id)->first();
        $data['date']         = date('Y-m-d');
        $data['exist']        = DaysOF::where('days_of', $data['date'])->exists();
        $today                = Carbon::now();
        $today_name           = Carbon::parse($today)->format('l');
        $data['static_days']  = StaticDayOF::where('day', $today_name)->exists();

        return view('online.profile.single_auction')->with($data);

    }

    public function add_tender(Request $request,$aucation_id)
    {
        $validatedData = $request->validate([
            'price' => 'required',
        ],[
            'price.required'  => __("user.price"),
        ]);

        $auction = Auction::find($aucation_id);
        $member  = Member::find(auth()->guard('members')->id());

        // IF Balance Of Member < Balance Of main Category
        $sub_cat  = Category::where('id',$auction->cat_id)->first();
        $main_cat = Category::where('id',$sub_cat->parent_id)->first();
        if($member->balance < $main_cat->price){
            session()->flash('error', __('user.balance_price'));
            return redirect()->back();
        }

        //if auction price > member input price or member input price < auction price opining
        if($auction->price > $request->price or $request->price < $auction->price_opining){
            session()->flash('error', __("live.incorr_price"));
            return redirect()->back();
        }

        //IF member repate price to the same auction
        $oldTenders = Tender::where('is_winner',0)->where('auction_id',$auction->id)->get();
        foreach($oldTenders as $old){
            if($old->member_id == $member->id && $old->price == $request->price){
                session()->flash('error', __("live.price_exist"));
                return redirect()->back();
            }
        }

        $tender  = new Tender;

        //If Win Bide
        if($request->price >= $auction->price_closing){
            $tender->is_winner    = 1;
            $auction->is_finished = 1;

            //return price to member bide
            $old_tender = Tender::with('member')->select('id','member_id')->where('auction_id',$aucation_id)->get()->unique('member_id');
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
            $exists = Tender::where('auction_id',$aucation_id)->exists();
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

        if($tender->is_winner == 0){
            session()->flash('success', __('live.succes_auct'));
        }else{
            session()->flash('success', __('live.winner_auct'));
        }
        return redirect()->back();
    }


    public function save_img($filles,$path){
        $type = array(
            "jpg"=>"image",
            "jpeg"=>"image",
            "png"=>"image",
            "svg"=>"image",
            "webp"=>"image",
            "gif"=>"image",
            "mp4"=>"video",
            "mpg"=>"video",
            "mpeg"=>"video",
            "webm"=>"video",
            "ogg"=>"video",
            "avi"=>"video",
            "mov"=>"video",
            "flv"=>"video",
            "swf"=>"video",
            "mkv"=>"video",
            "wmv"=>"video",
            "wma"=>"audio",
            "aac"=>"audio",
            "wav"=>"audio",
            "mp3"=>"audio",
            "zip"=>"archive",
            "rar"=>"archive",
            "7z"=>"archive",
            "doc"=>"document",
            "txt"=>"document",
            "docx"=>"document",
            "pdf"=>"document",
            "csv"=>"document",
            "xml"=>"document",
            "ods"=>"document",
            "xlr"=>"document",
            "xls"=>"document",
            "xlsx"=>"document"
        );

        $file_name= time() . Str::random(10) . '.' . $filles->getClientOriginalExtension();

            $filles->move(public_path($path), $file_name);
                return $file_name;

    }

    public function add_favorite(Request $request){

        $member = Member::find(auth()->guard('members')->id());
        $auction = Auction::find($request->auction_id);
        $old_fav = Favorite::where('member_id',$member->id)->where('auction_id',$auction->id)->first();
        if($old_fav){
            $old_fav->delete();
            return response()->json([
                'favorite' => $old_fav,
                'status'   => true,
                'msg'      => __('live.delete_favo'),
            ]);
        }else{
            $favorite = new Favorite;
            $favorite->member_id  = $member->id;
            $favorite->auction_id = $auction->id;
            $favorite->is_like    = 1;
            $favorite->save();
            return response()->json([
                'favorite' => $favorite,
                'status'   => true,
                'msg'      => __('live.add_fav'),
            ]);
        }
    }

    public function Myfavorite($id){
        $member   = Member::find($id);
        $my_fav   = Favorite::with('auction')->where('member_id',$member->id)->orderBy('id','DESC')->get();
        return view('online.favorite',compact('my_fav'));
    }


    /**
     * ====================================================================================================================
     * ========================================= Edit Profile =============================================================
     * ====================================================================================================================
     */

     public function editProfile(){
        $member    = Auth::guard('members')->user();
        $countries = Country::select("id","country_name_" .app()->getLocale() . ' as country_name')->get();

        return view('online.profile.editProfile',compact('member','countries'));
     }

     public function editNormal(Request $request){
        $member    = Auth::guard('members')->user();
        $data = $request->validate([
            'username'            => 'required',
            'date_of_birth'       => 'required|date|before:-18 years',
            'country_id'          => 'required',
            'email'               => 'required|max:255|unique:members,email,'.$member->id,
        ],
        [
            'username.required'            => __("user.username"),
            'date_of_birth.required'       => __("user.date_of_birth"),
            'date_of_birth.before'         => __("user.before"),
            'country_id.required'          => __("user.nationality"),
            'email.required'               => __("user.email"),
            'email.unique'                 => __("user.unique_email"),
        ]
        );

        if ($request->img) {
            Image::make($request->img)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/members/' . $request->img->hashName()));

            $data['img'] = $request->img->hashName();

        }//end of if
        $member->update($data);
        session()->flash('success', __('user.infoupdate'));
        return redirect()->back();
     }



     public function editCommercial(Request $request){
        $member    = Auth::guard('members')->user();
        $data = $request->validate([
                'commercial_record'   => 'required|unique:members,commercial_record,'.$member->id,
                'date_of_birth'       => 'required|date|before:-18 years',
                'id_number'           => 'required|min:12|unique:members,id_number,'.$member->id,
                'email'               => 'required|max:255|unique:members,email,'.$member->id,
            ],
            [
                'commercial_record.required'   => __("user.commercial_record"),
                'commercial_record.unique'     => __("user.commercial_exist"),
                'date_of_birth.required'       => __("user.date_of_birth"),
                'date_of_birth.before'         => __("user.before"),
                'id_number.required'           => __("user.id_number"),
                'id_number.unique'             => __("user.unique_id_number"),
                'email.required'               => __("user.email"),
                'email.unique'                 => __("user.unique_email"),
            ]
        );

        if ($request->img) {
            Image::make($request->img)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/members/' . $request->img->hashName()));

            $data['img'] = $request->img->hashName();

        }//end of if
        $member->update($data);
        session()->flash('success', __('user.infoupdate'));
        return redirect()->back();
     }

     public function changePass(){
         return view('online.auth.change-pass');
     }

     public function savePass(Request $request){
         $member    = Auth::guard('members')->user();

         $data = $request->validate([
             'password'              => 'required|min:6',
             'new_password'          => 'required|min:6',
             'password_confirmation' => 'required|same:new_password|min:6'
            ],
            [
                'password.required'      => __("user.password"),
                'new_password.required'  => __("live.new_password"),
                'new_password.confirmed' => __("live.confirmed"),
                ]
            );

        if (Hash::check($request->password, $member->password)) {
                $member->password = Hash::make($request->new_password);
                $member->save();
                session()->flash('success', __('user.infoupdate'));
                return redirect()->back();
        }

     }



    public function updateBalance(Request $request){
         $id = Auth::guard('members')->user()->id;

        $this->validate($request, [
            'balance' => 'required|numeric',
        ],[
            'balance.required' => __('live.balance'),
        ]);

        $balance = Member::find($id);

        $balance->balance = $request->balance;
        $balance->save();

        session()->flash('success', __('user.infoupdate'));
        return redirect()->back();

    }

}
