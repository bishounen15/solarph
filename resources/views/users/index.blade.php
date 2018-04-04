@extends('layouts.app')

@section('content')
<h1>Users Maintenance</h1>
@if(auth::user()->initialized == 1)
    @if(session('success'))
    <div class="alert alert-success text-center">{{session('success')}}</div>
    @endif
    <table class="table table-sm" id="user-list">
        <thead class="thead-dark">
            <th width="25%">User Name</th>
            <th width="10%">Division</th>
            <th width="20%">Department</th>
            <th width="30%">Email</th>
            <th width="15%">Actions</th>
        </thead>
        <tbody class="tbody-light">
            
        </tbody>
    </table>
@else
    <div class="alert alert-danger text-center">You do not have access to this module.</div>
@endif
@endsection

@push('jscript')
<script>
    $(function() {
        $('#user-list').DataTable({
            // processing: true,
            // serverSide: true,
            "order": [],
            ajax: '{!! route('list_users') !!}',
            // stateSave: true,
            columns: [
                { data: 'user_name' },
                { data: 'division' },
                { data: 'department' },
                { data: 'email' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                           '<button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>' +
                           '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">' +
                           '<small>' +
                           '<a class="dropdown-item" href="/hris/employee/profile/'+full.id+'">Reset Password</a>' +
                           '<a class="dropdown-item" href="/users/access/'+full.id+'">Set User Access</a>' +
                           '</small>' +
                           '</div></div>';
                }
                }
            ],
        });
    });
</script>
@endpush