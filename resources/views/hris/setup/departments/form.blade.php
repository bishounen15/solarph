<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h2>{{$modify == 0 ? "Create" : "Edit"}} Department</h2>
<div class="card">
    <div class="card-header">
        Department Details
    </div>
    @if(App::find(2)->access()->where("user_id","=",auth::user()->id)->first() != null)
    <div class="card-body">
        <form action="{{ $modify == 1 ? route('modify_department',[$dep_id]) : route('create_department') }}" method="post">
            <div class="form-group">
                <label for="code">Department Code</label>
            <input type="text" class="form-control" id="code" name="code" placeholder="Enter Department Code" value="{{ old('code') ? old('code') : $code }}" {{ $modify == 1 ? "disabled" : "" }}>
                <small class="form-text text-danger">{{ $errors->first('code') }}</small>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ old('description') ? old('description') : $description }}">
                <small class="form-text text-danger">{{ $errors->first('description') }}</small>
            </div>

            <div class="form-group">
                <label>Availability</label>
                @foreach($divisions as $division)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="selected_divisions[]" value="{{$division->id}}" 
                    @if ($modify == 1 && $dep_data->associated($division->id) > 0)
                    checked
                    @endif
                    >
                    <label class="form-check-label" for="defaultCheck1">
                        {{$division->code}} - {{$division->description}}
                    </label>
                </div>
                @endforeach
            </div>
            
            <button type="submit" class="btn btn-primary">Save Department</button>
            <a href="{{route('departments')}}" role="button" class="btn btn-warning">Cancel</a>
        </form>        
    </div>
</div>
@else
<div class="alert alert-danger text-center">
    You do not have access to this module.
</div>
@endif
@endsection