@extends('layouts.app')
@section('content')
<h3>Update Request from {{$update_details->employee->id_number}} - {{$update_details->employee->getFullName()}}</h3>
<a href="{{route('PINFO')}}" role="button" class="btn btn-warning">Back to Employee Master</a>
<div class="card">
    <div class="card-header">
        Request Details
    </div>
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <tbody>
                <tr>
                    <th width="35%">Requisition Date</th>
                    <td width="65%">{{$update_details->created_at}}</td>
                </tr>
                <tr>
                    <th>Update Details</th>
                    <td>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="30%">Field</th>
                                    <th width="35%">Current Value</th>
                                    <th width="35%">New Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($update_details->editable_columns as $column)
                                @if($update_details->$column != null)
                                <tr>
                                    <td>{{ucwords(str_replace('_',' ',$column))}}</td>
                                    <td>{{$update_details->employee->$column}}</td>
                                    <td>{{$update_details->$column}}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>    
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <a href="#" role="button" class="btn btn-success" data-toggle="modal" data-target="#confirm-apply">Apply Updates</a>
    <a href="#" role="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-decline">Decline Updates</a>
</div>

<form action="{{route('apply_profile_update')}}" method="POST">
<div class="modal fade" id="confirm-apply" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Apply Updates</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="update_id" name="update_id" value="{{$update_details->id}}">
            <p>Do you really want to apply the requested update(s)?</p>
        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-success btn-yes" value="Apply">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
    </div>
</div>
</form>

<form action="{{route('decline_profile_update')}}" method="POST">
<div class="modal fade" id="confirm-decline" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Decline Updates</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="update_id" name="update_id" value="{{$update_details->id}}">
            <p>Do you really want to decline the requested update(s)?</p>
            <div class="form-group">
                <label for="remarks">Enter reason:</label>
                <textarea class="form-control" rows="3" id="remarks" name="remarks" placeholder="Enter Remarks" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-danger btn-yes" value="Decline">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
    </div>
</div>
</form>
@endsection