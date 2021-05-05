<?php

use Illuminate\Database\Seeder;

class PrivcySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('privicies')->insert([
            'privcy_en' => Str::random(100),
            'privcy_ar' => "​الخصوصية وبيان سريّة
            لم نقم بتصميم هذا الموقع من أجل تجميع بياناتك الشخصية من جهاز الكمبيوتر الخاص بك أثناء تصفحك لهذا الموقع, وإنما سيتم فقط استخدام البيانات المقدمة من قبلك بمعرفتك ومحض إرادت",
        ]);
    }
}
