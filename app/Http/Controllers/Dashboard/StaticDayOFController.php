<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\StaticDayOF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaticDayOFController extends Controller
{
    public function index(Request $request){
        $data['days'] = StaticDayOF::when($request->search , function ($q) use ($request){
            return $q->where('day' , 'like' , '%'. $request->search. '%');
        })->latest()->paginate(5);

        return view('dashboard.static_days.index')->with($data);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'day' => 'required|unique:static_day_o_f_s',
        ],[
            'day.required'  => 'يرجي ادخال تاريخ العطله',
            'day.unique'    => 'تاريخ العطله مسجل مسبقا',
        ]);
        $data = $request->all();
        $day  = StaticDayOF::create($data);
        session()->flash('success', __('site.added_successfully'));

        return redirect()->back();
    }


    public function destroy($id){
        $day = StaticDayOF::findOrFail($id);
        $day->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->back();
     }
}
