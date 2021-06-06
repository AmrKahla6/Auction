<?php

namespace App\Http\Controllers\Onlin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Member;
use App\Models\Auction;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
class Register extends Controller
{


    public function register()
    {
        return view('online.auth.register');
    }

    public function register_post(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'date_of_birth' => ['required'], 
            'phone' => ['required', 'string','unique:members'],
            'password' => ['required', 'string', 'min:8'], 
            'commercial_record' => [], 
            'nationality' => [], 
            'id_number' => [], 
            'type' => [], 
             
         ]);
         $data['password'] = bcrypt($request->password);
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
        $data['auctions_dis']  = Auction::where('member_id',$member->id)->where('is_finished',true)->with('images')->get();
        // return redirect('live/registerd');
         return redirect()->route('live.registerd');

    }
    }

    public function login_post(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required'], 
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

     public function logout()
     {
         auth()->guard('members')->logout();
         return redirect('live/login');
     }
    public function forgetpassword()
    {
        return view('online.auth.forgetpassword');
    }

    public function forgetpassword_post(Request $request)
    {
        dd($request->all());
    }

    public function aboute(){
        return view('online.static.aboute');
    }

    public function terms(){
        return view('online.static.terms');
    }
    
    public function repetedquestions(){
        return view('online.static.repetedquestions');
    }


    
}