<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Term;
use App\Models\About;
use App\Models\Member;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;

class AppsettingController extends BaseController
{
    public function terms(){
        $term = Term::select("term_" .app()->getLocale() . ' as Term')->first();
        if($term){
            return $this->returnData('Term', $term);
        }else{
            $errormessage = __('user.no_term');
            return $this -> returnError('',$errormessage);
        }
    }

    /**
     * Get About as
     */

    public function about_as(){
        $about = About::select("detials_" .app()->getLocale() . ' as About As')->first();
        if($about){
            return $this->returnData('About As', $about);
        }else{
            $errormessage = __('user.no_detials');
            return $this -> returnError('',$errormessage);
        }
    }

      //Contact Us From
      public function contactus(Request $request)
      {
        $validator = Validator::make(
            $request->all(),
            [
                'message'    => 'required',
                'member_id'  => 'required',
            ],
            [
                'message.required'   => __("user.message"),
            ]
        );
          $member = Member::where('id',$request->member_id)->first();
          if($member){
              $newcontact               = new Contact();
            //   $newcontact->member_id    = Auth::user();
              $newcontact->message      = $request->message;
              $newcontact->member_id    = $request->member_id;
              $newcontact->save();
              $successmsg =  __('user.successMesg');
              return $this->returnData('success', $successmsg);
          }else{
             $errormessage =  __('user.usernotexist');
              return $this -> returnError('error',$errormessage);
          }
      }
}
