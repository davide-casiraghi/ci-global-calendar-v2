<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post_categories = [
            ['name' => 'Calendar Articles'],
            ['name' => 'Blog'],
        ];

        // Seeding in this way to automatically create the slug with spatie/laravel-sluggable
        collect($post_categories)->each(function ($post_category) {
            PostCategory::create($post_category);
        });
    }
}
