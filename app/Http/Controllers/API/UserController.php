<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Member;
use App\Models\Tender;
use App\Models\Auction;
use App\Models\Favorite;
use App\Models\AuctionImage;
use Illuminate\Http\Request;
use App\Models\AuctionDetials;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Tender\TenderResource;
use App\Http\Resources\Acution\FavoriteResource;
use App\Http\Resources\Acution\AcutionResource_ar;
use App\Http\Resources\Acution\AcutionResource_en;
use App\Http\Controllers\API\BaseController as BaseController;

class UserController extends BaseController
{
    //Commercial registration
    public function registerBusiness(Request $request)
    {
        try {
            // return $request;
            $validator = Validator::make(
                $request->all(),
                [
                    'commercial_record'   => 'required|unique:members',
                    'phone'               => 'required|unique:members',
                    'date_of_birth'       => 'required|before:-18 years',
                    'id_number'           => 'required|unique:members',
                    'email'               => 'required|unique:members',
                    'password'            => 'required|min:6',
                ],
                [
                    'commercial_record.required'   => __("user.commercial_record"),
                    'commercial_record.unique'     => __("user.commercial_exist"),
                    'phone.required'               => __("user.phone"),
                    'phone.unique'                 => __("user.unique_phone"),
                    'date_of_birth.required'       => __("user.date_of_birth"),
                    'date_of_birth.before'         => __('user.before'),
                    'id_number.required'           => __("user.id_number"),
                    'id_number.unique'             => __("user.unique_id_number"),
                    'email.required'               => __("user.email"),
                    'email.unique'                 => __("user.unique_email"),
                    'password.required'            => __("user.password"),
                    'password.min'                 => __("user.max_password"),
                ]
            );

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $newmember                     = new Member;
            $newmember->commercial_record  = $request['commercial_record'];
            $newmember->phone              = $request['phone'];
            $newmember->date_of_birth      = $request['date_of_birth'];
            $newmember->id_number          = $request['id_number'];
            $newmember->email              = $request['email'];
            $newmember->password           = Hash::make($request['password']);
            $newmember->type               = 0; //Business
            $newmember->save();
            $message = __("user.regist_success");
            return $this->returnData('user', $message);
        }catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }



