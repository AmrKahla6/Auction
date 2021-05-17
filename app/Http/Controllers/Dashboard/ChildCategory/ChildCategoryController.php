<?php

namespace App\Http\Controllers\Dashboard\ChildCategory;

use App\Models\Category;
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
}
