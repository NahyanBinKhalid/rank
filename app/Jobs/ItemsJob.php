<?php

namespace App\Jobs;

use App\Models\Engine;
use App\Models\Item;
use App\Models\Task;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ItemsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tasks = [];

    private $engine;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $tasks, Engine $engine)
    {
        $this->tasks = $tasks;
        $this->engine = $engine;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = Carbon::now();

        foreach($this->tasks as $key1 => $taskData) {
            $itemsClient = new Client(['verify' => public_path('pem/cert.pem')]);

            $itemsResponse = $itemsClient->request('GET', $this->engine->items_url . '/' . $taskData->task_uuid, [
                'auth' => [
                    env('DATAFORSEO_USERNAME'),
                    env('DATAFORSEO_PASSWORD')
                ]
            ]);

            $itemsResponseData = json_decode($itemsResponse->getBody(), true);

            if($itemsResponseData['tasks_error'] == 0 && $itemsResponseData['status_code'] == 20000 && $itemsResponseData['tasks'][0]['status_code'] == 20000) {
                Task::where('id', '=', $taskData->id)->update([
                    'items_count'           =>  $itemsResponseData['tasks'][0]['result'][0]['items_count'],
                    'engine_results_count'  =>  $itemsResponseData['tasks'][0]['result'][0]['se_results_count'],
                ]);
                $items = $itemsResponseData['tasks'][0]['result'][0]['items'];
                $itemsData = [];
                foreach($items as $key2 => $item) {
                    $itemsData[] = [
                        'task_id'               =>  $taskData->id,
                        'type'                  =>  $item['type'],
                        'rank_group'            =>  $item['rank_group'],
                        'rank_absolute'         =>  $item['rank_absolute'],
                        'title'                 =>  $item['title'],
                        'description'           =>  $item['description'],
                        'domain'                =>  $item['domain'],
                        'url'                   =>  $item['url'],
                        'breadcrumb'            =>  $item['breadcrumb'],
                        'created_at'            =>  $today,
                        'updated_at'            =>  $today
                    ];
                }
                Item::insert($itemsData);
            }
        }
    }
}
