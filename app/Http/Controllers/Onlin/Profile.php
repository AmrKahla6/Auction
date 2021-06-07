<?php

namespace App\Http\Controllers\Onlin;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Auction;
use App\Models\AuctionDetials;
use App\Models\AuctionImage;
use App\Models\AuctionType;
use App\Models\Category;
use App\Models\Governorate;
use App\Models\Member;
use App\Models\selectParams;
use App\Models\Tender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use LaravelLocalization;
use Str;

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
            $data['categories'] = Category::select('id', 'category_name_' . LaravelLocalization::getCurrentLocale() . ' as name', )->where('parent_id', 0)
                ->with(['subcategory'])
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
        return response()->json($output);
        // dd($cities);

    }

    public function get_params($cat_id)
    {
        $cat = Category::find($cat_id);
        $params = $cat->params()->select('id', 'type', 'param_name_ar', 'param_name_en')
            ->with(['selected'])->get();
        //  dd($params);
        $total_row = $params->count();
        $output = '';
        if ($total_row > 0) {
            foreach ($params as $index => $pram) {
                if ($pram->type == 1) {
                    $output .= '<div class="form-group">
            <input  value="' . $pram->id . '"  class="hide" type="number" name="auction_detials[' . $index . '][param_value_id]">
            <input value="" class="form-control" type="text" name="auction_detials[' . $index . '][param_value]" placeholder="' . $pram->param_name_ar . '"></div>';
                } elseif ($pram->type == 2) {
                    //get select values
                    $selected_rows = $pram->selected()->get();
                    if ($selected_rows->count() > 0) {
                        $output .= '<div class="form-group">
        <input  value=""  class="hide" type="number" name="auction_detials[' . $index . '][param_value]">
        <select  name="auction_detials[' . $index . '][param_value_id]"  class="form-control">
        <option disabled="disabled">' . $pram->param_name_ar . '</option>';
                        foreach ($selected_rows as $single) {
                            $output .= '<option value="' . $single->id . '">' . $single->param_name_ar . '</option>';
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
       // dd($request['auction_detials']);
        if ($request->session()->exists('member')) {
            $data = $request->validate([
                'auction_title'  => ['required', 'string', 'max:255'],
                'price'          => ['required'],
                'address'        => ['required'],
                'price_opining'  => ['required'],
                'price_closing'  => ['required'],
                //   'start_data' => ['required'],
                'end_data'       => ['required'],
                'detials'        => ['required'],
                'cat_id'         => ['required'],
                'type_id'        => ['required'],
                'gover_id'       => ['required'],
                'city_id'        => ['required'],
                'status'         => [],
                'is_slider'      => [],
                'is_finished'    => [],
                'share_location' => [],

            ],
                [
                    'auction_title.required' => __("auctions.auction_title"),
                    'price.required'         => __("auctions.price"),
                    'address.required'       => __("auctions.address"),
                    'price_opining.required' => __("auctions.price_opining"),
                    'price_closing.required' => __("auctions.price_closing"),
                    'end_data.required'      => __("auctions.end_data"),
                    'detials.required'       => __("auctions.detials"),
                    'cat_id.required'        => __("auctions.cat_id"),
                    'type_id.required'       => __("auctions.type_id"),
                    'gover_id.required'      => __("auctions.gover_id"),
                    'city_id.required'       => __("auctions.city_id"),
                ]
            );
            $data['member_id'] = $request->session()->get('member')->id;
            if ($request->type_id == 1) {
                $data['start_data'] = Carbon::now();
            }
            $object = Auction::create($data);
            //image parts
            if ($request->hasfile('auction_images')) {
                $images = $request->file('auction_images');
                foreach ($images as $image) {
                    $newimg = new AuctionImage;
                    $img_name = rand(55556, 99999) . '.' . $image->getClientOriginalExtension();
                    $image->move(base_path('/public/uploads/acution/'), $img_name);
                    $newimg->img         = $img_name;
                    $newimg->auction_id  = $object->id;
                    $newimg->save();
            }
        }
            //auction_detials part
            if (!empty($request['auction_detials'])) {
                foreach ($request['auction_detials'] as $auction_detials) {
                    if ($auction_detials['param_value'] != null) {
                        $auction_detials['type_id'] = 1;
                        $auction_detials['cat_id'] = $object->cat_id;
                        $auction_detials['auction_id'] = $object->id;
                        AuctionDetials::create($auction_detials);
                    } elseif ($auction_detials['param_value'] === null) {
                        $pram = selectParams::find($auction_detials['param_value_id']);
                        $param_name = "";
                        if (LaravelLocalization::getCurrentLocale() == "ar") {
                            $param_name = $pram->param_name_ar;
                        } else {
                            $param_name = $pram->param_name_en;
                        }

                        $auction_detials['type_id'] = 2;
                        $auction_detials['param_value'] = $param_name;
                        $auction_detials['cat_id'] = $object->cat_id;
                        $auction_detials['auction_id'] = $object->id;
                        $auction_detials['param_value_id'] = $pram->id;
                        AuctionDetials::create($auction_detials);
                    }
                }
            }
            session()->flash('success', __('auctions.auction_success'));
            return redirect()->back();

        } else {
            return redirect('live/login');
        }
    }

    public function single_auction($id)
    {
        $data['auction'] = Auction::where('id', $id)->with(['more_detials', 'more_detials.cat_parm', 'tenders', 'images'])->first();
        //dd( $data['auction'] );
        return view('online.profile.single_auction')->with($data);

    }

    public function add_tender(Request $request)
    {
        //dd($request->all() );
        $member = Member::find(auth()->guard('members')->id());
        if (!empty($member->id)) {
            //update price in aucation and add tender
            $auction = Auction::find($request->aucation_id);
            $expcted = ($auction->price) + ($request->price);
            //dd($expcted,'price');
            if (($expcted) >= ($auction->price_closing)) {
                //close auction
                $auction->update(['is_finished' => true,
                    'price' => $expcted]);
                //create Tender
                $t = Tender::create(['member_id' => $member->id,
                    'auction_id' => $auction->id,
                    'price' => $request->price,
                    'is_winner' => true]);
                return response()->json([
                    'msg' => "success",
                    'price' => $request->price,
                    'id' => $t->id,

                ]);
            } else {
                //update price only
                $auction->update(['price' =>
                    $expcted]);
                $t = Tender::create(['member_id' => $member->id,
                    'auction_id' => $auction->id,
                    'price' => $request->price,
                    'is_winner' => true]);
                return response()->json([
                    'msg' => "success",
                    'price' => $request->price,
                    'id' => $t->id,

                ]);
            }

        } else {
            return response()->json([
                'msg' => "error",

            ]);
        }
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
                return $path.'/'.$file_name;

    }

}
