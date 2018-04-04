<?php
    Use App\DeptLink as DeptLink;
    Use App\App as App;
?>
@extends('layouts.setup')

@section('title','HRIS Setup')
@section('side-tab')
    <div class="card">
        <div class="card-header">
            System Setup
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item active"><strong>Divisions</strong></li>
            <li class="list-group-item"><a href="{{route('departments')}}">Departments</a></li>
            <li class="list-group-item"><a href="{{route('corporate_ranks')}}">Corporate Rank</a></li>
            <li class="list-group-item"><a href="{{route('position_levels')}}">Position Level</a></li>
            <li class="list-group-item"><a href="{{route('emp_status')}}">Employment Status</a></li>
            <li class="list-group-item"><a href="{{route('tax_status')}}">Tax Status</a></li>
        </ul>
    </div>
@endsection
@section('main-panel')
    <div class="card">
        <div class="card-header">
            <strong>Divisions Maintenance</strong>
        </div>
        @if(App::find(2)->access()->where("user_id","=",auth::user()->id)->first() != null)
        <div class="card-body">
            <a href="{{route('new_division')}}" role="button" class="btn btn-primary">Add Division</a>
            
            @if(session('fail'))
                <div class="alert-danger text-center">{{session('fail')}}</div>
            @endif

            <table class="table" id="div-list">
                <thead class="thead-dark">
                    <tr>
                        <th width="20%">Code</th>
                        <th width="45%">Description</th>
                        <th width="35%">Actions</th>
                    </tr>
                </thead>
                <tbody class="tbody-light">
                    
                </tbody>
            </table>
        </div>
        @else
            <div class="alert alert-danger text-center">
                You do not have access to this module.
            </div>
        @endif
    </div>
@endsection

@push('jscript')
<script>
    $(function() {
        $('#div-list').DataTable({
            // processing: true,
            // serverSide: true,
            ajax: '{!! route('list_divisions') !!}',
            columns: [
                { data: 'code' },
                { data: 'description' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row"><div class="col-sm"><a href="/hris/setup/divisions/'+full.id+'" role="button" class="btn btn-sm btn-success">Edit</a></div>' +
                           '<div class="col-sm"><a href="#" data-href="/hris/setup/divisions/remove/'+full.id+'" role="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'">Remove</a></div></div>';
                }
                }
            ],
        });
    });
</script>
@endpush