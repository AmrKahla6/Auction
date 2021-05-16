<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
         $this->call(UserTableSeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(CommonQuestionsSeeder::class);
         $this->call(TermsSeeder::class);
         $this->call(AboutSeeder::class);
         $this->call(CategoryParamSeeder::class);
         $this->call(AuctionTypesSeeder::class);
         $this->call(SelectParamsSeeder::class);
         $this->call(CountrySeeder::class);
         $this->call(GovernorateSeeder::class);
         $this->call(CitySeeder::class);
         $this->call(SliderSeeder::class);
         $this->call(AdvertisementSeeder::class);
         $this->call(PrivcySeeder::class);
    }
}
