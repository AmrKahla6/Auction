<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function __construct()
    {
      $this->middleware(['permission:read_advertisements'])->only('index');

      $this->middleware(['permission:create_advertisements'])->only('create');

      $this->middleware(['permission:update_advertisements'])->only('edit');

      $this->middleware(['permission:delete_advertisements'])->only('destroy');
    }//end of construct


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ads = Advertisement::when($request->search , function ($q) use ($request){
            return $q->where('link' , 'like' , '%'. $request->search. '%');
        })->latest()->paginate(5);

        return view('dashboard.advertisement.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.advertisement.create');
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
            'link' => 'required|url|max:255',
            'img'  => 'nullable',
        ],[
            'question_ar.required'  => 'يرجي ادخال رابط الاعلان',
            'question_ar.url'      => 'يجب ان يكون رابط من نوع url',
        ]);

        $data = $request->except(['img']);

        if ($request->img) {
            Image::make($request->img)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path('uploads/advertisement/' . $request->img->hashName()));
            $data['img'] = $request->img->hashName();
         }else{
            $data['img'] = 'default.png';
         }

         $cat = Advertisement::create($data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.advertisement.index');
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
        $ads = Advertisement::find($id);
        return view('dashboard.advertisement.edit', compact('ads'));
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
            'link'   => 'required|url',
            'img'    => 'nullable',
        ],[

            'question_ar.required'  => 'يرجي ادخال رابط الاعلان',
            'question_ar.url'      => 'يجب ان يكون رابط من نوع url',
        ]);
        $ads     = Advertisement::find($id);
        $data    = $request->all();
        $old_img = Advertisement::find($ads->id)->img;
        if ($request->img) {
            Storage::disk('uploads')->delete('advertisement/' . $old_img);
            Image::make($request->img)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path('uploads/advertisement/' . $request->img->hashName()));
            $data['img'] = $request->img->hashName();
        }else{
            $data['img'] = $old_img;
        }

        $ads->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.advertisement.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ads = Advertisement::find($id);
        Storage::disk('uploads')->delete('advertisement/' . $ads->img);
        $ads->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.advertisement.index');
    }
}
