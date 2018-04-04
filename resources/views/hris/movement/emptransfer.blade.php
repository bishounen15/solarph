<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h1>Employee Movement</h1>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link transaction" id="regularization" href="{{route('EMPMOVE')}}">Regularization</a>
    </li>
    <li class="nav-item">
        <a class="nav-link transaction active" id="employee-transfer" href="{{route('emp_transfer')}}">Employee Transfer</a>
    </li>
    <li class="nav-item">
        <a class="nav-link transaction" id="promotion" href="{{route('emp_promote')}}">Employee Promotion</a>
    </li>
    <li class="nav-item">
        <a class="nav-link transaction" id="resignation" href="{{route('emp_resign')}}">Resignation / Termination</a>
    </li>
</ul>
<br>
@if(App::find(4)->access()->where("user_id","=",auth::user()->id)->first() != null)
@if(isset($fail))
<div class="alert alert-danger text-center">{{$fail}}</div>
@endif
@if(session('success'))
<div class="alert alert-success text-center">{{session('success')}}</div>
@endif
<form action="{{route('transfer_employee')}}" method="POST">
<div class="row">
    <div class="col-sm-4 trx-panel" id="employee-transfer">
        
        <div class="card">
            <div class="card-header">
                Transfer Details
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="div_id">Division</label>
                    <select class="form-control form-control-sm sup-require" name="div_id" id="div_id">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($divisions as $division)
                        <option value="{{$division->id}}" 
                        @if ($division->id == old('div_id', $div_id))
                            selected="selected"
                        @endif    
                        >{{$division->code}}</option>
                        @endforeach  
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('div_id') }}</small>
                </div>
    
                <div class="form-group">
                    <label for="dep_id">Department</label>
                    <select class="form-control form-control-sm sup-require" name="dep_id" id="dep_id">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($departments as $department)
                        <option value="{{$department->id}}" 
                        @if ($department->id == old('dep_id', $dep_id))
                            selected="selected"
                        @endif    
                        >{{$department->description}}</option>
                        @endforeach 
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('dep_id') }}</small>
                </div>

                <div class="form-group">
                    <label for="effectivity">Effectivity Date</label>
                    <input type="date" class="form-control form-control-sm" id="effectivity" name="effectivity" value="{{ old('effectivity') ? old('effectivity') : $effectivity }}">
                    <small class="form-text text-danger">{{ $errors->first('effectivity') }}</small>
                </div>

                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" rows="3" id="remarks" name="remarks" placeholder="Enter Description">{{ old('remarks') ? old('remarks') : $remarks }}</textarea>
                    <small class="form-text text-danger">{{ $errors->first('remarks') }}</small>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" value="Apply Changes" class="btn btn-success">
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">
                Select Employees
            </div>
            <div class="card-body">
                <table class="table table-sm" id="emp-list">
                    <thead class="thead-dark">
                        <th>Select</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        {{--  <th>Select</th>  --}}
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
</form>
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
                ajax: '{!! route('list_active') !!}',
                columns: [
                    { sortable: false, "render": function ( data, type, full, meta ) {
                        return '<div class="text-center"><input type="checkbox" class="form-control" name="selected_employees[]" value="'+full.id+'"></div>';
                    }
                    },
                    { data: 'full_name', name: 'employees.last_name' },
                    { data: 'position', name: 'employees.position' },
                    { data: 'description', name: 'departments.description' },
                ],
            });
        });

        function getDepartments(div_id, dep_id = 0) {
            $.get('/hris/employee/getdept/' + div_id, function(data) {
                $('#dep_id').empty();
                $('#dep_id').append('<option disabled selected value> -- select an option -- </option>');
                $.each(data, function(index,dept){
                    if (dep_id == dept.id) { selected = 'selected="selected"'; } else { selected = ''; }
                    $('#dep_id').append('<option value="'+dept.id+'" '+selected+'>'+dept.description+'</option>');
                });
            });
        }

        $('#div_id').change(function(e){
            getDepartments(e.target.value);
        });

        $(document).ready(function() {
            $('.transaction').each(function(){
                if ($(this).hasClass("active")) {
                    $(this).attr("href","#");
                }
            });
        });
    </script>
@endpush