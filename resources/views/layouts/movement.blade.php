@extends('layouts.app')
@section('content')
<h1>Employee Movement</h1>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link transaction{{$reg}}" id="regularization" href="{{route('EMPMOVE')}}">Regularization</a>
    </li>
    <li class="nav-item">
        <a class="nav-link transaction{{$trn}}" id="employee-transfer" href="{{route('emp_transfer')}}">Employee Transfer</a>
    </li>
    <li class="nav-item">
        <a class="nav-link transaction{{$prm}}" id="promotion" href="{{route('emp_promote')}}">Employee Promotion</a>
    </li>
    <li class="nav-item">
        <a class="nav-link transaction{{$rsg}}" id="resignation" href="{{route('emp_resign')}}">Resignation / Termination</a>
    </li>
</ul>
<br>
<div class="row">
    <div class="col-sm-7">
        <div class="card">
            <div class="card-header">
                Select Employees
            </div>
            <div class="card-body">
                <table class="table table-sm" id="emp-list">
                    <thead class="thead-dark">
                        <th>-</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Select</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-5 trx-panel" id="regularization">
        <form action="#" method="POST">
        <div class="card">
            <div class="card-header">
                Regularization Details
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="status_date">Regularization Date</label>
                    <input type="date" class="form-control form-control-sm" id="status_date" name="status_date" value="{{-- old('status_date') ? old('status_date') : $status_date --}}">
                    <small class="form-text text-danger">{{-- $errors->first('status_date') --}}</small>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" rows="3" id="remarks" name="remarks" placeholder="Enter Description">{{-- old('remarks') ? old('remarks') : $remarks --}}</textarea>
                    <small class="form-text text-danger">{{-- $errors->first('remarks') --}}</small>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" value="Apply Changes" class="btn btn-success">
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@push('jscript')
<script>
    $(function() {
        $('#emp-list').DataTable({
            // processing: true,
            // serverSide: true,
            ajax: '{!! route('list_probi') !!}',
            columns: [
                { data: 'id', name: 'employees.id' },
                { data: 'full_name', name: 'employees.last_name' },
                { data: 'position', name: 'employees.position' },
                { data: 'description', name: 'departments.description' },
                { sortable: false, "render": function ( data, type, full, meta ) {
                    return '<div class="text-center"><input type="checkbox" class="form-control" name="selected_users[]" value="'+full.id+'"></div>';
                }
                }
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