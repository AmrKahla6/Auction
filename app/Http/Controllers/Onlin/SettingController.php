<?php

namespace App\Http\Controllers\Onlin;

use Auth;
use App\Models\Term;
use App\Models\About;
use App\Models\Contact;
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

    public function contactUs(){
        return view('online.contacts');
    }

    public function storeContactUs(Request $request){
        $data = $request->validate([
            'message' => 'required'
            ], [
                'message.required' => __('user.message')
            ]
        );

        $member   = Auth::guard('members')->user();
        $contacts = new Contact;
        $contacts->message = $request->message;
        $contacts->member_id = $member->id;
        $contacts->save();
        session()->flash('success', __('live.succss_contact'));
        return redirect()->route('live.contact-us');
    }

    public function terms(){
        $term  = Term::select("term_" .app()->getLocale() . ' as term')->first();
        return view('online.static.terms',compact('term'));
    }
}
