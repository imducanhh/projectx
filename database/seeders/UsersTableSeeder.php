<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name'  => 'Nguyễn Đức Anh',
            'email' => 'imducanhh@gmail.com',
            'avatar' => 'santa.jpg',
            'password' => bcrypt('Ducanh7991@@')
        ]);
    }
}
