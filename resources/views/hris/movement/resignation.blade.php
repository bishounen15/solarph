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
        <a class="nav-link transaction" id="employee-transfer" href="{{route('emp_transfer')}}">Employee Transfer</a>
    </li>
    <li class="nav-item">
        <a class="nav-link transaction" id="promotion" href="{{route('emp_promote')}}">Employee Promotion</a>
    </li>
    <li class="nav-item">
        <a class="nav-link transaction active" id="resignation" href="{{route('emp_resign')}}">Resignation / Termination</a>
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
<form action="{{route('resign_employee')}}" method="POST">
<div class="row">
    <div class="col-sm-4 trx-panel" id="resignation">
        <div class="card">
            <div class="card-header">
                Resignation Details
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="stat_id">Employment Status</label>
                    <select class="form-control form-control-sm" name="stat_id" id="stat_id">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($emp_statuses as $emp_status)
                        <option value="{{$emp_status->id}}" 
                        @if ($emp_status->id == old('stat_id', $stat_id))
                            selected="selected"
                        @endif    
                        >{{$emp_status->description}}</option>
                        @endforeach  
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('stat_id') }}</small>
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
                    { data: 'full_name' },
                    { data: 'position' },
                    { data: 'description' }
                ],
            });
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