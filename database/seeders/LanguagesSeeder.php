<?php

namespace Database\Seeders;

use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/languages.json');
        $languages = json_decode($json);
        $languagesData = [];
        foreach ($languages->languages as $key => $language) {
            $languagesData[] = [
                'title'         =>  $language->language_name,
                'code'          =>  $language->language_code,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ];
        }
        Language::insert($languagesData);
    }
}
