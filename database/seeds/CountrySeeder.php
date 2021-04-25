<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'country_name_ar' => "مصر",
            'country_name_en' => "Egypt",
        ]);

        DB::table('countries')->insert([
            'country_name_ar' => "الكويت",
            'country_name_en' => "Kuwait",
        ]);
    }
}
