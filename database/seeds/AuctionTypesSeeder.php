<?php

use App\Models\AuctionType;
use Illuminate\Database\Seeder;

class AuctionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AuctionType::create([
            'type_name_ar'  => 'عرض حالا',
            'type_name_en'  => 'Sell now',
        ]);

        AuctionType::create([
            'type_name_ar'  => 'عرض مؤجل',
            'type_name_en'  => 'Deferred sale',
        ]);

        AuctionType::create([
            'type_name_ar'  => 'عرض لاعلي سعر',
            'type_name_en'  => 'Sell for the highest price',
        ]);
    }
}
