<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h3>Employee Dependents</h3>
<h5>{{ $employee->id_number }} - {{ $employee->getFullName() }}</h5>
@if(App::find(3)->access()->where("user_id","=",auth::user()->id)->first() != null)
<a href="{{route('new_dependent',[$employee->id])}}" role="button" class="btn btn-primary {{ count($dependents) == 4 ? "disabled" : "" }}">Add Dependent</a>
<a href="{{route('PINFO')}}" role="button" class="btn btn-warning">Back to Employee Master</a>
@if(session('success'))
<div class="alert alert-success text-center">{{session('success')}}</div>
@endif
<table class="table table-condensed table-striped">
    <thead class="thead-dark">
        <th width="35%">Name</th>
        <th width="15%">Relation</th>
        <th width="15%">Age</th>
        <th width="15%">Gender</th>
        <th width="20%">Actions</th>
    </thead>
    <tbody class="tbody-light">
        @foreach($dependents as $dependent)
        <tr>
            <td class="align-middle">
                {{$dependent->name}}
            </td>
            <td class="align-middle">
                {{$dependent->relation}}
            </td>
            <td class="align-middle">
                {{$dependent->age()}}
            </td>
            <td class="align-middle">
                {{$dependent->gender}}
            </td>
            <td class="align-middle">
                <div class="row">
                    <div class="col-sm">
                        <a href="{{route('edit_dependent',[$employee->id,$dependent->id])}}" role="button" class="btn btn-sm btn-success">Edit</a>
                    </div>
                    <div class="col-sm">
                        <a href="{{route('remove_dependent',[$employee->id,$dependent->id])}}" role="button" class="btn btn-sm btn-danger">Remove</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-danger text-center">
    You do not have access to this module.
</div>
@endif
@endsection