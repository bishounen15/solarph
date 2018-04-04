@extends('layouts.app')
@section('content')
<h2>Edit My Profile</h2>
@if(isset($fail))
<div class="alert alert-danger text-center">{{$fail}}</div>
@endif
<form action="{{route('submit_profile_update')}}" method="post">
    <div class="card">
        <div class="card-header">
            Employee Profile
        </div>
        <div class="card-body">
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
                <div class="form-group col-sm-6">
                    <label for="sss">SSS Number</label>
                    <input type="text" class="form-control form-control-sm" id="sss" name="sss" placeholder="Enter SSS Number" value="{{ old('sss') ? old('sss') : $sss }}">
                    <small class="form-text text-danger">{{ $errors->first('sss') }}</small>
                </div>
    
                <div class="form-group col-sm-6">
                        <label for="tin">TIN Number</label>
                        <input type="text" class="form-control form-control-sm" id="tin" name="tin" placeholder="Enter TIN Number" value="{{ old('tin') ? old('tin') : $tin }}">
                        <small class="form-text text-danger">{{ $errors->first('tin') }}</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="pagibig">PAGIBIG Number</label>
                    <input type="text" class="form-control form-control-sm" id="pagibig" name="pagibig" placeholder="Enter PAGIBIG Number" value="{{ old('pagibig') ? old('pagibig') : $pagibig }}">
                    <small class="form-text text-danger">{{ $errors->first('pagibig') }}</small>
                </div>

                <div class="form-group col-sm-6">
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
        <button type="submit" class="btn btn-primary">Submit Information</button>
        <a href="{{route('myprofile')}}" role="button" class="btn btn-warning">Cancel</a>
    </div>
</form>
@endsection
