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

                    {{ Form::open(['route' => [$action, $search->id], 'method' => $method, 'files' => true]) }}

                    <div class="row">

                        <div class="col-5">
                            <div class="form-group">
                                {{ Form::label('keyword', 'Search Keyword') }}
                                {{ Form::text('keyword', $search->keyword, ['id' => 'keyword', 'class' => 'form-control', 'placeholder' => 'Search Keyword']) }}
                                @if($errors->has('keyword'))
                                    <p class="text text-danger">{{ $errors->first('keyword') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-5">
                            <div class="form-group">
                                {{ Form::label('tag', 'Tag') }}
                                {{ Form::text('tag', $search->tag, ['id' => 'tag', 'class' => 'form-control', 'placeholder' => 'Tag (Some String)']) }}
                                @if($errors->has('tag'))
                                    <p class="text text-danger">{{ $errors->first('tag') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                {{ Form::label('iterations', 'Iterations') }}
                                {{ Form::number('iterations', $search->iterations, ['id' => 'iterations', 'class' => 'form-control', 'placeholder' => 'Iterations']) }}
                                @if($errors->has('tag'))
                                    <p class="text text-danger">{{ $errors->first('iterations') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                {{ Form::label('engine_id', 'Select Search Engine') }}
                                {{ Form::select('engine_id', ['' => 'Select Search Engine'] + $engines->toArray(), $search->engine_id, ['id' => 'engine_id', 'class' => 'form-control']) }}
                                @if($errors->has('engine_id'))
                                    <p class="text text-danger">{{ $errors->first('engine_id') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                {{ Form::label('device_type', 'Select Device Type') }}
                                {{ Form::select('device_type', ['' => 'Select Device Type', 'desktop' => 'Desktop', 'mobile' => 'Mobile'], $search->device_type, ['id' => 'device_type', 'class' => 'form-control']) }}
                                @if($errors->has('device_type'))
                                    <p class="text text-danger">{{ $errors->first('device_type') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                {{ Form::label('language_id', 'Select Language') }}
                                {{ Form::select('language_id', ['' => 'Select Language'] + $languages->toArray(), $search->language_id, ['id' => 'language_id', 'class' => 'form-control']) }}
                                @if($errors->has('language_id'))
                                    <p class="text text-danger">{{ $errors->first('language_id') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                {{ Form::label('country_id', 'Select Country') }}
                                {{ Form::select('country_id', ['' => 'Select Country'] + $countries->toArray(), $search->country_id, ['id' => 'country_id', 'class' => 'form-control']) }}
                                @if($errors->has('country_id'))
                                    <p class="text text-danger">{{ $errors->first('country_id') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 text-right mt-20">
                            <button type="submit" class="btn btn-primary">{{ $btn }}</button>
                            <button type="reset" class="btn btn-dark">Reset Fields</button>
                        </div>

                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
