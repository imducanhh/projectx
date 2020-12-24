<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('posts')->insert([
            'title'  => 'Học lập trình Laravel',
            'slug' => 'hoc-lap-trinh-laravel',
            'category_id' => '1',
            'image' => 'santa.jpg',
            'content' => 'Nội dung học bài Todo'
        ]);
    }
}
