<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\About;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function about(){
        $data['about'] = About::select('id','detials_ar','detials_en')->first();
        return view('dashboard.setting.about')->with($data);
    }

    public function aboutEdit(Request $request,$id){
       $request->validate([
            'detials_ar'    => 'required',
            'detials_en'    => 'required',
        ],[
            'detials_ar.required'     => 'يرجي ادخال التفاصيل بالعربيه',
            'detials_en.required'     => 'يرجي ادخال التفاصيل بالانجليزيه',
        ]);

        $about  = About::find($id);
        $about->detials_ar = $request->detials_ar;
        $about->detials_en = $request->detials_en;
        $about->save();

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.setting-about');
    }

       /**
      * Contact us
      */

      public function contact(Request $request)
      {
          $data['contacts'] = Contact::whereHas('member', function ($query) use ($request) {
            $query->where('username', 'like', "%{$request->search}%")
            ->orWhere('email' , 'like' , '%'. $request->search. '%')
            ->orWhere('message' , 'like' , '%'. $request->search. '%');
        })->latest()->paginate(5);

          return view('dashboard.setting.contacts')->with($data);
      }

      /**
       * Delete Contact
       */

       public function deleteContact($id){
           $contact = Contact::find($id);
           $contact->delete();

           session()->flash('success', __('site.deleted_successfully'));

           return redirect()->route('dashboard.setting-contact');
       }
}
