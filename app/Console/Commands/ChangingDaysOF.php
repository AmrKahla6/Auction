<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\DaysOF;
use App\Models\Auction;
use Illuminate\Console\Command;

class ChangingDaysOF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:ChangingDaysOF';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cahange auction end date if day off';

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
        $today       = Carbon::now();
        $today_date  = explode(" ", $today)[0];
        $auctions    = Auction::where('is_finished', 0)->get();
        $days        = DaysOF::get();
        foreach($days as $day){
            if($day->days_of == $today_date){
                foreach ($auctions as  $auction) {
                    $aut_date   =  explode(" ", $auction->end_data)[0];
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
