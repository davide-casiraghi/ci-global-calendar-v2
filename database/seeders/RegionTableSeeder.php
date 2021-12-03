<?php

namespace Database\Seeders;

use App\Models\Region;
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
            [
                'id' => '1',
                'country_id' => '1',
                'name' => 'Alabama',
                //'name_nl' => 'Alabama',
                'timezone' => '-6:00'
            ],
        ];


        collect($regions)->each(function ($region) {
            $created = Region::create($region);
            $created
                ->setTranslation('name', 'nl', 'Naam in het Nederlands')
                ->save();
            


        });
    }
}


