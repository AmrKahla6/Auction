<?php

namespace App\Http\Controllers\Onlin;

use App\Models\About;
use App\Models\Privicy;
use Illuminate\Http\Request;
use App\Models\CommonQuestion;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function about(){
        $about  = About::select("detials_" .app()->getLocale() . ' as detials')->first();
        $privcy = Privicy::select("privcy_" .app()->getLocale() . ' as privcy')->first();
        return view('online.static.aboute',compact('about','privcy'));
    }

    public function commonQuestions(){
        $data['questions'] = CommonQuestion::select('id',"question_" .app()->getLocale() . ' as question',"answer_" .app()->getLocale() . ' as answer')->orderBy('id','DESC')->get();
        return view('online.commonQuestion')->with($data);
    }
}
