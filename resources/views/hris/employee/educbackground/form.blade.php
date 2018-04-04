<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h2>{{$modify == 0 ? "Create" : "Edit"}} Educational Level</h2>
@if(App::find(3)->access()->where("user_id","=",auth::user()->id)->first() != null)
<div class="card">
    <div class="card-header">
        Educational Level Details
    </div>
    <div class="card-body">
        <form action="{{ $modify == 1 ? route('modify_educ_bg',[$emp_id,$ebg_id]) : route('create_educ_bg',[$emp_id]) }}" method="post">
            <div class="form-group">
                <label for="level">Level</label>
                <select class="form-control form-control-sm" name="level" id="level">
                    <option disabled selected value> -- select an option -- </option>
                    @foreach($levels as $lvl)
                    <option value="{{$lvl['description']}}" 
                    @if ($lvl['description'] == old('level', $level))
                        selected="selected"
                    @endif    
                    >{{$lvl['description']}}</option>
                    @endforeach
                </select>
                <small class="form-text text-danger">{{ $errors->first('level') }}</small>
            </div>
            
            <div class="form-group">
                <label for="degree">Degree</label>
                <input type="text" class="form-control form-control-sm" id="degree" name="degree" placeholder="Enter Degree" value="{{ old('degree') ? old('degree') : $degree }}">
                <small class="form-text text-danger">{{ $errors->first('degree') }}</small>
            </div>

            <div class="form-group">
                <label for="school">School</label>
                <input type="text" class="form-control form-control-sm" id="school" name="school" placeholder="Enter School" value="{{ old('school') ? old('school') : $school }}">
                <small class="form-text text-danger">{{ $errors->first('school') }}</small>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Enter Address" value="{{ old('address') ? old('address') : $address }}">
                <small class="form-text text-danger">{{ $errors->first('address') }}</small>
            </div>

            <div class="form-group">
                <label for="graduate_year">Year Graduated</label>
                <input type="text" class="form-control form-control-sm" id="graduate_year" name="graduate_year" placeholder="Enter Year Graduated" value="{{ old('graduate_year') ? old('graduate_year') : $graduate_year }}">
                <small class="form-text text-danger">{{ $errors->first('graduate_year') }}</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Educational Background</button>
            <a href="{{route('educ_bgs',[$emp_id])}}" role="button" class="btn btn-warning">Cancel</a>
        </form>        
    </div>
</div>
@else
<div class="alert alert-danger text-center">
    You do not have access to this module.
</div>
@endif
@endsection