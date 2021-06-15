<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\catParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
      $this->middleware(['permission:read_categories'])->only('index');

      $this->middleware(['permission:create_categories'])->only('create');

      $this->middleware(['permission:update_categories'])->only('edit');

      $this->middleware(['permission:delete_categories'])->only('destroy');
    }//end of construct


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['cats'] = Category::when($request->search , function ($q) use ($request){
            return $q->where('category_name_ar' , 'like' , '%'. $request->search. '%')
            ->orWhere('category_name_en' , 'like' , '%'. $request->search. '%');
        })->where('parent_id',0)->latest()->paginate(5);

        return view('dashboard.categories.index')->with($data);
    }

    /**
     * Create Category
     */

     public function create(){
         $data['cats'] = Category::where('parent_id',0)->get();
        return view('dashboard.categories.create')->with($data);
     }

     /**
      * Store Category
      */

      public function store(Request $request){
        $validatedData = $request->validate([
            'category_name_ar' => 'required|unique:categories|max:255',
            'category_name_en' => 'required|unique:categories|max:255',
            'img'              => 'required',
        ],[
            'category_name_ar.required'  => 'يرجي ادخال اسم القسم بالعربيه',
            'category_name_ar.unique'    => 'اسم القسم بالعربيه مسجل مسبقا',
            'category_name_en.required'  => 'يرجي ادخال اسم القسم بالانجليزيه',
            'category_name_en.unique'    => 'اسم القسم بالانجليزيه مسجل مسبقا',
            'img.required'               => 'يرجي ادخال صوره القسم',
        ]);

        $data = $request->except(['parent_id', 'img','price']);

        if ($request->img) {
            Image::make($request->img)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path('uploads/category/' . $request->img->hashName()));
            $data['img'] = $request->img->hashName();
         }else{
            $data['img'] = 'default.png';
         }

         if($request->parent_id){
            $data['parent_id'] = $request->parent_id;
        }else{
            $data['parent_id'] = 0;
        }

        if ($data['parent_id'] == 0) {
            $data['price']  = $request->price;
        }else{
            $data['price']  = null;
        }
        $cat = Category::create($data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->back();
      }


      /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $cats = Category::where('parent_id',0)->get();
        return view('dashboard.categories.edit' , compact('category','cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $id = $request->id;
        $this->validate($request, [
            'category_name_ar' => 'required|max:255|unique:categories,category_name_ar,'.$id,
            'category_name_en' => 'required|max:255|unique:categories,category_name_en,'.$id,
            'img'              => 'nullable',
        ],[

            'category_name_ar.required'  => 'يرجي ادخال اسم القسم بالعربيه',
            'category_name_ar.unique'    => 'اسم القسم بالعربيه مسجل مسبقا',
            'category_name_en.required'  => 'يرجي ادخال اسم القسم بالانجليزيه',
            'category_name_en.unique'    => 'اسم القسم بالانجليزيه مسجل مسبقا',
        ]);
        $category = Category::find($id);
        $data = $request->all();
        $old_img = Category::find($category->id)->img;
        if ($request->img) {
            Storage::disk('uploads')->delete('category/' . $old_img);
            Image::make($request->img)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path('uploads/category/' . $request->img->hashName()));
            $data['img'] = $request->img->hashName();
        }else{
            $data['img'] = $old_img;
        }
        if(!$request->parent_id){
            $data['parent_id'] = 0;
        }else{
            $data['parent_id'] = $request->parent_id;
        }

        if ($data['parent_id'] == 0) {
            $data['price']  = $request->price;
        }else{
            $data['price']  = null;
        }
        $category->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->back();
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        Storage::disk('uploads')->delete('category/' . $category->img);
        $category->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.cats.index');
    }


}
