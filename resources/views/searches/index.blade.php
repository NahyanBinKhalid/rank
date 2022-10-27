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

                    <div class="col-12 text-right">
                        <a href="{{ route('searches.create') }}" class="btn btn-success">Add New Search</a>
                    </div>

                    <table class="table table-bordered table-striped mt-20">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Engine</th>
                            <th>Location</th>
                            <th>Language</th>
                            <th>Keyword</th>
                            <th>Tag</th>
                            <th>Device</th>
                            <th>Iterations</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($searches as $key => $search)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>{{ $search->engine->title }}</th>
                                    <th>{{ $search->country->title }}</th>
                                    <th>{{ $search->language->title }}</th>
                                    <th>{{ $search->keyword }}</th>
                                    <th>{{ $search->tag }}</th>
                                    <th>{{ ucfirst($search->device_type) }}</th>
                                    <th>{{ $search->iterations }}</th>
                                    <th>
                                        <a href="{{ route('searches.show', $search->id) }}" class="btn btn-info btn-xs">Detail</a>
{{--                                        <a href="{{ route('searches.destroy', $search->id) }}" class="btn btn-danger btn-mini">Delete</a>--}}
                                    </th>
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
