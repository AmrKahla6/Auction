<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Governorate;

class CityController extends Controller
{

    public function __construct()
    {
      $this->middleware(['permission:read_governorates'])->only('index');

      $this->middleware(['permission:create_governorates'])->only('create');

      $this->middleware(['permission:update_governorates'])->only('edit');

      $this->middleware(['permission:delete_governorates'])->only('destroy');
    }//end of construct


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['govtes'] = Governorate::when($request->search , function ($q) use ($request){
            return $q->where('governorate_name_ar' , 'like' , '%'. $request->search. '%')
            ->orWhere('governorate_name_en' , 'like' , '%'. $request->search. '%');
        })->latest()->paginate(5);

        return view('dashboard.governorates.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.governorates.create');
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
            'governorate_name_ar' => 'required|unique:governorates|max:255',
            'governorate_name_en' => 'required|unique:governorates|max:255',
        ],[
            'governorate_name_ar.required'  => 'يرجي ادخال اسم المحافظه بالعربيه',
            'governorate_name_en.unique'    => 'اسم المحافظه بالعربيه مسجل مسبقا',
            'governorate_name_en.required'  => 'يرجي ادخال اسم المحافظه بالانجليزيه',
            'governorate_name_en.unique'    => 'اسم المحافظه بالانجليزيه مسجل مسبقا',
        ]);
        Governorate::create([
            'governorate_name_ar'       => $request->governorate_name_ar,
            'governorate_name_en'       => $request->governorate_name_en,
        ]);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.governorates.index');
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
    public function edit(Governorate $governorate)
    {
        return view('dashboard.governorates.edit', compact('governorate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'governorate_name_ar' => 'required|max:255|unique:governorates,governorate_name_ar,'.$id,
            'governorate_name_en' => 'required|max:255|unique:governorates,governorate_name_en,'.$id,
        ],[

            'governorate_name_ar.required'  => 'يرجي ادخال اسم المحافظه بالعربيه',
            'governorate_name_en.unique'    => 'اسم المحافظه بالعربيه مسجل مسبقا',
            'governorate_name_en.required'  => 'يرجي ادخال اسم المحافظه بالانجليزيه',
            'governorate_name_en.unique'    => 'اسم المحافظه بالانجليزيه مسجل مسبقا',
        ]);
        $governorate = Governorate::find($id);
        $governorate->update([
            'governorate_name_ar' => $request->governorate_name_ar,
            'governorate_name_en' => $request->governorate_name_en,
        ]);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.governorates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Governorate::findOrFail($id)->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.governorates.index');
    }
}
