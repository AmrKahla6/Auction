<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\catParameter;
use App\Models\selectParams;
use Illuminate\Http\Request;
use App\Models\CommonQuestion;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\MainCategoryResource_ar;
use App\Http\Resources\Category\MainCategoryResource_en;
use App\Http\Controllers\API\BaseController as BaseController;

class CategoyController extends BaseController
{
    /**
     * Get Main Category
     */
    public function mainCategory(Request $request)
    {
        $main = Category::where('parent_id',0)->get();
        if($main){
            if($request->lang == 'en'){
                $parentCategories = MainCategoryResource_en::collection(Category::where('parent_id',0)->get());
            }else{
                $parentCategories = MainCategoryResource_ar::collection(Category::where('parent_id',0)->get());
            }
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

    /**
     * Category Parameters
     */

     public function catParam(Request $request){
        $barams = catParameter::select("id","param_name_" .app()->getLocale() . ' as Parameters','type')->where('cat_id',$request->cat_id)->get();
        if($barams){
            return $this->returnData('Parameters', $barams);
        }else{
            $errormessage = __('user.no_params');
            return $this -> returnError('',$errormessage);
        }
     }


     /**
     * Select Category Parameters
     */

    public function selectParams(Request $request){
        $select = selectParams::select("id","param_name_" .app()->getLocale() . ' as param_name')->where('param_id',$request->param_id)->get();
        if($select){
            return $this->returnData('Parameters', $select);
        }else{
            $errormessage = __('user.no_params');
            return $this -> returnError('',$errormessage);
        }
     }

    /**
     * Get Common Questions
     */

    public function commonQuetions(){
        $common = CommonQuestion::select("id","question_" .app()->getLocale() . ' as question', "answer_" .app()->getLocale() . ' as answer')->get();
        if($common){
            return $this->returnData('common questions', $common);
        }else{
            $errormessage = __('user.no_questions');
            return $this -> returnError('',$errormessage);
        }
    }
}
