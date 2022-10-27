<?php

namespace App\Jobs;

use App\Models\Country;
use App\Models\Engine;
use App\Models\Item;
use App\Models\Language;
use App\Models\Task;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Search;
use Illuminate\Support\Facades\Log;

class TaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The podcast instance.
     *
     * @var Search
     */
    private $search;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Search $search)
    {
        $this->search = $search;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $engine = Engine::find($this->search->engine_id);
        $language = Language::find($this->search->language_id);
        $country = Country::find($this->search->country_id);
        $tasksData = [];

        for($i = 0; $i < $this->search->iterations; $i++) {
            $taskClient = new Client(['verify' => public_path('pem/cert.pem')]);

            $taskResponse = $taskClient->request('POST', $engine->task_url, [
                'auth' => [
                    env('DATAFORSEO_USERNAME'),
                    env('DATAFORSEO_PASSWORD')
                ],
                'json' => [
                    [
                        "language_code"     =>  $language->code,
                        "location_code"     =>  $country->code,
                        "keyword"           =>  $this->search->keyword,
                        "device"            =>  $this->search->device_type,
                        "tag"               =>  $this->search->tag,
                        "postback_url"      =>  null,
                        "postback_data"     =>  "advanced"
                    ]
                ]
            ]);

            $taskResponseData = json_decode($taskResponse->getBody(), true);

            if($taskResponseData['tasks_error'] == 0 && $taskResponseData['status_code'] == 20000 && $taskResponseData['tasks'][0]['status_code'] == 20100) {
                $tasksData[] = Task::create([
                    'search_id'             =>  $this->search->id,
                    'task_uuid'             =>  $taskResponseData['tasks'][0]['id'],
                    'task_cost'             =>  $taskResponseData['tasks'][0]['cost'],
                    'search_engine'         =>  $taskResponseData['tasks'][0]['data']['se'],
                    'search_engine_type'    =>  $taskResponseData['tasks'][0]['data']['se_type'],
                    'request_os'            =>  $taskResponseData['tasks'][0]['data']['os']
                ]);
            }
        }

        ItemsJob::dispatch($tasksData, $engine)->delay(Carbon::now()->addMinute(1));
    }
}
