@extends('layouts.app')
@section('content')
    @if(session('success'))
    <div class="alert alert-success text-center">{{session('success')}}</div>
    @endif
    <div class="row">
        <div class="col-sm-4">
            <div class="card" style="width: 18rem;">
                @yield('emp_image')
                <div class="card-body">
                    <h5 class="card-title text-center">
                        @yield('emp_id') <br>
                        <strong>@yield('emp_name')</strong> <br>
                    </h5>
                    @if(!isset($emp_id))
                    <div class="card">
                        <a href="{{route('edit_profile')}}" role="button" class="btn btn-warning btn-sm">Edit My Profile</a>
                    </div>
                    @endif
                    <table class="table table-sm">
                        <tr>
                            <td width="40%"><small><strong>Department</strong></small></th>
                            <td width="60%"><small>@yield('emp_dept')</small></td>
                        </tr>
                        <tr>
                            <td width="40%"><small><strong>Position</strong></small></th>
                            <td width="60%"><small>@yield('emp_post')</small></td>
                        </tr>
                        <tr>
                            <td width="40%"><small><strong>Rank</strong></small></th>
                            <td width="60%"><small>@yield('emp_rank')</small></td>
                        </tr>
                        <tr>
                            <td width="40%"><small><strong>Level</strong></small></th>
                            <td width="60%"><small>@yield('emp_level')</small></td>
                        </tr>
                        <tr>
                            <td width="40%"><small><strong>Status</strong></small></th>
                            <td width="60%"><small>@yield('emp_status')</small></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    Employee Profile
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        {{--  <tr>
                            <th width="40%"></th>
                            <td width="60%">@yield('emp_')</td>
                        </tr>  --}}
                        <tr>
                            <th width="40%">Date Hired</th>
                            <td width="60%">@yield('emp_datehired')</td>
                        </tr>
                        <tr>
                            <th width="40%">Locker No.</th>
                            <td width="60%">@yield('emp_locker')</td>
                        </tr>
                        <tr>
                            <th width="40%">Tax Status</th>
                            <td width="60%">@yield('emp_taxstat')</td>
                        </tr>
                        <tr>
                            <th width="40%">SSS Number</th>
                            <td width="60%">@yield('emp_sss')</td>
                        </tr>
                        <tr>
                            <th width="40%">TIN Number</th>
                            <td width="60%">@yield('emp_tin')</td>
                        </tr>
                        <tr>
                            <th width="40%">PAGIBIG Number</th>
                            <td width="60%">@yield('emp_pagibig')</td>
                        </tr>
                        <tr>
                            <th width="40%">PHILHEALTH Number</th>
                            <td width="60%">@yield('emp_philhealth')</td>
                        </tr>
                        <tr>
                            <th width="40%">Professional License</th>
                            <td width="60%">@yield('emp_prof_license')</td>
                        </tr>
                        <tr>
                            <th width="40%">License Number</th>
                            <td width="60%">@yield('emp_license_no')</td>
                        </tr>
                    </table>

                    <table class="table table-sm">
                        <thead>
                            <tr class="table-secondary"><th colspan="2" class="text-center">Emergency Contact Information</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="40%">Name</th>
                                <td width="60%">@yield('emp_er_name')</td>
                            </tr>
                            <tr>
                                <th width="40%">Relation</th>
                                <td width="60%">@yield('emp_er_relation')</td>
                            </tr>
                            <tr>
                                <th width="40%">Address</th>
                                <td width="60%"><small>@yield('emp_er_address')</small></td>
                            </tr>
                            <tr>
                                <th width="40%">Contact Number</th>
                                <td width="60%">@yield('emp_er_number')</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Personal Information
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">Birth Date</th>
                            <td width="60%">@yield('emp_birth_date')</td>
                        </tr>
                        <tr>
                            <th width="40%">Birth Place</th>
                            <td width="60%">@yield('emp_birth_place')</td>
                        </tr>
                        <tr>
                            <th width="40%">Present Address</th>
                            <td width="60%"><small>@yield('emp_present_address')</small></td>
                        </tr>
                        <tr>
                            <th width="40%">Provincial Address</th>
                            <td width="60%"><small>@yield('emp_provincial_address')</small></td>
                        </tr>
                        <tr>
                            <th width="40%">Civil Status</th>
                            <td width="60%">@yield('emp_civil_status')</td>
                        </tr>
                        <tr>
                            <th width="40%">Citizenship</th>
                            <td width="60%">@yield('emp_citizenship')</td>
                        </tr>
                        <tr>
                            <th width="40%">Gender</th>
                            <td width="60%">@yield('emp_gender')</td>
                        </tr>
                        <tr>
                            <th width="40%">Religion</th>
                            <td width="60%">@yield('emp_religion')</td>
                        </tr>
                    </table>

                    <table class="table table-sm">
                        <thead>
                            <tr class="table-secondary">
                                <th colspan="5" class="text-center">Contact Information</th>
                            </tr>
                            <tr class="table-secondary">
                                <th width="30%"> </th>
                                <th width="35%" colspan="2" class="text-center">Mobile</th>
                                <th width="35%" colspan="2" class="text-center">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Personal</th>
                                <td colspan="2" class="text-center">@yield('emp_mobile_personal')</td>
                                <td colspan="2" class="text-center"><small>@yield('emp_email_personal')</small></td>
                            </tr>
                            <tr>
                                <th>Work</th>
                                <td colspan="2" class="text-center">@yield('emp_mobile_work')</td>
                                <td colspan="2" class="text-center"><small>@yield('emp_email_work')</small></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-sm">
                        <thead>
                            <tr class="table-secondary"><th colspan="2" class="text-center">Spouse Information</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="40%">Name</th>
                                <td width="60%">@yield('emp_spouse_name')</td>
                            </tr>
                            <tr>
                                <th width="40%">Occupation</th>
                                <td width="60%">@yield('emp_spouse_occupation')</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-sm">
                        <thead>
                            <tr class="table-secondary"><th colspan="2" class="text-center">Father Information</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="40%">Name</th>
                                <td width="60%">@yield('emp_father_name')</td>
                            </tr>
                            <tr>
                                <th width="40%">Occupation</th>
                                <td width="60%">@yield('emp_father_occupation')</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-sm">
                        <thead>
                            <tr class="table-secondary"><th colspan="2" class="text-center">Mother Information</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="40%">Name</th>
                                <td width="60%">@yield('emp_mother_name')</td>
                            </tr>
                            <tr>
                                <th width="40%">Occupation</th>
                                <td width="60%">@yield('emp_mother_occupation')</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                    <div class="card-header">
                        Organization
                    </div>
                    <div class="card-body">@yield('emp_organization')</div>
                </div>
            <div class="card">
                <div class="card-header">
                    Dependents
                </div>
                <div class="card-body">@yield('emp_dependents')</div>
            </div>
            <div class="card">
                <div class="card-header">
                    Educational Background
                </div>
                <div class="card-body">@yield('emp_educ_bg')</div>
            </div>
            <div class="card">
                <div class="card-header">
                    Employment History
                </div>
                <div class="card-body">@yield('emp_employ_hist')</div>
            </div>
        </div>
    </div>
@endsection