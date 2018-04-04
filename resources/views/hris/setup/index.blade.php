<?php
    use App\App as App;
?>
@extends('layouts.setup')
@section('title','HRIS Setup')
@section('side-tab')
    @if(App::find(2)->access()->where("user_id","=",auth::user()->id)->first() != null)
    <div class="card">
        <div class="card-header">
            System Setup
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="{{route('divisions')}}">Divisions</a></li>
            <li class="list-group-item"><a href="{{route('departments')}}">Departments</a></li>
            <li class="list-group-item"><a href="{{route('corporate_ranks')}}">Corporate Rank</a></li>
            <li class="list-group-item"><a href="{{route('position_levels')}}">Position Level</a></li>
            <li class="list-group-item"><a href="{{route('emp_status')}}">Employment Status</a></li>
            <li class="list-group-item"><a href="{{route('tax_status')}}">Tax Status</a></li>
        </ul>
    </div>
    @else
        <div class="alert alert-danger text-center">
            You do not have access to this module.
        </div>
    @endif
@endsection
@section('main-panel')
    <div class="jumbotron">
        <h1 class="display-4">Welcome to HR Setup.</h1>
        <hr class="my-4">
        <p class="lead">
            Select an item from the list on the left to start managing the setup items required for HRIS System.
        </p>
        {{--  <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
        </p>  --}}
    </div>    
@endsection