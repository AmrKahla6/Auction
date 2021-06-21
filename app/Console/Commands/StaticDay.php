<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Auction;
use App\Models\StaticDayOF;
use Illuminate\Console\Command;

class StaticDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:staticDayOf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change End date in auction if day of';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today     = Carbon::now();
        $todayname = Carbon::parse($today)->format('l');
        $stat_days = StaticDayOF::get();
        $auctions  = Auction::where('is_finished', 0)->get();
        foreach($stat_days as $static){
            if($static->day == $todayname){
                foreach ($auctions as  $auction) {
                     $aut_date   =  explode(" ", $auction->end_data)[0];
                     $today_date =  explode(" ", $today )[0];
                    if($today_date < $aut_date){
                        $end_data = date("Y-m-d H:i:s", strtotime('+24 hours', strtotime($auction->end_data)));
                        // $auction->save();
                        $auction->update(array("end_data" => $end_data));
                    }
                }
            }
        }
    }
}
