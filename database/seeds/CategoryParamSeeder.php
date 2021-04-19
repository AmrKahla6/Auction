<?php

use App\Models\catParameter;
use Illuminate\Database\Seeder;

class CategoryParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        catParameter::create([
            'param_name_ar'  => 'الاسم',
            'param_name_en'  => 'name',
            'type'           => '1',
            'cat_id'         => '1',
        ]);

        catParameter::create([
            'param_name_ar'  => 'التفاصيل',
            'param_name_en'  => 'Desc',
            'type'           => '1',
            'cat_id'         => '1',
        ]);

        catParameter::create([
            'param_name_ar'  => 'الموديل',
            'param_name_en'  => 'Model',
            'type'           => '2',
            'cat_id'         => '1',
        ]);

        catParameter::create([
            'param_name_ar'  => 'اللون',
            'param_name_en'  => 'Color',
            'type'           => '2',
            'cat_id'         => '1',
        ]);

        catParameter::create([
            'param_name_ar'  => 'المساحه',
            'param_name_en'  => 'space',
            'type'           => '2',
            'cat_id'         => '3',
        ]);

        catParameter::create([
            'param_name_ar'  => 'الدور',
            'param_name_en'  => 'floor',
            'type'           => '2',
            'cat_id'         => '3',
        ]);
    }
}
