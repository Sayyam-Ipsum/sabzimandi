@extends('templates.index')

@section('page-title')
    Dashboard
@stop

@section('title')
    dashboard
@stop

@section('content')
    <div id="container" class="shadow border border-muted">
    </div>
    <div class="row p-2">
        <div id="pie-chart" class="col-md-6 shadow border border-muted">

        </div>
        <div id="line-chart" class="col-md-6 shadow border border-muted">

        </div>
    </div>
@stop

@section('scripts')
    <script>
        BarChart();
        PieChart();
        LineChart();
    </script>
@stop
