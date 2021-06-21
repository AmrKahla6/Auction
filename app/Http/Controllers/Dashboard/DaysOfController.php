<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\DaysOF;
use App\Models\Auction;
use App\Models\StaticDayOF;
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
            'days_of' => 'required|unique:days_o_f_s|date|after:today',
        ],[
            'days_of.required'  => 'يرجي ادخال تاريخ العطله',
            'days_of.unique'    => 'تاريخ العطله مسجل مسبقا',
            'days_of.after'     => 'لا يمكن اختيار تاريخ قديم للعطله',
        ]);
        $dayname   = Carbon::parse($request->days_of)->format('l');
        $stat_days = StaticDayOF::where('day',$dayname)->exists();
        if($stat_days){
            session()->flash('error', ('بالفعل هو اجازه ثابته'));

            return redirect()->back();
        }
        $data     = $request->all();
        $day      = DaysOF::create($data);
    //     $auctions = Auction::where('is_finished', 0)->get();

    //    foreach ($auctions as $key => $auction) {
    //       $aut_date =  explode(" ", $auction->end_data)[0];
    //         if($day->days_of < $aut_date){
    //             $auction->end_data = date("Y-m-d H:i:s", strtotime('+24 hours', strtotime($auction->end_data)));
    //             $auction->save();
    //         }
    //    }
        session()->flash('success', __('site.added_successfully'));

        return redirect()->back();
    }


    public function updateDaysOf(Request $request){
        $id = $request->id;

        $this->validate($request, [
            'days_of' => 'required|max:255|date|after:today|unique:days_o_f_s,days_of,'.$id,
        ],[
            'days_of.required'  => 'يرجي ادخال تاريخ العطله',
            'days_of.unique'    => 'تاريخ العطله مسجل مسبقا',
            'days_of.after'     => 'لا يمكن اختيار تاريخ قديم للعطله',
        ]);

        $phone = DaysOF::find($id);
        $phone->update([
            'days_of' => $request->days_of,
        ]);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->back();
     }

     public function deleteDayOf($id){
        $day = DaysOF::findOrFail($id);
        $auctions = Auction::where('is_finished', 0)->get();
       foreach ($auctions as $key => $auction) {
          $aut_date =  explode(" ", $auction->end_data)[0];
            if($day->days_of < $aut_date){
                $auction->end_data = date("Y-m-d H:i:s", strtotime('-24 hours', strtotime($auction->end_data)));
                $auction->save();
            }
       }
        $day->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->back();
     }
}
