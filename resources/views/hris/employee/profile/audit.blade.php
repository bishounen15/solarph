<?php
    use App\User as User;
    use App\Employee as Employee;
    use App\Division as Division;
    use App\Department as Department;
    use App\CorporateRank as Rank;
    use App\PositionLevel as Level;
    use App\EmploymentStatus as Status;
    use App\TaxStatus as TaxStatus;    
?>
@extends('layouts.app')
@section('content')
<h3>Audit Trail for {{$employee->id_number}} - {{$employee->getFullName()}}</h3>
<a href="{{route('PINFO')}}" role="button" class="btn btn-warning">Back to Employee Master</a>
<div class="card">
    <div class="card-header">
        Audit Details
    </div>
    <div class="card-body">
        @if(count($employee->audits) == 0) 
            <div class="alert alert-info text-center">There are no Audit Logs for this Employee.</div>
        @else
            @foreach($employee->audits as $audit)
            <table class="table table-sm table-bordered">
                <tbody>
                    <tr>
                        <th width="35%">Transaction Date</th>
                        <td width="65%">{{$audit->created_at}}</td>
                    </tr>
                    <tr>
                        <th>Transacted By</th>
                        <td>{{User::find($audit->user_id)->name}}</td>
                    </tr>
                    <tr>
                        <th>Transaction Type</th>
                        <td>{{$audit->event}}</td>
                    </tr>
                    <tr>
                        <th>Details</th>
                        <td>
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30%">Field</th>
                                        <th width="35%">Old Value</th>
                                        <th width="35%">New Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($audit->getModified() as $key => $value)
                                    <?php 
                                        if ($key == "rank_id") {
                                            $myTitle = 'Rank';
                                            $myObject = new Rank();
                                        } elseif ($key == "pos_id") {
                                            $myTitle = 'Position';
                                            $myObject = new Level();
                                        } elseif ($key == "div_id") {
                                            $myTitle = 'Division';
                                            $myObject = new Division();
                                        } elseif ($key == "dep_id") {
                                            $myTitle = 'Department';
                                            $myObject = new Department();
                                        } elseif ($key == "stat_id") {
                                            $myTitle = 'Status';
                                            $myObject = new Status();
                                        } elseif ($key == "tax_id") {
                                            $myTitle = 'Tax Status';
                                            $myObject = new TaxStatus();
                                        } elseif ($key == "sup_id") {
                                            $myTitle = 'Superior';
                                            $myObject = new Employee();
                                        } else {
                                            $myTitle = ucwords(str_replace('_',' ',$key));
                                        }

                                        if (isset($myObject)) {
                                            if ($key == "sup_id") {
                                                $old = $audit->event == 'created' ? null : $myObject->find($value["old"])->getFullName();
                                                $new = $audit->event == 'deleted' ? null : $myObject->find($value["new"])->getFullName();
                                            } else {
                                                $old = $audit->event == 'created' ? null : $myObject->find($value["old"])->description;
                                                $new = $audit->event == 'deleted' ? null : $myObject->find($value["new"])->description;
                                            }

                                            unset($myObject);
                                        } else {
                                            $old = $audit->event == 'created' ? null : $value["old"];
                                            $new = $audit->event == 'deleted' ? null : $value["new"];
                                        }
                                    ?>
                                    @if(($audit->event == "created" && $new != null) || ($audit->event == "deleted" && $old != null) || ($audit->event == "updated"))
                                        <tr>
                                            <td>{{$myTitle}}</td>
                                            <td>{{$old}}</td>
                                            <td>{{$new}}</td>
                                        </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>    
                        </td>
                    </tr>
                </tbody>
            </table>
            @endforeach
        @endif
    </div>
</div>
@endsection