<?php
    use App\App as App;
?>
@extends('layouts.setup')

@section('title','HRIS Setup')
@section('side-tab')
    <div class="card">
        <div class="card-header">
            System Setup
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="{{route('divisions')}}">Divisions</a></li>
            <li class="list-group-item"><a href="{{route('departments')}}">Departments</a></li>
            <li class="list-group-item active"><strong>Corporate Rank</strong></li>
            <li class="list-group-item"><a href="{{route('position_levels')}}">Position Levels</a></li>
            <li class="list-group-item"><a href="{{route('emp_status')}}">Employment Status</a></li>
            <li class="list-group-item"><a href="{{route('tax_status')}}">Tax Status</a></li>
        </ul>
    </div>
@endsection
@section('main-panel')
    <div class="card">
        <div class="card-header">
            <strong>Corporate Ranks Maintenance</strong>
        </div>
        @if(App::find(2)->access()->where("user_id","=",auth::user()->id)->first() != null)
        <div class="card-body">
            <a href="{{route('new_corporate_rank')}}" role="button" class="btn btn-primary">Add Corporate Rank</a>

            @if(session('fail'))
                <div class="alert-danger text-center">{{session('fail')}}</div>
            @endif

            <table class="table" id="rank-list">
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
        $('#rank-list').DataTable({
            // processing: true,
            // serverSide: true,
            "order": [],
            ajax: '{!! route('list_ranks') !!}',
            columns: [
                { sortable: false, data: 'code' },
                { sortable: false, data: 'description' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="row">' +
                           '<div class="col-sm-8">' + 
                           '<a href="/hris/setup/corpranks/'+full.id+'" role="button" class="btn btn-sm btn-success">Edit</a> ' + 
                           '<a href="/hris/setup/corpranks/changelevel/'+full.id+'/1" role="button" class="btn btn-sm btn-secondary"><i class="fas fa-chevron-circle-up"></i></a> ' +
                           '<a href="/hris/setup/corpranks/changelevel/'+full.id+'/0" role="button" class="btn btn-sm btn-secondary"><i class="fas fa-chevron-circle-down"></i></a>' +
                           '<br><a href="/hris/setup/corpranks/assign/'+full.id+'" role="button" class="btn btn-sm btn-info">Level Assignment</a></div>' +
                           '<div class="col-sm-4"><a href="#" data-href="/hris/setup/corpranks/remove/'+full.id+'" role="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirm-delete" id="'+full.description+'">Remove</a></div>' +
                           '</div>';
                }
                }
            ],
        });
    });
</script>
@endpush