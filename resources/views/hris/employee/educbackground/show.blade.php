<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h1>Employee Educational Background</h1>
<h3>{{ $employee->id_number }} - {{ $employee->getFullName() }}</h3>
@if(App::find(3)->access()->where("user_id","=",auth::user()->id)->first() != null)
<a href="{{route('new_educ_bg',[$employee->id])}}" role="button" class="btn btn-primary">Add Educational Background</a>
<a href="{{route('PINFO')}}" role="button" class="btn btn-warning">Back to Employee Master</a>
@if(session('success'))
<div class="alert alert-success text-center">{{session('success')}}</div>
@endif
<div class="row">
@foreach($educational_bgs as $educ_bg)
<div class="col-sm-6">
<table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            <th colspan="2" class="text-center">{{$educ_bg->level}}</th>
        </tr>
    </thead>
    <tbody class="tbody-light">
        @if($educ_bg->degree != null)
        <tr>
            <th width="30%">
                Degree
            </th>
            <td width="70%">
                {{$educ_bg->degree}}
            </td>
        </tr>
        @endif
        <tr>
            <th width="30%">
                School
            </th>
            <td width="70%">
                <small>{{$educ_bg->school}}</small>
            </td>
        </tr>
        <tr>
            <th width="30%">
                Address
            </th>
            <td width="70%">
                {{$educ_bg->address}}
            </td>
        </tr>
        <tr>
            <th width="30%">
                Year Graduated
            </th>
            <td width="70%">
                {{$educ_bg->graduate_year}}
            </td>
        </tr>
    </tbody>
    <tfoot class="tfoot-dark">
        <tr class="bg-success">
            <td class="text-center" colspan="2">
                <div class="card">
                    <a href="{{route('edit_educ_bg',[$employee->id,$educ_bg->id])}}" role="button" class="btn btn-sm btn-success">Edit</a>
                </div>
            </td>
        </tr>
        <tr class="bg-danger">
            <td class="text-center" colspan="2">
                <div class="card">
                    <a href="{{route('remove_educ_bg',[$employee->id,$educ_bg->id])}}" role="button" class="btn btn-sm btn-danger">Remove</a>
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