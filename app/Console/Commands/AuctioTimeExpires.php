<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tender;
use Illuminate\Console\Command;

class AuctioTimeExpires extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'When end_data is expires the hight price won the auction automaticly';

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
        $date = new Carbon;
        $auctions = Auction::with(['tenders'=> function($qu){
            $qu->orderBy('price','desc');
        }])->where('end_data','<',  Carbon::now()->format('Y-m-d'))->where('is_finished',0)->get();

        foreach ($auctions as $auction) {
             $tender = $auction->tenders->first();


            $tender->update(['is_winner' => 1]);
        }
    }
}
