<?php

namespace Database\Seeders;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '450M');
        $json = File::get('database/data/locations.json');
        $locations = json_decode($json);
        $countries = [];
        foreach ($locations->locations as $key => $location) {
            if(strtolower($location->location_type) == 'country') {
                $countries[] = [
                    'title'         =>  $location->location_name,
                    'code'          =>  $location->location_code,
                    'iso_code'      =>  $location->country_iso_code,
                    'created_at'    =>  Carbon::now(),
                    'updated_at'    =>  Carbon::now()
                ];
            }
        }
        Country::insert($countries);
    }
}
