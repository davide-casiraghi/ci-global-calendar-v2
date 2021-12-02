<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContinentsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(RegionTableSeeder::class);
        $this->call(PostCategoriesTableSeeder::class);
        $this->call(EventCategoriesTableSeeder::class);
        $this->call(RolesAndPermissionSeeder::class);
    }
}
