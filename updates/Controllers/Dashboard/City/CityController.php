<?php

namespace App\Http\Controllers\Dashboard\City;

use App\Models\City;
use App\Models\Governorate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Governorate $governorate)
    {
        return view('dashboard.governorates.cities.index' , compact('governorate'));
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
    public function store(Request $request,Governorate $governorate)
    {
        $validatedData = $request->validate([
            'city_name_ar' => 'required|unique:cities|max:255',
            'city_name_en' => 'required|unique:cities|max:255',
        ],[
            'city_name_ar.required'  => 'يرجي ادخال اسم المدينه بالعربيه',
            'city_name_ar.unique'    => 'اسم المدينه بالعربيه مسجل مسبقا',
            'city_name_en.required'  => 'يرجي ادخال اسم المدينه بالانجليزيه',
            'city_name_en.unique'    => 'اسم المدينه بالانجليزيه مسجل مسبقا',
        ]);
        City::create([
            'city_name_ar'       => $request->city_name_ar,
            'city_name_en'       => $request->city_name_en,
            'governorate_id'     => $request->governorate_id,
        ]);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.governorates.cities.index',['governorate' => $governorate]);
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
    public function destroy(Governorate $governorate,City $city)
    {
        $city->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.governorates.cities.index',['governorate' => $governorate]);
    }
}
