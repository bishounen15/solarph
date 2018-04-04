<?php
    Use App\App as App;
?>
@extends('layouts.app')
@section('content')
<h2>{{$modify == 0 ? "Create" : "Edit"}} Employee</h2>
@if(App::find(3)->access()->where("user_id","=",auth::user()->id)->first() != null)
<form action="{{ $modify == 1 ? route('modify_employee',[$emp_id]) : route('create_employee') }}" method="post" enctype="multipart/form-data">
    <div class="card">
        <div class="card-header">
            Employee Profile
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="id_number">ID Number</label>
                    <input type="text" class="form-control form-control-sm" id="id_number" name="id_number" placeholder="Enter Employee ID Number" value="{{ old('id_number') ? old('id_number') : $id_number }}" {{ $modify == 1 ? "disabled" : "" }}>
                    <small class="form-text text-danger">{{ $errors->first('id_number') }}</small>
                </div>

                <div class="form-group col-sm-4">
                    <label for="date_hired">Date Hired</label>
                    <input type="date" class="form-control form-control-sm" id="date_hired" name="date_hired" value="{{ old('date_hired') ? old('date_hired') : $date_hired }}">
                    <small class="form-text text-danger">{{ $errors->first('date_hired') }}</small>
                </div>

                <div class="form-group col-sm-4">
                    <label for="app_image">Profile Photo</label>
                    <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*">
                    <small class="form-text text-danger">{{ $errors->first('profile_photo') }}</small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="last_name">Last name</label>
                    <input type="text" class="form-control form-control-sm" id="last_name" name="last_name" placeholder="Enter Last Name" value="{{ old('last_name') ? old('last_name') : $last_name }}">
                    <small class="form-text text-danger">{{ $errors->first('last_name') }}</small>
                </div>

                <div class="form-group col-sm-4">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control form-control-sm" id="first_name" name="first_name" placeholder="Enter First Name" value="{{ old('first_name') ? old('first_name') : $first_name }}">
                        <small class="form-text text-danger">{{ $errors->first('first_name') }}</small>
                </div>

                <div class="form-group col-sm-4">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" class="form-control form-control-sm" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="{{ old('middle_name') ? old('middle_name') : $middle_name }}">
                    <small class="form-text text-danger">{{ $errors->first('middle_name') }}</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="div_id">Division</label>
                    <select class="form-control form-control-sm sup-require" name="div_id" id="div_id" {{$modify == 1 ? "disabled" : ""}}>
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
    
                <div class="form-group col-sm-4">
                    <label for="dep_id">Department</label>
                    <select class="form-control form-control-sm sup-require" name="dep_id" id="dep_id" {{$modify == 1 ? "disabled" : ""}}>
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
    
                <div class="form-group col-sm-4">
                    <label for="stat_id">Employment Status</label>
                    <select class="form-control form-control-sm" name="stat_id" id="stat_id" {{$modify == 1 ? "disabled" : ""}}>
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
            </div>   
            
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="rank_id">Corporate Rank</label>
                    <select class="form-control form-control-sm sup-require" name="rank_id" id="rank_id" {{$modify == 1 ? "disabled" : ""}}>
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($ranks as $rank)
                        <option value="{{$rank->id}}" 
                        @if ($rank->id == old('rank_id', $rank_id))
                            selected="selected"
                        @endif    
                        >{{$rank->description}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('rank_id') }}</small>
                </div>

                <div class="form-group col-sm-4">
                    <label for="pos_id">Level</label>
                    <select class="form-control form-control-sm sup-require" name="pos_id" id="pos_id" {{$modify == 1 ? "disabled" : ""}}>
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($pos_levels as $pos_level)
                        <option value="{{$pos_level->id}}" 
                        @if ($pos_level->id == old('pos_id', $pos_id))
                            selected="selected"
                        @endif    
                        >{{$pos_level->description}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('pos_id') }}</small>
                </div>
        
                <div class="form-group col-sm-4">
                    <label for="position">Position</label>
                    <input type="text" class="form-control form-control-sm" id="position" name="position" placeholder="Enter Position" value="{{ old('position') ? old('position') : $position }}">
                    <small class="form-text text-danger">{{ $errors->first('position') }}</small>
                </div>
        
                <div class="form-group col-sm-4">
                    
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="sss">SSS Number</label>
                    <input type="text" class="form-control form-control-sm" id="sss" name="sss" placeholder="Enter SSS Number" value="{{ old('sss') ? old('sss') : $sss }}">
                    <small class="form-text text-danger">{{ $errors->first('sss') }}</small>
                </div>
    
                <div class="form-group col-sm-4">
                        <label for="tin">TIN Number</label>
                        <input type="text" class="form-control form-control-sm" id="tin" name="tin" placeholder="Enter TIN Number" value="{{ old('tin') ? old('tin') : $tin }}">
                        <small class="form-text text-danger">{{ $errors->first('tin') }}</small>
                </div>

                <div class="form-group col-sm-4">
                    <label for="tax_id">Tax Status</label>
                    <select class="form-control form-control-sm" name="tax_id" id="tax_id">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($tax_statuses as $tax_status)
                        <option value="{{$tax_status->id}}" 
                        @if ($tax_status->id == old('tax_id', $tax_id))
                            selected="selected"
                        @endif    
                        >{{$tax_status->description}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('tax_id') }}</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="pagibig">PAGIBIG Number</label>
                    <input type="text" class="form-control form-control-sm" id="pagibig" name="pagibig" placeholder="Enter PAGIBIG Number" value="{{ old('pagibig') ? old('pagibig') : $pagibig }}">
                    <small class="form-text text-danger">{{ $errors->first('pagibig') }}</small>
                </div>

                <div class="form-group col-sm-4">
                    <label for="philhealth">PHILHEALTH Number</label>
                    <input type="text" class="form-control form-control-sm" id="philhealth" name="philhealth" placeholder="Enter PHILHEALTH Number" value="{{ old('philhealth') ? old('philhealth') : $philhealth }}">
                    <small class="form-text text-danger">{{ $errors->first('philhealth') }}</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="prof_license">Professional License</label>
                    <input type="text" class="form-control form-control-sm" id="prof_license" name="prof_license" placeholder="Enter Professional License" value="{{ old('prof_license') ? old('prof_license') : $prof_license }}">
                    <small class="form-text text-danger">{{ $errors->first('prof_license') }}</small>
                </div>

                <div class="form-group col-sm-6">
                    <label for="license_no">License Number</label>
                    <input type="text" class="form-control form-control-sm" id="license_no" name="license_no" placeholder="Enter License Number" value="{{ old('license_no') ? old('license_no') : $license_no }}">
                    <small class="form-text text-danger">{{ $errors->first('license_no') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Organization</div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="emergency_contact">Superior</label>
                    
                    <select class="form-control form-control-sm" name="sup_id" id="sup_id">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($superiors as $superior)
                        <option value="{{$superior->id}}" 
                        @if ($superior->id == old('sup_id', $sup_id))
                            selected="selected"
                        @endif    
                        >{{$superior->id_number}} - {{$superior->last_name}}, {{$superior->first_name}} {{$superior->middle_name}}</option>
                        @endforeach
                    </select>
                    
                    <small class="form-text text-danger">{{ $errors->first('sup_id') }}</small>
                </div>
            
                <div class="form-group col-sm-6">
                    <label for="sup_position">Position</label>
                    <input type="text" class="form-control form-control-sm" id="sup_position" name="sup_position" placeholder="Superior's Position" disabled>
                </div>

                <div class="form-group col-sm-6">
                    <label for="sup_level">Level</label>
                    <input type="text" class="form-control form-control-sm" id="sup_level" name="sup_level" placeholder="Superior's Level" disabled>
                </div>

                <div class="form-group col-sm-6">
                    <label for="sup_email">Email</label>
                    <input type="text" class="form-control form-control-sm" id="sup_email" name="sup_email" placeholder="Superior's Email" disabled>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Emergency Contact Information</div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="emergency_contact">Person to contact in case of Emergency</label>
                    <input type="text" class="form-control form-control-sm" id="emergency_contact" name="emergency_contact" placeholder="Enter Emergency Contact" value="{{ old('emergency_contact') ? old('emergency_contact') : $emergency_contact }}">
                    <small class="form-text text-danger">{{ $errors->first('emergency_contact') }}</small>
                </div>
            
                <div class="form-group col-sm-6">
                    <label for="emergency_relation">Relation</label>
                    <input type="text" class="form-control form-control-sm" id="emergency_relation" name="emergency_relation" placeholder="Enter Relation" value="{{ old('emergency_relation') ? old('emergency_relation') : $emergency_relation }}">
                    <small class="form-text text-danger">{{ $errors->first('emergency_relation') }}</small>
                </div>

                <div class="form-group col-sm-6">
                    <label for="emergency_address">Address</label>
                    <input type="text" class="form-control form-control-sm" id="emergency_address" name="emergency_address" placeholder="Enter Address" value="{{ old('emergency_address') ? old('emergency_address') : $emergency_address }}">
                    <small class="form-text text-danger">{{ $errors->first('emergency_address') }}</small>
                </div>
    
                <div class="form-group col-sm-6">
                    <label for="emergency_number">Contact Number</label>
                    <input type="text" class="form-control form-control-sm" id="emergency_number" name="emergency_number" placeholder="Enter Contact Number" value="{{ old('emergency_number') ? old('emergency_number') : $emergency_number }}">
                    <small class="form-text text-danger">{{ $errors->first('emergency_number') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Personal Information</div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="birth_date">Birth Date</label>
                    <input type="date" class="form-control form-control-sm" id="birth_date" name="birth_date" value="{{ old('birth_date') ? old('birth_date') : $birth_date }}">
                    <small class="form-text text-danger">{{ $errors->first('birth_date') }}</small>
                </div>
            
                <div class="form-group col-sm-6">
                    <label for="birth_place">Birth Place</label>
                    <input type="text" class="form-control form-control-sm" id="birth_place" name="birth_place" placeholder="Enter Birth Place" value="{{ old('birth_place') ? old('birth_place') : $birth_place }}">
                    <small class="form-text text-danger">{{ $errors->first('birth_place') }}</small>
                </div>
            </div>

            <div class="form-group">
                <label for="present_address">Present Address</label>
                <input type="text" class="form-control form-control-sm" id="present_address" name="present_address" placeholder="Enter Present Address" value="{{ old('present_address') ? old('present_address') : $present_address }}">
                <small class="form-text text-danger">{{ $errors->first('present_address') }}</small>
            </div>

            <div class="form-group">
                <label for="provincial_address">Provincial Address</label>
                <input type="text" class="form-control form-control-sm" id="provincial_address" name="provincial_address" placeholder="Enter Provincial Address" value="{{ old('provincial_address') ? old('provincial_address') : $provincial_address }}">
                <small class="form-text text-danger">{{ $errors->first('provincial_address') }}</small>
            </div>

            <div class="form-row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="mobile_personal">Personal Mobile Number</label>
                        <input type="text" class="form-control form-control-sm" id="mobile_personal" name="mobile_personal" placeholder="Enter Mobile Number" value="{{ old('mobile_personal') ? old('mobile_personal') : $mobile_personal }}">
                        <small class="form-text text-danger">{{ $errors->first('mobile_personal') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="mobile_work">Work Mobile Number</label>
                        <input type="text" class="form-control form-control-sm" id="mobile_work" name="mobile_work" placeholder="Enter Mobile Number" value="{{ old('mobile_work') ? old('mobile_work') : $mobile_work }}">
                        <small class="form-text text-danger">{{ $errors->first('mobile_work') }}</small>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email_personal">Personal Email Address</label>
                        <input type="text" class="form-control form-control-sm" id="email_personal" name="email_personal" placeholder="Enter Email Address" value="{{ old('email_personal') ? old('email_personal') : $email_personal }}">
                        <small class="form-text text-danger">{{ $errors->first('email_personal') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="email_work">Work Email Address</label>
                        <input type="text" class="form-control form-control-sm" id="email_work" name="email_work" placeholder="Enter Email Address" value="{{ old('email_work') ? old('email_work') : $email_work }}">
                        <small class="form-text text-danger">{{ $errors->first('email_work') }}</small>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-3">
                    <label for="gender">Gender</label>
                    <select class="form-control form-control-sm" name="gender" id="gender">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($genders as $gendr)
                        <option value="{{$gendr}}" 
                        @if ($gendr == old('gender', $gender))
                            selected="selected"
                        @endif    
                        >{{$gendr}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('gender') }}</small>
                </div>
                
                <div class="form-group col-sm-3">
                    <label for="civil_status">Civil Status</label>
                    <select class="form-control form-control-sm" name="civil_status" id="civil_status">
                        <option disabled selected value> -- select an option -- </option>
                        @foreach($civil_statuses as $civil_stat)
                        <option value="{{$civil_stat}}" 
                        @if ($civil_stat == old('civil_status', $civil_status))
                            selected="selected"
                        @endif    
                        >{{$civil_stat}}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ $errors->first('civil_status') }}</small>
                </div>
    
                <div class="form-group col-sm-3">
                    <label for="citizenship">Citizenship</label>
                    <input type="text" class="form-control form-control-sm" id="citizenship" name="citizenship" placeholder="Enter Citizenship" value="{{ old('citizenship') ? old('citizenship') : $citizenship }}">
                    <small class="form-text text-danger">{{ $errors->first('citizenship') }}</small>
                </div>
    
                <div class="form-group col-sm-3">
                    <label for="religion">Religion</label>
                    <input type="text" class="form-control form-control-sm" id="religion" name="religion" placeholder="Enter Religion" value="{{ old('religion') ? old('religion') : $religion }}">
                    <small class="form-text text-danger">{{ $errors->first('religion') }}</small>
                </div>
            </div>

            <div class="form-row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="spouse_name">Spouse's Name</label>
                        <input type="text" class="form-control form-control-sm" id="spouse_name" name="spouse_name" placeholder="Enter Name" value="{{ old('spouse_name') ? old('spouse_name') : $spouse_name }}">
                        <small class="form-text text-danger">{{ $errors->first('spouse_name') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="spouse_occupation">Spouse's Occupation</label>
                        <input type="text" class="form-control form-control-sm" id="spouse_occupation" name="spouse_occupation" placeholder="Enter Occupation" value="{{ old('spouse_occupation') ? old('spouse_occupation') : $spouse_occupation }}">
                        <small class="form-text text-danger">{{ $errors->first('spouse_occupation') }}</small>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="father_name">Father's Name</label>
                        <input type="text" class="form-control form-control-sm" id="father_name" name="father_name" placeholder="Enter Name" value="{{ old('father_name') ? old('father_name') : $father_name }}">
                        <small class="form-text text-danger">{{ $errors->first('father_name') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="father_occupation">Father's Occupation</label>
                        <input type="text" class="form-control form-control-sm" id="father_occupation" name="father_occupation" placeholder="Enter Occupation" value="{{ old('father_occupation') ? old('father_occupation') : $father_occupation }}">
                        <small class="form-text text-danger">{{ $errors->first('father_occupation') }}</small>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="mother_name">Mother's Name</label>
                        <input type="text" class="form-control form-control-sm" id="mother_name" name="mother_name" placeholder="Enter Name" value="{{ old('mother_name') ? old('mother_name') : $mother_name }}">
                        <small class="form-text text-danger">{{ $errors->first('mother_name') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="mother_occupation">Mother's Occupation</label>
                        <input type="text" class="form-control form-control-sm" id="mother_occupation" name="mother_occupation" placeholder="Enter Occupation" value="{{ old('mother_occupation') ? old('mother_occupation') : $mother_occupation }}">
                        <small class="form-text text-danger">{{ $errors->first('mother_occupation') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <button type="submit" class="btn btn-primary">Save Employee</button>
        <a href="{{route('PINFO')}}" role="button" class="btn btn-warning">Cancel</a>
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

    function getLevels(rank_id, level_id = 0) {
        $.get('/hris/employee/getlevels/' + rank_id, function(data) {
            $('#pos_id').empty();
            $('#pos_id').append('<option disabled selected value> -- select an option -- </option>');
            $.each(data, function(index,level){
                if (level_id == level.id) { selected = 'selected="selected"'; } else { selected = ''; }
                $('#pos_id').append('<option value="'+level.id+'" '+selected+'>'+level.description+'</option>');
            });
        });
    }

    function getQualifiedSuperiors(div_id, dep_id, pos_id) {
        $('#sup_id').empty();
        $('#sup_id').append('<option disabled selected value> -- select an option -- </option>');

        if (div_id != null && dep_id != null && pos_id != null) {
            $.get('/hris/employee/getsup/' + div_id + '/' + dep_id + '/' + pos_id, function(data) {
                $.each(data, function(index,sup){
                    $('#sup_id').append('<option value="'+sup.id+'">'+sup.id_number+' - '+sup.last_name+', '+sup.first_name+' '+sup.middle_name+'</option>');
                });
            });
        }
    }

    $("#sup_id").change(function() {
        $.get('/hris/employee/supinfo/' + $(this).val(), function(data) {
            $("#sup_position").val(data.position);
            $("#sup_level").val(data.level);
            $("#sup_email").val(data.email);
        });
    });
    
    $('#div_id').change(function(e){
        getDepartments(e.target.value);
    });

    $('#rank_id').change(function(e){
        getLevels(e.target.value);
    });

    $('.sup-require').change(function(){
        getQualifiedSuperiors($("#div_id").val(),$("#dep_id").val(),$("#pos_id").val());
    });   
</script>
@endpush