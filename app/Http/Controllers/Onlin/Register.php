<?php

namespace App\Http\Controllers\Onlin;
use Validator;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\Auction;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Register extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:members');
    }

    public function register()
    {
        $data['countries'] = Country::select("id","country_name_" .app()->getLocale() . ' as country_name')->get();
        return view('online.auth.register')->with($data);
    }

    public function register_post(Request $request)
    {
        $data = $request->validate([
            'username'            => 'required',
            'phone'               => 'required|unique:members',
            'date_of_birth'       => 'required|date|before:-18 years',
            'country_id'          => 'required',
            'email'               => 'required|email|unique:members',
            'password'            => 'required|min:6',
        ],
        [
            'username.required'            => __("user.username"),
            'phone.required'               => __("user.phone"),
            'phone.unique'                 => __("user.unique_phone"),
            'date_of_birth.required'       => __("user.date_of_birth"),
            'date_of_birth.before'         => __("user.before"),
            'country_id.required'          => __("user.nationality"),
            'email.required'               => __("user.email"),
            'email.unique'                 => __("user.unique_email"),
            'password.required'            => __("user.password"),
            'password.min'                 => __("user.max_password"),
        ]
    );
         $data['password'] = bcrypt($request->password);
         $data['type']     = 1;
         $member = Member::create($data);
         session()->flash('success', __('site.added_successfully'));
        return redirect()->route('live.login');
    }



    public function commercialRegister(Request $request)
    {
        $data = $request->validate([
            'commercial_record'   => 'required|unique:members',
            'phone'               => 'required|unique:members',
            'date_of_birth'       => 'required|date|before:-18 years',
            'id_number'           => 'required|min:12|unique:members',
            'email'               => 'required|email|unique:members',
            'password'            => 'required|min:6',
        ],
        [
            'commercial_record.required'   => __("user.commercial_record"),
            'commercial_record.unique'     => __("user.commercial_exist"),
            'phone.required'               => __("user.phone"),
            'phone.unique'                 => __("user.unique_phone"),
            'date_of_birth.required'       => __("user.date_of_birth"),
            'date_of_birth.before'         => __("user.before"),
            'id_number.required'           => __("user.id_number"),
            'id_number.unique'             => __("user.unique_id_number"),
            'email.required'               => __("user.email"),
            'email.unique'                 => __("user.unique_email"),
            'password.required'            => __("user.password"),
            'password.min'                 => __("user.max_password"),
        ]
    );
         $data['password'] = bcrypt($request->password);
         $data['type']     = 0;
        //  return $data;
         $member = Member::create($data);
         session()->flash('success', __('site.added_successfully'));
        return redirect()->route('live.login');
    }




    public function login()
    {
    if(empty($member = Member::find(auth()->guard('members')->id()))){
        return view('online.auth.login');
    }else{
        $data['auctions_active']  = Auction::where('member_id',$member->id)->where('is_finished',false)->with('images')->get();
        $data['auctions_dis']     = Auction::where('member_id',$member->id)->where('is_finished',true)->with('images')->get();
        // return redirect('live/registerd');
         return redirect()->route('live.registerd');

    }
    }

    public function login_post(Request $request)
    {
        $data = $request->validate([
            'phone'    => ['required'],
            'password' => ['required'],

         ]);
        // $remember_token = $request->get('remember_token')==1?true:false;
         if(auth()->guard('members')->attempt([
             'phone'=> $request->phone,'password'=>$request->password])){
            $member = Member::find(auth()->guard('members')->id());
            $request->session()->put('member', $member);
            $data['auctions_active']  = Auction::where('member_id',$member->id)->with('images')->get();
            $data['auctions_dis']  = Auction::where('member_id',$member->id)->where('end_data','>',Carbon::now())->with('images')->get();
          //dd($data['auctions_active']);
               return view('online.registerd')->with($data);
             }else{
               // session()->flash('success', __('site.updated_successfully'));
                 session()->flash('error', __('site.incorrect_info'));
                 return redirect()->back();
             }
     }

    //  public function logout()
    //  {
    //     if(!empty($member = Member::find(auth()->guard('members')->id()))){
    //      auth()->guard('members')->logout();
    //     }

    //      return redirect('live/login');
    //  }
    public function forgetpassword()
    {
        return view('online.auth.forgetpassword');
    }
    public function forgetpassword2()
    {
        return view('online.auth.forgetpassword2');
    }

    public function forgetpassword_post(Request $request)
    {
        $data = $request->validate([
            'password'            => 'required|min:6',
            'password_confirmation' => ['required'],
            [
                'password.required'            => __("user.password"),
                'password.min'                 => __("user.max_password"),
            ]

         ]);
      $member = Member::find(auth()->guard('members')->id());
         if($request->password == $request->password_confirmation){
             $member->password =  bcrypt($request->password);
           $member->update([$member->password=>  $member->password]);
          session()->flash('success', __('site.changed_password_successfully'));
          return redirect()->back();
         }else{
            session()->flash('error', __('site.passwords_not_valid'));
            return redirect()->back();
         }
        }



    // public function aboute(){
    //     return view('online.static.aboute');
    // }

    public function terms(){
        return view('online.static.terms');
    }

    public function repetedquestions(){
        return view('online.static.repetedquestions');
    }



}
