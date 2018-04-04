@extends('layouts.profile')

@section('emp_image')
    @if($employee_info->profile_photo == null)
        <img class="card-img-top" height="250" src="/storage/images/employees/user.jpg" alt="Card image cap">
        {{--  <div class="gavatar">{{substr($employee_info->first_name,0,1)}}{{substr($employee_info->last_name,0,1)}}</div>  --}}
        {{--  <img height="250" avatar="{{$employee_info->first_name}} {{$employee_info->last_name}}">  --}}
    @else
        <img class="card-img-top" height="250" src="/storage/images/employees/{{$employee_info->profile_photo}}" alt="Card image cap">
    @endif
@endsection

@section('emp_id',$employee_info->id_number)

@section('emp_name')
{{--  <a href="{{route('pdf_profile',[$employee_info->id])}}">  --}}
{{$employee_info->getFullName()}}
{{--  </a>  --}}
@endsection

@section('emp_dept', $employee_info->department->description)
@section('emp_post',$employee_info->position)
@section('emp_rank',$employee_info->rank != null ? $employee_info->rank->description : "")
@section('emp_level',$employee_info->level != null ? $employee_info->level->description : "")
@section('emp_status',$employee_info->status->description)

@section('emp_datehired',$employee_info->date_hired)
@section('emp_locker',$employee_info->locker_no)
@section('emp_taxstat',$employee_info->tax_status->description)
@section('emp_sss',$employee_info->sss)
@section('emp_tin',$employee_info->tin)
@section('emp_pagibig',$employee_info->pagibig)
@section('emp_philhealth',$employee_info->philhealth)
@section('emp_prof_license',$employee_info->prof_license)
@section('emp_license_no',$employee_info->license_no)

@section('emp_er_name',$employee_info->emergency_contact)
@section('emp_er_relation',$employee_info->emergency_relation)
@section('emp_er_address',$employee_info->emergency_address)
@section('emp_er_number',$employee_info->emergency_number)

@section('emp_birth_date',$employee_info->birth_date . " (" . $age . " yrs old)")
@section('emp_birth_place',$employee_info->birth_place)
@section('emp_present_address',$employee_info->present_address)
@section('emp_provincial_address',$employee_info->provincial_address)

@section('emp_civil_status',$employee_info->civil_status)
@section('emp_citizenship',$employee_info->citizenship)
@section('emp_gender',$employee_info->gender)
@section('emp_religion',$employee_info->religion)

@section('emp_mobile_personal',$employee_info->mobile_personal)
@section('emp_mobile_work',$employee_info->mobile_work)
@section('emp_email_personal',$employee_info->email_personal)
@section('emp_email_work',$employee_info->email_work)

@section('emp_spouse_name',$employee_info->spouse_name)
@section('emp_father_name',$employee_info->father_name)
@section('emp_mother_name',$employee_info->mother_name)

@section('emp_spouse_occupation',$employee_info->spouse_occupation)
@section('emp_father_occupation',$employee_info->father_occupation)
@section('emp_mother_occupation',$employee_info->mother_occupation)

@section('emp_organization')
    @if($employee_info->sup_id != null)
        <table class="table table-sm">
            <tr>
                <th>Reports to:</th>
                <td>{{$employee_info->superior->id_number}} - {{$employee_info->superior->last_name}}, {{$employee_info->superior->first_name}} {{$employee_info->superior->middle_name}}</td>
            </tr>
            <tr>
                <th>Position</th>
                <td>{{$employee_info->superior->position}}</td>
            </tr>
            <tr>
                <th>Level</th>
                <td>{{$employee_info->level->description}}</td>
            </tr>
        </table>
    @endif
    @if(count($emp_subordinates) > 0)
    <table class="table table-sm">
        <thead>
            <tr class="table-secondary">
                <th colspan="4" class="text-center">Team Members</th>
            </tr>
            <tr class="table-secondary">
                <th width="17%">ID Number</th>
                <th width="43%">Name</th>
                <th width="20%">Position</th>
                <th width="20%">Level</th>
            </tr>
        </thead>
        <tbody>
        @foreach($emp_subordinates as $subordinate)
            <tr>
                <td>{{$subordinate->id_number}}</td>
                <td>{{$subordinate->last_name}}, {{$subordinate->first_name}} {{$subordinate->middle_name}}</td>
                <td>{{$subordinate->position}}</td>
                <td>{{$subordinate->level->description}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
@endsection

@section('emp_dependents')
    <table class="table table-sm">
        <thead>
            <tr class="table-secondary">
                <th width="40%">Name</th>
                <th width="20%">Relationship</th>
                <th width="20%">Gender</th>
                <th width="20%">Age</th>
            </tr>
        </thead>
        <tbody>
        @foreach($emp_dependents as $dependent)
            <tr>
                <td>{{$dependent->name}}</td>
                <td>{{$dependent->relation}}</td>
                <td>{{$dependent->gender}}</td>
                <td>{{$dependent->age()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('emp_educ_bg')
    @foreach($emp_educ_bgs as $educ_bg)
        <table class="table table-bordered table-sm">
            <thead>
                <tr class="table-secondary">
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
        </table>
    @endforeach
@endsection

@section('emp_employ_hist')
@foreach($emp_employ_hists as $emp_hist)
<table class="table table-bordered table-sm">
    <thead>
        <tr class="table-secondary">
            <th colspan="2" class="text-center">{{$emp_hist->company}}</th>
        </tr>
        <tr class="table-secondary">
            <th colspan="2" class="text-center"><small>{{$emp_hist->address}}</small></th>
        </tr>
    </thead>
    <tbody class="tbody-light">
        @if($emp_hist->degree != null)
        <tr>
            <th width="30%">
                Address
            </th>
            <td width="70%">
                {{$emp_hist->address}}
            </td>
        </tr>
        @endif
        <tr>
            <th width="30%">
                Position
            </th>
            <td width="70%">
                <small>{{$emp_hist->position}}</small>
            </td>
        </tr>
        <tr>
            <th width="30%">
                Reason for Leaving
            </th>
            <td width="70%">
                {{$emp_hist->reason}}
            </td>
        </tr>
        <tr>
            <th width="30%">
                Tenure
            </th>
            <td width="70%">
                {{$emp_hist->start}} - {{$emp_hist->end}}
            </td>
        </tr>
        <tr>
            <th width="30%">
                Duties and Responsibilities
            </th>
            <td width="70%">
                {{$emp_hist->duties}}
            </td>
        </tr>
    </tbody>
</table>
@endforeach
@endsection