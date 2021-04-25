<?php

use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('governorates')->insert([
            'governorate_name_ar' => "القاهره",
            'governorate_name_en' => "Cairo",
            'country_id'          => 1,
        ]);

        DB::table('governorates')->insert([
            'governorate_name_ar' => "الاسكندريه",
            'governorate_name_en' => "Alex",
            'country_id'          => 1,
        ]);

        DB::table('governorates')->insert([
            'governorate_name_ar' => "الدقهيليه",
            'governorate_name_en' => "Dakahlia",
            'country_id'          => 1,
        ]);
    }
}
