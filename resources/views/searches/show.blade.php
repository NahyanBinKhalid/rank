@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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

                    <figure class="highcharts-figure">
                        <div id="rank-chart"></div>
                    </figure>

                    <h4>Domain Ranking with Iteration</h4>
                    <table class="table table-sm table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Domains</th>
                            <th colspan="{{ $search->iterations }}">Ranking</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($domains as $key1 => $domain)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ $domain->domain }}" target="_blank">{{ $domain->domain }}</a></td>
                                    @foreach($domain->items as $key2 => $item)
                                        <td>{{ $item }}</td>
                                    @endforeach
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css.highcharts.css') }}">
@endpush

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        $(document).ready(function () {
            var indexes = [];
            var series = [];
            @foreach($domains as $key1 => $domain)
                @php $totalIterations = $loop->count; @endphp
                indexes.push({{ $loop->iteration }});

                var items = [];
                @foreach($domain->items as $key2 => $item)
                    items.push({{ $item }});
                @endforeach

                var domain = {
                    name: '{{$domain->domain}}',
                    data: items
                };

                series.push(domain);
            @endforeach
            Highcharts.chart('rank-chart', {
                chart: {
                    height: 1200,
                    type: 'line'
                },

                title: {
                    text: 'SEO Rank Chart [ Keyword: {{ $search->keyword }} ] [ Tag: {{ $search->tag }} ]'
                },

                subtitle: {
                    text: 'Source: <a href="dataforseo.com" target="_blank">Data For SEO</a>'
                },

                yAxis: {
                    title: {
                        text: 'Rank'
                    }
                },

                xAxis: {
                    accessibility: {
                        rangeDescription: 'Range: 1 to {{ $totalIterations }}'
                    }
                },


                plotOptions: {
                    series: indexes
                },

                series: series,

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 1290
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }

            });
        });
    </script>
@endpush
