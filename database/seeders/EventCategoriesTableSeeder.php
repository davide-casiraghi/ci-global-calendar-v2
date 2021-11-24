<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event_categories = [
            ['name' => 'Regular Jam'],
            ['name' => 'Class'],
            ['name' => 'Workshop'],
            ['name' => 'Festival'],
            ['name' => 'Special Jam'],
            ['name' => 'Underscore'],
            ['name' => 'Teachers Meeting'],
            ['name' => 'Performance'],
            ['name' => 'Lecture / Conference / Film'],
            ['name' => 'Lab'],
            ['name' => 'Camp / Journey'],
            ['name' => 'Other event'],
        ];

        // Seeding in this way to automatically create the slug with spatie/laravel-sluggable
        collect($event_categories)->each(function ($event_category) {
            EventCategory::create($event_category);
        });

    }
}
