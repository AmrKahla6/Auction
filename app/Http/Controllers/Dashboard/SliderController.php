<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{

    public function __construct()
    {
      $this->middleware(['permission:read_sliders'])->only('index');

      $this->middleware(['permission:create_sliders'])->only('create');

      $this->middleware(['permission:update_sliders'])->only('edit');

      $this->middleware(['permission:delete_sliders'])->only('destroy');
    }//end of construct


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sliders = Slider::when($request->search , function ($q) use ($request){
            return $q->where('title_ar' , 'like' , '%'. $request->search. '%')
            ->orWhere('title_en' , 'like' , '%'. $request->search. '%');
        })->latest()->paginate(5);

        return view('dashboard.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.sliders.create');
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
            'title_ar' => 'required|unique:sliders|max:255',
            'title_en' => 'required|unique:sliders|max:255',
            'body_ar'  => 'required|max:255',
            'body_en'  => 'required|max:255',
            'img'      => 'nullable',
        ],[
            'title_ar.required'  => 'يرجي ادخال عنوان السلايدر بالعربيه',
            'title_ar.unique'    => 'عنوان السلايدر بالعربيه مسجل مسبقا',
            'title_en.required'  => 'يرجي ادخال عنوان السلايدر بالانجليزيه',
            'title_en.unique'    => 'عنوان السلايدر بالانجليزيه مسجل مسبقا',
            'body_ar.required'   => 'يرجي ادخال تفاصيل السلايدر بالعربيه',
            'body_en.required'   => 'يرجي ادخال تفاصيل السلايدر بالانجليزيه',
        ]);
        $data = $request->except(['img']);

        if ($request->img) {
            Image::make($request->img)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path('uploads/slider/' . $request->img->hashName()));
            $data['img'] = $request->img->hashName();
         }else{
            $data['img'] = 'default.png';
         }

         $slider = Slider::create($data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.sliders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['slider'] = Slider::find($id);
        return view('dashboard.sliders.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['slider'] = Slider::find($id);
        return view('dashboard.sliders.edit')->with($data);
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
            'title_ar' => 'required|max:255|unique:sliders,title_ar,'.$id,
            'title_en' => 'required|max:255|unique:sliders,title_en,'.$id,
            'body_ar'  => 'required',
            'body_en'  => 'required',
            'img'      => 'nullable',
        ],[

            'title_ar.required'  => 'يرجي ادخال عنوان السلايدر بالعربيه',
            'title_ar.unique'    => 'عنوان السلايدر بالعربيه مسجل مسبقا',
            'title_en.required'  => 'يرجي ادخال عنوان السلايدر بالانجليزيه',
            'title_en.unique'    => 'عنوان السلايدر بالانجليزيه مسجل مسبقا',
            'body_ar.required'   => 'يرجي ادخال تفاصيل السلايدر بالعربيه',
            'body_en.required'   => 'يرجي ادخال تفاصيل السلايدر بالانجليزيه',
        ]);
        $slider = Slider::find($id);
        $data = $request->all();
        $old_img = Slider::find($slider->id)->img;
        if ($request->img) {
            Storage::disk('uploads')->delete('slider/' . $old_img);
            Image::make($request->img)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path('uploads/slider/' . $request->img->hashName()));
            $data['img'] = $request->img->hashName();
        }else{
            $data['img'] = $old_img;
        }

        $slider->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.sliders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        Storage::disk('uploads')->delete('slider/' . $slider->img);
        $slider->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.sliders.index');
    }
}
