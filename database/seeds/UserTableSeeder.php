<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'       => 'super admin',
            'email'      => 'super_admin@app.com',
            'password'   => bcrypt('123456'),
            'image'      => 'default.png',
        ]);
        $user->attachRole('super_admin');
    }
}
