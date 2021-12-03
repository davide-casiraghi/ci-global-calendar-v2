<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

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
                'languages' => [
                    'nl' => 'Alabama NL',
                ],
                'timezone' => '-6:00'
            ],
        ];

        collect($regions)->each(function ($region) {
            $languages = $region['languages'];
            unset($region['languages']);
            $created = Region::create($region);
            foreach ($languages as $language => $name){
                $created
                    ->setTranslation('name', $language, $name);
            }
            $created->save();
        });

    }

}


