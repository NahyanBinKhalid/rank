<?php

namespace Database\Seeders;

use App\Models\Engine;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnginesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Engine::insert([
            [
                'title'         =>  'Google',
                'slug'          =>  'google',
                'task_url'      =>  'https://api.dataforseo.com/v3/serp/google/organic/task_post',
                'items_url'     =>  'https://api.dataforseo.com/v3/serp/google/organic/task_get/regular',
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ],
            [
                'title'         =>  'Bing',
                'slug'          =>  'bing',
                'task_url'      =>  'https://api.dataforseo.com/v3/serp/bing/organic/task_post',
                'items_url'     =>  'https://api.dataforseo.com/v3/serp/bing/organic/task_get/regular',
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ],
            [
                'title'         =>  'Yahoo',
                'slug'          =>  'yahoo',
                'task_url'      =>  'https://api.dataforseo.com/v3/serp/yahoo/organic/task_post',
                'items_url'     =>  'https://api.dataforseo.com/v3/serp/yahoo/organic/task_get/regular',
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]
        ]);
    }
}
