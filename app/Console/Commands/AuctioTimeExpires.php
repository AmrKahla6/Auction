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
    protected $signature = 'auctio:expires';

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
        $tenders = Tender::where('is_winner',0)->get();
        foreach($tenders as $tender){
            $tender->update([
                'is_winner' => 1,
            ]);
        }
    }
}
