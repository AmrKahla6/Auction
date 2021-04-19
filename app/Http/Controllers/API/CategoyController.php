<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;

class CategoyController extends BaseController
{
    /**
     * Get Main Category
     */
    public function mainCategory()
    {
        $parentCategories = Category::select("id","category_name_" .app()->getLocale() . ' as category_name','img')->where('parent_id',0)->get();
        if($parentCategories){
            return $this->returnData('categories', $parentCategories);
        }else{
            $errormessage = __('user.no_categories');
            return $this -> returnError('',$errormessage);
        }
    }

    /**
     * Get Sub Category
     */

    public function subCategory(Request $request){
        $subCategory = Category::select("id","category_name_" .app()->getLocale() . ' as category_name','img')->where('parent_id',$request->cat_id)->get();
        if($subCategory){
            return $this->returnData('categories', $subCategory);
        }else{
            $errormessage = __('user.no_categories');
            return $this -> returnError('',$errormessage);
        }
    }
}
