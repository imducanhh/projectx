<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->insert([
            'name'  => 'Selenium',
            'slug' => 'selenium',
            'image' => 'santa.jpg',
            'content' => 'Nội dung về selenium'
        ]);
    }
}
