<?php

use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertisements')->insert([
            'link'     => "https://www.google.com/",
            'img'      => '1.png',
        ]);

        DB::table('advertisements')->insert([
            'link'     => "https://www.facebook.com/",
            'img'      => '2.png',
        ]);

        DB::table('advertisements')->insert([
            'link'     => "https://twitter.com/home",
            'img'      => '3.png',
        ]);

    }
}
