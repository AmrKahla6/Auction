<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Term;
use App\Models\About;
use App\Models\Phone;
use App\Models\Contact;
use App\Models\Privicy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function __construct()
    {
      $this->middleware(['permission:update_abouts'])->only('aboutEdit');
      $this->middleware(['permission:update_terms'])->only('tremsEdit');
      $this->middleware(['permission:update_privicies'])->only('priviciesEdit');
      $this->middleware(['permission:read_contacts'])->only('contact');

    }//end of construct


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


        /**
        * privicies
        */

        public function privicies(){
            $data['privicies'] = Privicy::select('id','privcy_ar','privcy_en')->first();
            return view('dashboard.setting.privicies')->with($data);
        }

        public function priviciesEdit(Request $request,$id){
            $request->validate([
                 'privcy_ar'    => 'required',
                 'privcy_en'    => 'required',
             ],[
                 'privcy_ar.required'     => 'يرجي ادخال الشروط بالعربيه',
                 'privcy_en.required'     => 'يرجي ادخال الشروط بالانجليزيه',
             ]);

             $terms  = Privicy::find($id);
             $terms->privcy_ar = $request->privcy_ar;
             $terms->privcy_en = $request->privcy_en;
             $terms->save();

             session()->flash('success', __('site.updated_successfully'));

             return redirect()->route('dashboard.setting-privicies');
         }


          /**
        * trems
        */

        public function trems(){
            $data['trems'] = Term::select('id','term_ar','term_en')->first();
            return view('dashboard.setting.trems')->with($data);
        }

        public function tremsEdit(Request $request,$id){
            $request->validate([
                 'term_ar'    => 'required',
                 'term_en'    => 'required',
             ],[
                 'term_ar.required'     => 'يرجي ادخال الشروط بالعربيه',
                 'term_en.required'     => 'يرجي ادخال الشروط بالانجليزيه',
             ]);

             $terms  = Term::find($id);
             $terms->term_ar = $request->term_ar;
             $terms->term_en = $request->term_en;
             $terms->save();

             session()->flash('success', __('site.updated_successfully'));

             return redirect()->route('dashboard.setting-trems');
         }

         /**
          * ===========================================================================================================
          * ============================================== Company Phones =============================================
          * ===========================================================================================================
          */

         public function getPhone(Request $request){
            $data['phones'] = Phone::when($request->search , function ($q) use ($request){
                return $q->where('number' , 'like' , '%'. $request->search. '%');
            })->latest()->paginate(5);

            return view('dashboard.phone.index')->with($data);
         }

         public function storePhone(Request $request){
            $request->validate([
                'number' => 'required|unique:phones',
            ],[
                'number.required'     => 'يرجي ادخال  الرقم',
                'number.required'     => 'الرقم موجود بالفعل',
            ]);

            Phone::create([
                'number' => $request->number,
            ]);

            session()->flash('success', __('site.added_successfully'));

            return redirect()->route('dashboard.setting-get-phone');
         }

         public function editPhone(Request $request){
            $id = $request->id;

            $this->validate($request, [
                'number' => 'required|max:255|unique:phones,number,'.$id,
            ],[
                'number.required'     => 'يرجي ادخال  الرقم',
                'number.required'     => 'الرقم موجود بالفعل',
            ]);

            $phone = Phone::find($id);
            $phone->update([
                'number' => $request->number,
            ]);

            session()->flash('success', __('site.updated_successfully'));

            return redirect()->route('dashboard.setting-get-phone');
         }


         public function deletePhone($id){
            Phone::findOrFail($id)->delete();
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('dashboard.setting-get-phone');
         }
}
