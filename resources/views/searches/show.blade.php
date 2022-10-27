@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $title }}</div>

                <div class="card-body">
                    @include('includes.alerts')

{{--                    {{ dd($search->tasks) }}--}}
                    <h4>Search Detail</h4>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Keyword</th>
                            <td>{{ $search->keyword }}</td>
                            <th>Tag</th>
                            <td>{{ $search->tag }}</td>
                        </tr>
                        <tr>
                            <th>No. of Search Iterations</th>
                            <td>{{ $search->iterations }}</td>
                            <th>Device Type</th>
                            <td>{{ ucfirst($search->device_type) }}</td>
                        </tr>
                        <tr>
                            <th>Search Engine</th>
                            <td colspan="3">{{ $search->engine->title }}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{ $search->country->title }}</td>
                            <th>Language</th>
                            <td>{{ ucfirst($search->language->title) }}</td>
                        </tr>
                    </table>

                    <h4>Task List / Detail</h4>
                    <table class="table table-sm table-bordered">
                        <thead>
                        <tr>
                            <th>UUID</th>
                            <th>Cost</th>
                            <th>OS</th>
                            <th>Items</th>
                            <th>Total Results</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($search->tasks as $key1 => $task)
                                <tr>
                                    <td>{{ $task->task_uuid }}</td>
                                    <td>{{ $task->task_cost }}</td>
                                    <td>{{ $task->request_os }}</td>
                                    <td>{{ $task->items_count }}</td>
                                    <td>{{ $task->engine_results_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
