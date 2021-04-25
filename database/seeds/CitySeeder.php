<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'city_name_ar'   => "مدينه نصر",
            'city_name_en'   => "Nasr City",
            'governorate_id' =>  1,
        ]);

        DB::table('cities')->insert([
            'city_name_ar'   => "المعادي",
            'city_name_en'   => "Maddi",
            'governorate_id' =>  1,
        ]);

        DB::table('cities')->insert([
            'city_name_ar'   => "المهندسين",
            'city_name_en'   => "EL-Mohandessen",
            'governorate_id' =>  1,
        ]);

        DB::table('cities')->insert([
            'city_name_ar'   => "العجمي",
            'city_name_en'   => "ELagami",
            'governorate_id' =>  2,
        ]);

        DB::table('cities')->insert([
            'city_name_ar'   => "سموحه",
            'city_name_en'   => "Smouha",
            'governorate_id' =>  2,
        ]);

        DB::table('cities')->insert([
            'city_name_ar'   => "المنصوره",
            'city_name_en'   => "Mansoura",
            'governorate_id' =>  3,
        ]);
        DB::table('cities')->insert([
            'city_name_ar'   => "ميت غمر",
            'city_name_en'   => "Mit Ghamr",
            'governorate_id' =>  3,
        ]);
        DB::table('cities')->insert([
            'city_name_ar'   => "طلخا",
            'city_name_en'   => "tahkha",
            'governorate_id' =>  3,
        ]);

    }
}
