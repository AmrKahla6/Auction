<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\AuctionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuctionTypeController extends Controller
{

    public function __construct()
    {
      $this->middleware(['permission:read_auction_types'])->only('index');

      $this->middleware(['permission:create_auction_types'])->only('create');

      $this->middleware(['permission:update_auction_types'])->only('edit');

      $this->middleware(['permission:delete_auction_types'])->only('destroy');
    }//end of construct


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['types'] = AuctionType::when($request->search , function ($q) use ($request){
            return $q->where('type_name_ar' , 'like' , '%'. $request->search. '%')
            ->orWhere('type_name_en' , 'like' , '%'. $request->search. '%');
        })->latest()->paginate(5);

        return view('dashboard.types.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type_name_ar' => 'required|unique:auction_types|max:255',
            'type_name_en' => 'required|unique:auction_types|max:255',
        ],[
            'type_name_ar.required'  => 'يرجي ادخال نوع المزاد بالعربيه',
            'type_name_ar.unique'    => ' نوع المزاد بالعربيه مسجل مسبقا',
            'type_name_en.required'  => 'يرجي ادخال  نوع المزاد بالانجليزيه',
            'type_name_en.unique'    => ' نوع المزاد بالانجليزيه مسجل مسبقا',
        ]);
        AuctionType::create([
            'type_name_ar'     => $request->type_name_ar,
            'type_name_en'     => $request->type_name_en,
        ]);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.auction-type.index');
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
        $type = AuctionType::find($id);
        return view('dashboard.types.edit', compact('type'));
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
        $id = $request->id;
        $this->validate($request, [
            'type_name_ar' => 'required|max:255|unique:auction_types,type_name_ar,'.$id,
            'type_name_en' => 'required|max:255|unique:auction_types,type_name_en,'.$id,
        ],[

            'type_name_ar.required'  => 'يرجي ادخال نوع المزاد بالعربيه',
            'type_name_ar.unique'    => ' نوع المزاد بالعربيه مسجل مسبقا',
            'type_name_en.required'  => 'يرجي ادخال  نوع المزاد بالانجليزيه',
            'type_name_en.unique'    => ' نوع المزاد بالانجليزيه مسجل مسبقا',
        ]);
        $type = AuctionType::find($id);
        $type->update([
            'type_name_ar'     => $request->type_name_ar,
            'type_name_en'     => $request->type_name_en,
        ]);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.auction-type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AuctionType::findOrFail($id)->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.auction-type.index');
    }
}
