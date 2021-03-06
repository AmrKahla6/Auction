<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use App\Models\Member;
use App\Models\Auction;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $data['users_count']              = User::count();
        $data['current_auction_count']    = Auction::where('is_finished',0)->count();
        $data['finish_auction_count']     = Auction::where('is_finished',1)->count();
        $data['auctions']                 = Auction::take(3)->get();
        $data['members_comercal_count']   = Member::where('type', 0 )->count();
        $data['members_regular_count']    = Member::where('type', 1 )->count();
        return view('dashboard.index')->with($data);
    }// end of index
}
