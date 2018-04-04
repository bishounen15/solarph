<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h1>Personnel Information</h1>
@if(App::find(3)->access()->where("user_id","=",auth::user()->id)->first() != null)
<a href="{{route('create_employee')}}" role="button" class="btn btn-primary">Add Employee</a>
@if(session('success'))
<div class="alert alert-success text-center">{{session('success')}}</div>
@endif
<table class="table table-condensed table-striped" id="emp-list">
    <thead class="thead-dark">
        <th width="10%">ID Number</th>
        <th width="20%">Name</th>
        <th width="15%">Position</th>
        <th width="15%">Status</th>
        <th width="15%">Division</th>
        <th width="15%">Department</th>
        <th width="10%">Actions</th>
    </thead>
    <tbody class="tbody-light">
        
    </tbody>
</table>
@else
<div class="alert alert-danger text-center">
    You do not have access to this module.
</div>
@endif
@endsection

@push('jscript')
<script>
    $(function() {
        $('#emp-list').DataTable({
            // processing: true,
            // serverSide: true,
            "order": [],
            ajax: '{!! route('list_employees') !!}',
            stateSave: true,
            columns: [
                { data: 'id_number' },
                { data: 'full_name' },
                { data: 'position' },
                { data: 'status' },
                { data: 'division' },
                { data: 'department' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    if (full.edit_id != 0) { 
                        myBadge = ' <span class="badge badge-danger"> 1 </span>';
                        myLink = '<a class="dropdown-item text-danger" href="/employee/'+full.id+'/update/'+full.edit_id+'"><strong>Update Request' + myBadge + '</strong></a>'; 
                    } else { 
                        myBadge = '';
                        myLink = ''; 
                    }
                    return '<div class="btn-group btn-group-sm" role="group">' +
                           '<button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions'+myBadge+'</button>' +
                           '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">' +
                           '<h5 class="dropdown-header">Profile</h5>' +
                           '<small>' +
                           '<a class="dropdown-item" href="/hris/employee/profile/'+full.id+'">View Profile</a>' + myLink +
                           '<a class="dropdown-item" href="/hris/employee/'+full.id+'">Edit Information</a>' +
                           '<a class="dropdown-item" href="/hris/employee/'+full.id+'/audit">Audit Trail</a>' +
                           '</small>' +
                           '<h5 class="dropdown-header">Additional Info</h5>' +
                           '<small>' +
                           '<a class="dropdown-item" href="/hris/employee/'+full.id+'/dependent">Dependents</a>' +
                           '<a class="dropdown-item" href="/hris/employee/'+full.id+'/educbackground">Educational Background</a>' +
                           '<a class="dropdown-item" href="/hris/employee/'+full.id+'/employhist">Employment History</a>' +
                           '</small></div></div>';
                }
                }
            ],
        });
    });
</script>
@endpush