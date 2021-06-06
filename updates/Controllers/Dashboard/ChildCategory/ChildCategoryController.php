<?php

namespace App\Http\Controllers\Dashboard\ChildCategory;

use App\Models\Category;
use App\Models\catParameter;
use App\Models\selectParams;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChildCategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $category = Category::find($id);
        $cats = Category::when($request->search , function ($q) use ($request){
            return $q->where('category_name_ar' , 'like' , '%'. $request->search. '%')
            ->orWhere('category_name_en' , 'like' , '%'. $request->search. '%');
        })->where('parent_id',$category->id)->latest()->paginate(5);

        return view('dashboard.categories.child' , compact('cats'));
    }



     /**
     * ===========================================================================================
     * =============================== Category Parameters =======================================
     * ===========================================================================================
     */

     public function indexParam($id){
        $category = Category::find($id);
        $params   = catParameter::where('cat_id',$category->id)->latest()->paginate(3);
        return view('dashboard.categories.params.index',compact('category','params'));
     }


      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeParam(Request $request,$id)
    {
        $category = Category::find($id);
        $validatedData = $request->validate([
            'param_name_ar' => 'required|max:255',
            'param_name_en' => 'required|max:255',
            'type'          => 'required',
        ],[
            'param_name_ar.required'  => 'يرجي ادخال اسم الخاصيه بالعربيه',
            'param_name_en.required'  => 'يرجي ادخال اسم الخاصيه بالانجليزيه',
            'type.required'           => 'يرجي احتيار نوع الخاصيه',
        ]);
        catParameter::create([
            'param_name_ar'       => $request->param_name_ar,
            'param_name_en'       => $request->param_name_en,
            'cat_id'              => $request->cat_id,
            'type'                => $request->type,
        ]);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->back();
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyParam($cat_id,$param_id)
    {
        $category = Category::find($cat_id);
        $params   = catParameter::find($param_id);
        $params->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->back();
    }




     /**
     * ===========================================================================================
     * =============================== Selected Parameters =======================================
     * ===========================================================================================
     */

    public function indexSelected($id){
        $params = catParameter::find($id);
        $selected   = selectParams::where('param_id',$params->id)->latest()->paginate(3);
        return view('dashboard.categories.selectParams.index',compact('params','selected'));
     }



       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSelected(Request $request,$id)
    {
        $params        = catParameter::find($id);
        $category      = Category::where('id',$params->cat_id )->first();

        $validatedData = $request->validate([
            'param_name_ar' => 'required|max:255',
            'param_name_en' => 'required|max:255',
        ],[
            'param_name_ar.required'  => 'يرجي ادخال اسم المدخل بالعربيه',
            'param_name_en.required'  => 'يرجي ادخال اسم المدخل بالانجليزيه',
        ]);
        selectParams::create([
            'param_name_ar'       => $request->param_name_ar,
            'param_name_en'       => $request->param_name_en,
            'cat_id'              => $category->id,
            'param_id'            => $request->param_id,
        ]);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->back();
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroySelected($param_id,$selected_id)
    {
        $params     = catParameter::find($param_id);
        $selected   = selectParams::find($selected_id);
        $selected->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->back();
    }
}
