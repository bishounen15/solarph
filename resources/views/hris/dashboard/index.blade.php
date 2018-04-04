<?php
    Use App\App as App;
?>
@extends('layouts.app')

@section('content')
    <h3>HRIS Dashboard</h3>
    @if(App::find(4)->access()->where("user_id","=",auth::user()->id)->first() != null)
    <div class="row">
        @foreach($charts as $chart)
        <div class="{{count($chart->labels) > 8 ? "col-sm-12" : "col-sm-6"}}">
            <div class="card">
                <div class="card-body">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-danger text-center">
        You do not have access to this module.
    </div>
    @endif

<script src=//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js charset=utf-8></script>
{{--  <script src=//cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js charset=utf-8></script>  --}}
@foreach($charts as $chart)
{!! $chart->script() !!}
@endforeach
@endsection