    //registeration process
    public function register(Request $request)
    {
        try {
            // return $request;
            $validator = Validator::make(
                $request->all(),
                [
                    'username'            => 'required',
                    'phone'               => 'required|unique:members',
                    'date_of_birth'       => 'required|before:-18 years',
                    'country_id'          => 'required',
                    'email'               => 'required|unique:members',
                    'password'            => 'required|min:6',
                ],
                [
                    'username.required'            => __("user.username"),
                    'phone.required'               => __("user.phone"),
                    'phone.unique'                 => __("user.unique_phone"),
                    'date_of_birth.required'       => __("user.date_of_birth"),
                    'date_of_birth.before'         => __('user.before'),
                    'country_id.required'          => __("user.nationality"),
                    'email.required'               => __("user.email"),
                    'email.unique'                 => __("user.unique_email"),
                    'password.required'            => __("user.password"),
                    'password.min'                 => __("user.max_password"),
                ]
            );

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $newmember                     = new Member;
            $newmember->username           = $request['username'];
            $newmember->phone              = $request['phone'];
            $newmember->date_of_birth      = $request['date_of_birth'];
            $newmember->country_id         = $request['country_id'];
            $newmember->email              = $request['email'];
            $newmember->password           = Hash::make($request['password']);
            $newmember->type               = 1; //not Business
            $newmember->save();
            $message = __("user.regist_success");
            return $this->returnData('user', $message);
        }catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    /**
     * Member Login
     */

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone'          => 'required',
                'password'       => 'required',
            ], [
                'phone.required'        => __("user.phone"),
                'password.required'     => __("user.password"),
            ]);

                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
                //login

                $credentials = $request->only(['phone', 'password']);
                $token = Auth::guard('member-api')->attempt($credentials);  //generate token

                if (!$token)
                    return $this->returnError('E001', __('user.false_info'));

                $user = Auth::guard('member-api')->user();
                $user ->api_token = $token;

                $response = [
                    'id'        => $user->id,
                    'username'  => $user->username,
                    'phone'     => $user->phone,
                    'email'     => $user->email,
                    'api_token' => $token,
                ];
                //return token
                return $this->returnData('user', $response,__('user.login'));  //return json response
        } catch (\Exception $ex) {
                return $this->returnError($ex->getCode(), $ex->getMessage());
            }
    }

    /**
     * Member Logout
     */

    public function logout(Request $request)
    {
         $token = $request->header('auth-token');
        if($token){
            try {
                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('', __('user.wrangs'));
            }
            return $this->returnSuccessMessage(__('user.logout'));
        }else{
            return $this -> returnError('',__('user.wrangs'));
        }
    }
    /**
     * Chack phone is exist
     */

     public function chackPhoneExist(Request $request){
        $validator = Validator::make(
        $request->all(),
            [
                'phone'           => 'required',
            ],[
                'phone.required'  => __('user.phone'),
            ]);

            $user = Member::where('phone', $request->phone)->first();
            if($user){
                $successmessage = __('user.exist');
                return $this->returnData('success',$successmessage);
            }else{
                $errormessage = __('user.notexist');
                return $this -> returnError('',$errormessage);
            }
     }

    /**
  * Member forgetpassword process By Phone
  */
  public function forgetChangePass(Request $request)
  {
    $validator = Validator::make(
        $request->all(),
        [
            'phone'           => 'required',
            'new_password'    => 'required',
        ],[
            'phone.required'        => __('user.phone'),
            'new_password.required' => __('user.requir_new_pass')
        ]
    );

      $user = Member::where('phone', $request->phone)->first();
      if($user){
          $user->password = Hash::make($request['new_password']);
          $user->save();
          $successmessage = __('user.new_pass');
          return $this->returnData('success',$successmessage);
      }else{
        $errormessage = __('user.notexist');
        return $this -> returnError('',$errormessage);
      }
  }



 /**
  * Member forgetpassword process By Email
  */
 public function forgetpassword(Request $request)
 {
     $user = Member::where('email', $request->email)->first();
     if (!$user) {
         $errormessage = __('user.wrang_email');
         return $this -> returnError('',$errormessage);
    } else {
         $randomcode        = substr(str_shuffle("0123456789"), 0, 4);
         $user->forgetcode  = $randomcode;
         $user->save();
         $successmessage = __('user.sent_email');
         return $this->returnData('success', $user->forgetcode, $successmessage);
     }
 }

 /**
  * Member Active code for forget password
  */

  public function activcode(Request $request)
  {
      $user = Member::where('email', $request->email)->where('forgetcode', $request->forgetcode)->first();
      if ($user) {
          return $this->returnData('success', "true",);
      } else {
          $errormessage = __('user.wrang_code');
          return $this -> returnError('',$errormessage);
      }
  }

  /**
   * Member Chanage Password
   */
  public function rechangepass(Request $request)
  {
      $validator = Validator::make(
          $request->all(),
          [
              'new_password'    => 'required',
          ]
      );

      if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

      $member = Member::where('email', $request->email)->first();
      if ($member) {
          $member->password = Hash::make($request->new_password);
          $member->save();
          $errormessage = __('user.new_pass');
          return $this->returnData('success', $errormessage);
      } else {
          $errormessage = __('user.wrang_email');
          return $this -> returnError('error',$errormessage);
      }
  }

    /**
     *  updating profile Commercial registration
     */

    public function updateCommercialProfile(Request $request)
    {
        $upmember = Member::where('id', $request->member_id)->where('type',0)->first();
        if ($upmember) {
                $validator = Validator::make($request->all(), [
                    'commercial_record'   => 'required|unique:members,commercial_record,' . $upmember->id,
                    'phone'               => 'required|unique:members,phone,' . $upmember->id,
                    'date_of_birth'       => 'required',
                    'id_number'           => 'required|unique:members,id_number,' . $upmember->id,
                    'email'               => 'required|unique:members,email,' . $upmember->id,
                    'password'            => 'required|min:6',
                ],
                [
                    'commercial_record.required'   => __("user.commercial_record"),
                    'commercial_record.unique'     => __("user.commercial_exist"),
                    'phone.required'               => __("user.phone"),
                    'phone.unique'                 => __("user.unique_phone"),
                    'date_of_birth.required'       => __("user.date_of_birth"),
                    'id_number.required'           => __("user.id_number"),
                    'id_number.unique'             => __("user.unique_id_number"),
                    'email.required'               => __("user.email"),
                    'email.unique'                 => __("user.unique_email"),
                    'password.required'            => __("user.password"),
                    'password.min'                 => __("user.max_password"),
                ]);
                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
                $upmember->commercial_record  = $request['commercial_record'];
                $upmember->phone              = $request['phone'];
                $upmember->date_of_birth      = $request['date_of_birth'];
                $upmember->id_number          = $request['id_number'];
                $upmember->email              = $request['email'];
                $upmember->password           = $request['password'] ? Hash::make($request['password']) : $upmember->password;
                //Update image
                $old_image = Member::find($upmember->id)->img;
                if($request->hasFile('img')){
                    Storage::disk('uploads')->delete('members/' . $old_image);
                    $image    = $request['img'];
                    $filename = rand(0, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move(base_path('/public/uploads/members/'), $filename);
                    $upmember->img = $filename;
                }
                else{
                    $upmember->img  = $old_image;
                }
                $upmember->save();
                $successmessage = __("user.infoupdate");
                return $this-> returnData('success',$successmessage);
        }else{
            $errormessage = __("user.usernotexist");
            return $this->returnError('E001', $errormessage);
        }
    }



    /**
     *  updating profile
     */

    public function updateProfile(Request $request)
    {
        $upmember = Member::where('id', $request->member_id)->where('type',1)->first();
        if ($upmember) {
            if($upmember->username){
                $validator = Validator::make($request->all(), [
                    'username'            => 'required',
                    'country_id'          => 'required',
                    'email'               => 'required|unique:members,email,' . $upmember->id,
                ],
                [
                    'username.required'            => __("user.username"),
                    'date_of_birth.required'       => __("user.date_of_birth"),
                    'email.required'               => __("user.email"),
                    'email.unique'                 => __("user.unique_email"),
                ]);
                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
                $upmember->username        = $request['username'];
                $upmember->country_id      = $request['country_id'];
                $upmember->email           = $request['email'];

                //Update image
                $old_image = Member::find($upmember->id)->img;
                if($request->hasFile('img')){
                    Storage::disk('uploads')->delete('members/' . $old_image);
                    $image    = $request['img'];
                    $filename = rand(0, 9999) . '.' . $image->getClientOriginalExtension();
                    $image->move(base_path('/public/uploads/members/'), $filename);
                    $upmember->img = $filename;
                }
                else{
                    $upmember->img  = $old_image;
                }
                $upmember->save();
                $successmessage = __("user.infoupdate");
                return $this-> returnData('success',$successmessage);

            } else {
                $errormessage = __("user.usernotexist");
                return $this->returnError('E001', $errormessage);
            }
        }else{
            $errormessage = __("user.usernotexist");
            return $this->returnError('E001', $errormessage);
        }
    }

    /**
     * My Acution v1
     */

     public function myAuction(Request $request){
        $member = Member::where('id',$request->member_id)->first();
        if($member){
            $auction = Auction::where('member_id',$request->member_id)->get();
            if($auction){
                if($request->lang == "en"){
                    $auctions = AcutionResource_en::collection(Auction::where('member_id',$request->member_id)->orderBy('created_at', 'DESC')->get());
                }else{
                    $auctions = AcutionResource_ar::collection(Auction::where('member_id',$request->member_id)->orderBy('created_at', 'DESC')->get());
                }
                return $this->returnData('success', $auctions);
            }else{
                return $this->sendError('success', __("user.usernoauctions"));
            }
        }else{
            return $this->returnError('success', __("user.usernotexist"));
        }
     }

     /**
      * My Tender
      */
     public function myTender(Request $request){
        $member = Member::where('id',$request->member_id)->first();
        if($member){
            $tender = TenderResource::collection(Tender::where('member_id',$request->member_id)->orderBy('created_at', 'DESC')->get());
            if(count($tender) != 0){
                return $this->returnData('success', $tender);
            }else{
                return $this->returnError('success', __("user.notender"));
            }
        }else{
            return $this->returnError('success', __("user.usernotexist"));
        }
     }

     /**
      * Favorites auction for member
      */

      public function storeFavorite(Request $request){
          $member = Member::where('id',$request->member_id)->first();
          if($member){
            $auction = Auction::where('id',$request->auction_id)->first();
            $old_fav = Favorite::where('member_id',$request->member_id)->where('auction_id',$request->auction_id)->first();
            if($old_fav){
                $old_fav->delete();
                return $this->returnData('success', __("user.delete_favourit"));
            }else{
                $favorite = new Favorite;
                $favorite->member_id  = $request->member_id;
                $favorite->auction_id = $request->auction_id;
                $favorite->is_like = 1;
                $favorite->save();
                return $this->returnData('success', __("user.add_favourit"));
            }
          }else{
            return $this->returnError('success', __("user.usernotexist"));
          }
      }

      /**
       * User Favorite
       */

      public function myFavorite(Request $request){
        $member = Member::where('id',$request->member_id)->first();
        if($member){
            $fav = FavoriteResource::collection(Favorite::where('member_id',$request->member_id)->orderBy('created_at', 'DESC')->paginate(8));
            return $this->returnData('success', $fav);
        }else{
            return $this->returnError('success', __("user.usernotexist"));
        }
      }

      /**
       * User Profile
       */

       public function profile(Request $request){
            $member = Member::where('id',$request->member_id)->first();
            if($member){
                $member        = Member::select('id','username','email','img','type','country_id','phone','created_at')->where('id',$request->member_id)->first();
                $acutions      = Auction::where('member_id',$request->member_id)->count();
                $tender        = Tender::where('member_id',$request->member_id)->count();


                $cuurntauction = Auction::where('member_id',$request->member_id)->where('is_finished',0)->count();
                $finishauction = Auction::where('member_id',$request->member_id)->where('is_finished',1)->count();

                $cuurnttender = Tender::where('member_id',$request->member_id)->where('is_winner',0)->count();
                $finishtender = Tender::where('member_id',$request->member_id)->where('is_winner',1)->count();

                if($member->img){
                    $img = asset('uploads/members/' .$member->img);
                }else{
                    $img = null;
                }

                if($member->type == 0){

                    $type = __('user.commercial_type');
                }else{

                    $type = __('user.user_type');
                }

                if($member->country){
                    if($request->lang == "en"){
                        $country = $member->country->country_name_en;
                    }else{
                        $country = $member->country->country_name_ar;
                    }
                }

                $response = [
                    'id'             => $member->id,
                    'username'       => $member->username,
                    'email'          => $member->email,
                    'phone'          => $member->phone,
                    'country_id'     => $member->country_id,
                    'adderss'        => isset($country) ? $country : null,
                    'profile_type'   => $type,
                    'image'          => $img,
                    'acutions'       => $acutions,
                    'tender'         => $tender,
                    'cuurntauction'  => $cuurntauction,
                    'finishauction'  => $finishauction,
                    'cuurnttender'   => $cuurnttender,
                    'finishtender'   => $finishtender,
                    'created_at'     => $member->created_at,
                ];
                return $this->returnData('success', $response);
            }else{
                return $this->returnError('success', __("user.usernotexist"));
            }
       }





     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function change_password_method(Request $request)
    {
        $member = Member::where('id',$request->member_id)->first();
        if($member){
            $validator = Validator::make(
                $request->all(),
            [
                'member_id'    => 'required',
                'old_password' => 'required',
                'password'     => 'required',
            ],[
                'member_id.required'       => __("user.member_id"),
                'old_password.required'    => __("user.old_password"),
                'password.required'        => __("user.password"),
            ]);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

           // dd(Hash::check($request->old_password, $user->password));
            if(Hash::check($request->old_password, $member->password))
            {
                $member->fill([
                    'password' => Hash::make($request->password)
                ])->save();

                $message = __('user.success_pass');
                return $this->returnData('success', $message);
            }
            else
            {
                $message = __('user.wrong_pass');
                return $this->returnError('success',$message);
            }
        }else{
            return $this->returnError('success', __("user.usernotexist"));
        }
    }
}
