<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h2>{{$modify == 0 ? "Create" : "Edit"}} Employment History</h2>
@if(App::find(3)->access()->where("user_id","=",auth::user()->id)->first() != null)
<div class="card">
    <div class="card-header">
        Employment History Details
    </div>
    <div class="card-body">
        <form action="{{ $modify == 1 ? route('modify_emp_hist',[$emp_id,$ehist_id]) : route('create_emp_hist',[$emp_id]) }}" method="post">
            <div class="form-group">
                <label for="company">Company</label>
                <input type="text" class="form-control form-control-sm" id="company" name="company" placeholder="Enter Company" value="{{ old('company') ? old('company') : $company }}">
                <small class="form-text text-danger">{{ $errors->first('company') }}</small>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Enter Address" value="{{ old('address') ? old('address') : $address }}">
                <small class="form-text text-danger">{{ $errors->first('address') }}</small>
            </div>

            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" class="form-control form-control-sm" id="position" name="position" placeholder="Enter Position" value="{{ old('position') ? old('position') : $position }}">
                <small class="form-text text-danger">{{ $errors->first('position') }}</small>
            </div>

            <div class="form-group">
                <label for="start">Start Date</label>
                <input type="date" class="form-control form-control-sm" id="start" name="start" value="{{ old('start') ? old('start') : $start }}">
                <small class="form-text text-danger">{{ $errors->first('start') }}</small>
            </div>

            <div class="form-group">
                <label for="end">End Date</label>
                <input type="date" class="form-control form-control-sm" id="end" name="end" value="{{ old('end') ? old('end') : $end }}">
                <small class="form-text text-danger">{{ $errors->first('end') }}</small>
            </div>

            <div class="form-group">
                <label for="reason">Reason for Leaving</label>
                <input type="text" class="form-control form-control-sm" id="reason" name="reason" placeholder="Enter Reason" value="{{ old('reason') ? old('reason') : $reason }}">
                <small class="form-text text-danger">{{ $errors->first('reason') }}</small>
            </div>

            <div class="form-group">
                <label for="duties">Duties and Responsibilities</label>
                <textarea class="form-control" rows="3" id="duties" name="duties" placeholder="Enter Duties and Responsibilities">{{ old('duties') ? old('duties') : $duties }}</textarea>
                <small class="form-text text-danger">{{ $errors->first('duties') }}</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Employment History</button>
            <a href="{{route('emp_hist',[$emp_id])}}" role="button" class="btn btn-warning">Cancel</a>
        </form>        
    </div>
</div>
@else
<div class="alert alert-danger text-center">
    You do not have access to this module.
</div>
@endif
@endsection