<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\DaysOF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaysOfController extends Controller
{
    public function getDaysOf(Request $request){
        $data['days'] = DaysOF::when($request->search , function ($q) use ($request){
            return $q->where('days_of' , 'like' , '%'. $request->search. '%');
        })->latest()->paginate(5);

        return view('dashboard.days.index')->with($data);
    }

    public function postDaysOf(Request $request){
        $validatedData = $request->validate([
            'days_of' => 'required|unique:days_o_f_s|date|before:-1 years',
        ],[
            'days_of.required'  => 'يرجي ادخال تاريخ العطله',
            'days_of.unique'    => 'تاريخ العطله مسجل مسبقا',
            'days_of.before'    => 'لا يمكن اختيار تاريخ قديم للعطله',
        ]);
        $data = $request->all();
        $day  = DaysOF::create($data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->back();
    }


    public function updateDaysOf(Request $request){
        $id = $request->id;

        $this->validate($request, [
            'days_of' => 'required|max:255|date|before:-1 years|unique:days_o_f_s,days_of,'.$id,
        ],[
            'days_of.required'  => 'يرجي ادخال تاريخ العطله',
            'days_of.unique'    => 'تاريخ العطله مسجل مسبقا',
            'days_of.before'    => 'لا يمكن اختيار تاريخ قديم للعطله',
        ]);

        $phone = DaysOF::find($id);
        $phone->update([
            'days_of' => $request->days_of,
        ]);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->back();
     }

     public function deleteDayOf($id){
        DaysOF::findOrFail($id)->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->back();
     }
}
