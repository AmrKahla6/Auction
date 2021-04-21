<?php

use Illuminate\Database\Seeder;

class SelectParamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('select_params')->insert([
            'param_name_ar' => 'شيفروليه',
            'param_name_en' => 'chevrolet',
            'param_id'      => 3,
        ]);

        DB::table('select_params')->insert([
            'param_name_ar' => 'فيات',
            'param_name_en' => 'fiat',
            'param_id'      => 3,
        ]);

        DB::table('select_params')->insert([
            'param_name_ar' => 'دودج',
            'param_name_en' => 'Dodg',
            'param_id'      => 3,
        ]);

        DB::table('select_params')->insert([
            'param_name_ar' => 'احمر',
            'param_name_en' => 'Red',
            'param_id'      => 4,
        ]);

        DB::table('select_params')->insert([
            'param_name_ar' => 'ازرق',
            'param_name_en' => 'Blue',
            'param_id'      => 4,
        ]);
    }
}
