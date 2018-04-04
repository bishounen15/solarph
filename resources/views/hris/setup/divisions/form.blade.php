<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h2>{{$modify == 0 ? "Create" : "Edit"}} Division</h2>
@if(App::find(2)->access()->where("user_id","=",auth::user()->id)->first() != null)
<div class="card">
    <div class="card-header">
        Division Details
    </div>
    <div class="card-body">
        <form action="{{ $modify == 1 ? route('modify_division',[$div_id]) : route('create_division') }}" method="post">
            <div class="form-group">
                <label for="code">Division Code</label>
            <input type="text" class="form-control" id="code" name="code" placeholder="Enter Division Code" value="{{ old('code') ? old('code') : $code }}" {{ $modify == 1 ? "disabled" : "" }}>
                <small class="form-text text-danger">{{ $errors->first('code') }}</small>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ old('description') ? old('description') : $description }}">
                <small class="form-text text-danger">{{ $errors->first('description') }}</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Division</button>
            <a href="{{route('divisions')}}" role="button" class="btn btn-warning">Cancel</a>
        </form>        
    </div>
</div>
@else
<div class="alert alert-danger text-center">
    You do not have access to this module.
</div>
@endif
@endsection