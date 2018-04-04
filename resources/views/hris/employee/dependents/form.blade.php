<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h2>{{$modify == 0 ? "Create" : "Edit"}} Dependent</h2>
@if(App::find(3)->access()->where("user_id","=",auth::user()->id)->first() != null)
<div class="card">
    <div class="card-header">
        Dependent Details
    </div>
    <div class="card-body">
        <form action="{{ $modify == 1 ? route('modify_dependent',[$emp_id,$dep_id]) : route('create_dependent',[$emp_id]) }}" method="post">
            <div class="form-group">
                <label for="name">Dependent's Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Enter Name" value="{{ old('name') ? old('name') : $name }}">
                <small class="form-text text-danger">{{ $errors->first('name') }}</small>
            </div>

            <div class="form-group">
                <label for="relation">Relation</label>
                <select class="form-control form-control-sm" name="relation" id="relation">
                    <option disabled selected value> -- select an option -- </option>
                    @foreach($relations as $relatn)
                    <option value="{{$relatn['description']}}" 
                    @if ($relatn['description'] == old('relation', $relation))
                        selected="selected"
                    @endif    
                    >{{$relatn['description']}}</option>
                    @endforeach
                </select>
                <small class="form-text text-danger">{{ $errors->first('relation') }}</small>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control form-control-sm" name="gender" id="gender">
                    <option disabled selected value> -- select an option -- </option>
                    @foreach($genders as $gendr)
                    <option value="{{$gendr}}" 
                    @if ($gendr == old('gender', $gender))
                        selected="selected"
                    @endif    
                    >{{$gendr}}</option>
                    @endforeach
                </select>
                <small class="form-text text-danger">{{ $errors->first('gender') }}</small>
            </div>

            <div class="form-group">
                <label for="birth_date">Birth Date</label>
                <input type="date" class="form-control form-control-sm" id="birth_date" name="birth_date" value="{{ old('birth_date') ? old('birth_date') : $birth_date }}">
                <small class="form-text text-danger">{{ $errors->first('birth_date') }}</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Dependent</button>
            <a href="{{route('dependents',[$emp_id])}}" role="button" class="btn btn-warning">Cancel</a>
        </form>        
    </div>
</div>
@else
<div class="alert alert-danger text-center">
    You do not have access to this module.
</div>
@endif
@endsection