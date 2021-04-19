<?php

namespace App\Http\Controllers\API;

use App\Models\AuctionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;

class AuctionController extends BaseController
{
    public function auctionType(){
        $type = AuctionType::select("id","type_name_" .app()->getLocale() . ' as Acution Type')->get();
        if($type){
            return $this->returnData('Acution Type', $type);
        }
    }
}
