<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Jobs\TaskJob;
use App\Models\Country;
use App\Models\Engine;
use App\Models\Item;
use App\Models\Language;
use App\Models\Search;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class SearchesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('searches.index', [
            'title'     =>  'List Searches',
            'searches'  =>  Search::with(['user', 'engine', 'country', 'language'])
                ->where('user_id', '=', Auth::id())
                ->orderBy('id', 'desc')
                ->get()
        ]);
    }

    public function create()
    {
        return view('searches.form', [
            'title'     =>  'Add New Search',
            'btn'       =>  'Add Search',
            'action'    =>  'searches.store',
            'method'    =>  'post',
            'engines'   =>  Engine::select('id', 'title')->pluck('title', 'id'),
            'countries' =>  Country::select('id', 'title')->pluck('title', 'id'),
            'languages' =>  Language::select('id', 'title')->pluck('title', 'id'),
            'search'    =>  new Search()
        ]);
    }

    public function store(SearchRequest $request)
    {
        try {
            $search = new Search();
            $search->fill($request->except('_method', '_token') + ['user_id' => Auth::id()])->save();
            TaskJob::dispatch($search);
            session()->flash('success', 'A New Search Added Successfully');
        } catch (\Exception $exception) {
            session()->flash('warning', (env('APP_ENV') == 'production') ? 'Something went Wrong' : $exception->getMessage());
        }
        return redirect(route('searches.index'));
    }

    public function show($id)
    {
        $search = Search::with([
            'engine',
            'language',
            'country'
        ])
            ->where('user_id', '=', Auth::id())
            ->where('id', '=', $id);

        $tasks = Task::where('search_id', '=', $id)->orderBy('id', 'asc');

        $domains = Item::whereIn('task_id', $tasks->pluck('id'))
            ->select('domain')
            ->groupBy('domain')
            ->get();

        foreach ($domains as $key1 => $domain) {
            $items = [];
            foreach($tasks->pluck('id') as $key2 => $task_id) {
                $item = Item::where('task_id', '=', $task_id)
                    ->where('domain', '=', $domain->domain)
                    ->select('domain', 'rank_group', 'rank_absolute')
                    ->first();
                $items[] = (is_null($item)) ? 0 : $item->rank_group;
            }
            $domains[$key1]->items = $items;
        }

        return view('searches.show', [
            'title'     =>  'Show Search Details',
            'search'    =>  $search->first(),
            'domains'   =>  $domains
        ]);
    }
}
