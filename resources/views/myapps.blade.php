<?php 
    Use App\App as App;
    $app_instance = new App();
    $parent_apps = App::where('parent_id', 0)->get();
?>

@extends('layouts.app')
@section('content')
    @guest
        @include('layouts.notlogged')
    @else
        <h1>My Applications</h1>
            @if (Auth::user()->initialized == 1)
            <div class="card">
                <div class="card-header">
                    System Administration
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="{{route('users')}}"><img class="card-img-top" src="/images/USERMAINT.png" alt="Card image cap"></a>
                            <div class="text-center"><strong>User Maintenance</strong></div>
                        </div>
                        <div class="col-sm-2 text-center">
                            <a href="{{route('apps')}}"><img class="card-img-top" src="/images/APPSMAINT.png" alt="Card image cap"></a>
                            <div class="text-center"><strong>Applications Master</strong></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            @if(count($apps) > 0)
            @foreach($apps as $parent_app)
            <div class="card">
                <div class="card-header">
                    {{$parent_app->app_title}}
                </div>
                <div class="card-body">
                    <div class="row">
                    @foreach($parent_app->children() as $child)
                        @if($child->access()->where("user_id","=",auth::user()->id)->first() != null)
                        <div class="col-sm-2">
                            <a href="{{route($child->app_code)}}"><img class="card-img-top" src="/storage/images/{{$child->app_code}}.png" alt="Card image cap"></a>
                            <div class="text-center"><strong>{{$child->app_title}}</strong></div>
                        </div>
                        @endif
                    @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            @else
                <div class="alert alert-info text-center">
                    <strong>You do not have access to any application.</strong> You can request application access from the IT Administrator.
                </div>
            @endif
    @endguest
@endsection