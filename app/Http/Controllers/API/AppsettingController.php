<?php

namespace App\Http\Controllers\API;

use App\Models\Term;
use App\Models\About;
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
}
