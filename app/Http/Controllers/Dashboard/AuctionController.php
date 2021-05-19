<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Auction;
use App\Models\AuctionImage;
use Illuminate\Http\Request;
use App\Models\AuctionDetials;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['acutions'] = Auction::whereHas('member', function ($query) use ($request) {
            $query->where('username', 'like', "%{$request->search}%")
            ->orWhere('email' , 'like' , '%'. $request->search. '%')
            ->orWhere('auction_title' , 'like' , '%'. $request->search. '%')
            ->orWhere('address' , 'like' , '%'. $request->search. '%')
            ->orWhere('price_opining' , 'like' , '%'. $request->search. '%')
            ->orWhere('price_closing' , 'like' , '%'. $request->search. '%')
            ->orWhere('status' , 'like' , '%'. $request->search. '%')
            ->orWhere('is_finished' , 'like' , '%'. $request->search. '%')
            ->orWhere('is_slider' , 'like' , '%'. $request->search. '%');
        })
        ->orWhereHas('category', function ($query) use ($request) {
            $query->where('category_name_ar', 'like', "%{$request->search}%")
            ->orWhere('category_name_en' , 'like' , '%'. $request->search. '%');
        })
        ->latest()->paginate(5);

        return view('dashboard.auctions.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $acution  = Auction::find($id);
        $images   = AuctionImage::where('auction_id',$acution->id)->get();
        foreach($images as $image){
            Storage::disk('uploads')->delete('acution/' . $image->img);
        }
        $acution->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.auction.index');
    }


    /**
     * ================================================================================
     * ========================= Slider ===============================================
     * ================================================================================
     */

     public function storeSlider(Request $request){
        $acution  = Auction::find($request->id);
        $validatedData = $request->validate([
            'desc_ar' => 'required',
            'desc_en' => 'required',
        ],[
            'desc_ar.required'  => 'يرجي ادخال  الوصف بالعربيه',
            'desc_en.required'  => 'يرجي ادخال  الوصف بالانجليزيه',
        ]);

        $acution->is_slider = 1;
        $acution->desc_ar   = $request->desc_ar;
        $acution->desc_en   = $request->desc_en;
        $acution->save();
        session()->flash('success', __('site.added_successfully'));
        return redirect()->back();
     }

     public function deleteSlider($id){
        $acution  = Auction::find($id);
        $acution->is_slider = 0;
        $acution->desc_ar   = null;
        $acution->desc_en   = null;
        $acution->save();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->back();
     }
}
