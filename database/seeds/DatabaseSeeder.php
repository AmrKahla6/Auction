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
        // $this->call(UsersTableSeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(CommonQuestionsSeeder::class);
         $this->call(TermsSeeder::class);
         $this->call(AboutSeeder::class);
         $this->call(CategoryParamSeeder::class);
         $this->call(AuctionTypesSeeder::class);
         $this->call(SelectParamsSeeder::class);
         $this->call(GovernorateSeeder::class);
    }
}
