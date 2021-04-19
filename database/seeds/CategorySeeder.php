<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'category_name_ar'   => 'سيارات',
            'category_name_en'   => 'Cars',
            'img'                => '1.png',
            'parent_id'          => 0,
        ]);

        DB::table('categories')->insert([
            'category_name_ar'   => 'كاسيت تاتش',
            'category_name_en'   => 'B-SONIC',
            'img'                => '2.png',
            'parent_id'          => 1,
        ]);

        DB::table('categories')->insert([
            'category_name_ar'   => 'شقق',
            'category_name_en'   => 'Apartments',
            'img'                => '3.png',
            'parent_id'          => 0,
        ]);

        DB::table('categories')->insert([
            'category_name_ar'   => 'اوضه نوم',
            'category_name_en'   => 'Sleeping bed',
            'img'                => '4.png',
            'parent_id'          => 3,
        ]);
    }
}
