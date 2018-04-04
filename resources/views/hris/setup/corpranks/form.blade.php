<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h2>{{$modify == 0 ? "Create" : "Edit"}} Corporate Rank</h2>
<div class="card">
    <div class="card-header">
        Corporate Rank Details
    </div>
    @if(App::find(2)->access()->where("user_id","=",auth::user()->id)->first() != null)
    <div class="card-body">
        <form action="{{ $modify == 1 ? route('modify_corporate_rank',[$rank_id]) : route('create_corporate_rank') }}" method="post">
            <div class="form-group">
                <label for="code">Corporate Rank Code</label>
                <input type="text" class="form-control" id="code" name="code" placeholder="Enter Corporate Rank Code" value="{{ old('code') ? old('code') : $code }}" {{ $modify == 1 ? "disabled" : "" }}>
                <small class="form-text text-danger">{{ $errors->first('code') }}</small>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ old('description') ? old('description') : $description }}">
                <small class="form-text text-danger">{{ $errors->first('description') }}</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Corporate Rank</button>
            <a href="{{route('corporate_ranks')}}" role="button" class="btn btn-warning">Cancel</a>
        </form>        
    </div>
    @else
    <div class="alert alert-danger text-center">
        You do not have access to this module.
    </div>
    @endif
</div>
@endsection