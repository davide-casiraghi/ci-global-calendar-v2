<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['id' => '1', 'country_id' => '1', 'name' => 'Alabama', 'timezone' => '-6:00'],
        ];

        foreach ($regions as $key => $region) {
            DB::table('regions')->insert([
                'id' => $region['id'],
                'country_id' => $region['country_id'],
                'name' => $region['name'],
                'timezone' => $region['timezone'],
            ]);
        }
    }
}


