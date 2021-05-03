<?php

use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->insert([
            'title_ar' => "ابدا مزادك ف مكانك",
            'title_en' => "Start your auction in your place",
            'body_ar'  => "ابدا مزادك الالكتروني الان و انت ف مكانك بسهوله",
            'body_en'  => "Start your online auction now while you are at your place easily",
            'img'      => '1.png',
        ]);

        DB::table('sliders')->insert([
            'title_ar' => "اطلع علي المزادات",
            'title_en' => "Check out auctions",
            'body_ar'  => "اشترك بالمزاد الذي تريد",
            'body_en'  => "Subscribe to the auction you want",
            'img'      => '2.png',
        ]);

        DB::table('sliders')->insert([
            'title_ar' => "كن احد الرابحين ",
            'title_en' => "Be one of the winners",
            'body_ar'  => "اشترك بالمزاد الذي تريد",
            'body_en'  => "Subscribe to the auction you want",
            'img'      => '3.png',
        ]);
    }
}
