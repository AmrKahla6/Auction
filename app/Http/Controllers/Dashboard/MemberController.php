<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class MemberController extends Controller
{

    /**
     * ============================================================================
     * ========================= Commercial Clients ================================
     * ============================================================================
     */
    public function index(Request $request){
        $data['members'] = Member::when($request->search , function ($q) use ($request){
            return $q->where('email' , 'like' , '%'. $request->search. '%')
            ->orWhere('phone' , 'like' , '%'. $request->search. '%')
            ->orWhere('id_number' , 'like' , '%'. $request->search. '%')
            ->orWhere('commercial_record' , 'like' , '%'. $request->search. '%');
        })->where('type',0)->latest()->paginate(5);
        return view('dashboard.members.commercia.index')->with($data);
    }


    public function show(Member $member){
        return view('dashboard.members.commercia.show',compact('member'));
    }


    public function destroy(Member $member){
        Storage::disk('uploads')->delete('members/' . $member->img);
        $member->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.members.index');
    }


    /**
     * ============================================================================================
     * ============================================ Regular Clients ===============================
     * ============================================================================================
     */

     public function regularIndex(Request $request){
        $data['members'] = Member::when($request->search , function ($q) use ($request){
            return $q->where('email' , 'like' , '%'. $request->search. '%')
            ->orWhere('username' , 'like' , '%'. $request->search. '%')
            ->orWhere('phone' , 'like' , '%'. $request->search. '%')
            ->orWhere('commercial_record' , 'like' , '%'. $request->search. '%');
        })->where('type',1)->latest()->paginate(5);
        return view('dashboard.members.regular.index')->with($data);
     }


     public function regularShow(Member $member){
        return view('dashboard.members.regular.show',compact('member'));
    }


    public function regularDestroy(Member $member){
        Storage::disk('uploads')->delete('members/' . $member->img);
        $member->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.members-regular-index');
    }

}
