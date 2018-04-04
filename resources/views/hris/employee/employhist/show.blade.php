<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h1>Employee Employment History</h1>
<h3>{{ $employee->id_number }} - {{ $employee->getFullName() }}</h3>
@if(App::find(3)->access()->where("user_id","=",auth::user()->id)->first() != null)
<a href="{{route('new_emp_hist',[$employee->id])}}" role="button" class="btn btn-primary">Add Employment History</a>
<a href="{{route('PINFO')}}" role="button" class="btn btn-warning">Back to Employee Master</a>
@if(session('success'))
<div class="alert alert-success text-center">{{session('success')}}</div>
@endif
<div class="row">
@foreach($employment_hist as $emp_hist)
<div class="col-sm-6">
<table class="table table-bordered table-sm">
    <thead class="thead-dark">
        <tr>
            <th colspan="2" class="text-center">{{$emp_hist->company}}</th>
        </tr>
        <tr>
            <th colspan="2" class="text-center"><small>{{$emp_hist->address}}</small></th>
        </tr>
    </thead>
    <tbody class="tbody-light">
        @if($emp_hist->degree != null)
        <tr>
            <th width="30%">
                Address
            </th>
            <td width="70%">
                {{$emp_hist->address}}
            </td>
        </tr>
        @endif
        <tr>
            <th width="30%">
                Position
            </th>
            <td width="70%">
                <small>{{$emp_hist->position}}</small>
            </td>
        </tr>
        <tr>
            <th width="30%">
                Reason for Leaving
            </th>
            <td width="70%">
                {{$emp_hist->reason}}
            </td>
        </tr>
        <tr>
            <th width="30%">
                Tenure
            </th>
            <td width="70%">
                {{$emp_hist->start}} - {{$emp_hist->end}}
            </td>
        </tr>
        <tr>
            <th width="30%">
                Duties and Responsibilities
            </th>
            <td width="70%">
                {{$emp_hist->duties}}
            </td>
        </tr>
    </tbody>
    <tfoot class="tfoot-dark">
        <tr class="bg-success">
            <td class="text-center" colspan="2">
                <div class="card">
                    <a href="{{route('edit_emp_hist',[$employee->id,$emp_hist->id])}}" role="button" class="btn btn-sm btn-success">Edit</a>
                </div>
            </td>
        </tr>
        <tr class="bg-danger">
            <td class="text-center" colspan="2">
                <div class="card">
                    <a href="{{route('remove_emp_hist',[$employee->id,$emp_hist->id])}}" role="button" class="btn btn-sm btn-danger">Remove</a>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
</div>
@endforeach
</div>
@else
<div class="alert alert-danger text-center">
    You do not have access to this module.
</div>
@endif
@endsection