<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserEdit as UserEdit;
use App\Gender as Gender;
use App\CivilStatus as CivilStatus;

class UserEditsController extends Controller
{
    //
    public function __construct( Gender $genders, CivilStatus $civil_status, UserEdit $user_edit )
    {
        $this->gender = $genders->all();
        $this->civil_stat = $civil_status->all();
        $this->user_edit = $user_edit->all();
    }

    public function editProfile() {
        $data = [];

        $emp_data = auth::user()->information;

        $data['genders'] = $this->gender;
        $data['civil_statuses'] = $this->civil_stat;
        
        $data['last_name'] = $emp_data->last_name;
        $data['first_name'] = $emp_data->first_name;
        $data['middle_name'] = $emp_data->middle_name;
        $data['locker_no'] = $emp_data->locker_no;
        $data['sss'] = $emp_data->sss;
        $data['tin'] = $emp_data->tin;
        $data['pagibig'] = $emp_data->pagibig;
        $data['philhealth'] = $emp_data->philhealth;
        $data['prof_license'] = $emp_data->prof_license;
        $data['license_no'] = $emp_data->license_no;
        $data['emergency_contact'] = $emp_data->emergency_contact;
        $data['emergency_relation'] = $emp_data->emergency_relation;
        $data['emergency_address'] = $emp_data->emergency_address;
        $data['emergency_number'] = $emp_data->emergency_number;
        $data['birth_date'] = $emp_data->birth_date;
        $data['birth_place'] = $emp_data->birth_place;
        $data['present_address'] = $emp_data->present_address;
        $data['provincial_address'] = $emp_data->provincial_address;
        $data['mobile_personal'] = $emp_data->mobile_personal;
        $data['mobile_work'] = $emp_data->mobile_work;
        $data['email_personal'] = $emp_data->email_personal;
        $data['email_work'] = $emp_data->email_work;
        $data['civil_status'] = $emp_data->civil_status;
        $data['citizenship'] = $emp_data->citizenship;
        $data['gender'] = $emp_data->gender;
        $data['spouse_name'] = $emp_data->spouse_name;
        $data['spouse_occupation'] = $emp_data->spouse_occupation;
        $data['father_name'] = $emp_data->father_name;
        $data['father_occupation'] = $emp_data->father_occupation;
        $data['mother_name'] = $emp_data->mother_name;
        $data['mother_occupation'] = $emp_data->mother_occupation;
        $data['religion'] = $emp_data->religion;
        
        return view('users.edit.form', $data);
    }

    public function submitProfile(Request $request, UserEdit $user_edit) {
        $emp_data = new UserEdit();
        $data = [];

        $data['last_name'] = $request->input('last_name');
        $data['first_name'] = $request->input('first_name');
        $data['middle_name'] = $request->input('middle_name');
        $data['locker_no'] = $request->input('locker_no');
        $data['sss'] = $request->input('sss');
        $data['tin'] = $request->input('tin');
        $data['pagibig'] = $request->input('pagibig');
        $data['philhealth'] = $request->input('philhealth');
        $data['prof_license'] = $request->input('prof_license');
        $data['license_no'] = $request->input('license_no');
        $data['emergency_contact'] = $request->input('emergency_contact');
        $data['emergency_relation'] = $request->input('emergency_relation');
        $data['emergency_address'] = $request->input('emergency_address');
        $data['emergency_number'] = $request->input('emergency_number');
        $data['birth_date'] = $request->input('birth_date');
        $data['birth_place'] = $request->input('birth_place');
        $data['present_address'] = $request->input('present_address');
        $data['provincial_address'] = $request->input('provincial_address');
        $data['mobile_personal'] = $request->input('mobile_personal');
        $data['mobile_work'] = $request->input('mobile_work');
        $data['email_personal'] = $request->input('email_personal');
        $data['email_work'] = $request->input('email_work');
        $data['civil_status'] = $request->input('civil_status');
        $data['citizenship'] = $request->input('citizenship');
        $data['gender'] = $request->input('gender');
        $data['spouse_name'] = $request->input('spouse_name');
        $data['spouse_occupation'] = $request->input('spouse_occupation');
        $data['father_name'] = $request->input('father_name');
        $data['father_occupation'] = $request->input('father_occupation') == Auth::user()->information->father_occupation ? null : $request->input('father_occupation');
        $data['mother_name'] = $request->input('mother_name');
        $data['mother_occupation'] = $request->input('mother_occupation');
        $data['religion'] = $request->input('religion');
        
        $fields = '';
        $nulls = 0;
        $myInfo = json_decode(Auth::user()->information);

        foreach ($data as $key => $value) {
            if ($fields == '') {
                $fields .= $key;
            } else {
                $fields .= ','.$key;
            }
            if ($value == $myInfo->$key) { $nulls++; }
        }

        $addl = 'required_without_all:'.$fields;

        if ($request->isMethod('post')) {
            if ($nulls == count($data)) {
                $data['genders'] = $this->gender;
                $data['civil_statuses'] = $this->civil_stat;
                return view('users.edit.form',$data)->with("fail",'Aleast one (1) field must be updated to submit.');
            } else {
                $this->validate($request, [
                    'last_name' => $addl . '|nullable|max:35',
                    'first_name' => $addl . '|nullable|max:35',
                    'middle_name' => $addl . '|nullable|max:35',
                    'locker_no' => $addl . '|nullable|max:20',
                    'sss' => $addl . '|nullable|max:20',
                    'tin' => $addl . '|nullable|max:20',
                    'pagibig' => $addl . '|nullable|max:20',
                    'philhealth' => $addl . '|nullable|max:20',
                    'prof_license' => $addl . '|nullable|max:35',
                    'license_no' => $addl . '|nullable|max:25',
                    'emergency_contact' => $addl . '|nullable|max:35',
                    'emergency_relation' => $addl . '|nullable|max:15',
                    'emergency_address' => $addl . '|nullable|max:150',
                    'emergency_number' => $addl . '|nullable|max:50',
                    'birth_date' => $addl . '|nullable',
                    'birth_place' => $addl . '|nullable|max:50',
                    'present_address' => $addl . '|nullable|max:150',
                    'provincial_address' => $addl . '|nullable|max:150',
                    'mobile_personal' => $addl . '|nullable|max:50',
                    'mobile_work' => $addl . '|nullable|max:50',
                    'email_personal' => $addl . '|nullable|max:50|email',
                    'email_work' => $addl . '|nullable|max:50|email',
                    'civil_status' => $addl . '|nullable',
                    'citizenship' => $addl . '|nullable|max:25',
                    'gender' => $addl . '|nullable',
                    'spouse_name' => $addl . '|nullable|max:35',
                    'spouse_occupation' => $addl . '|nullable|max:35',
                    'father_name' => $addl . '|nullable|max:35',
                    'father_occupation' => $addl . '|nullable|max:35',
                    'mother_name' => $addl . '|nullable|max:35',
                    'mother_occupation' => $addl . '|nullable|max:35',
                    'religion' => $addl . '|nullable|max:35',
                ]);

                foreach ($data as $key => $value) {
                    if ($value == $myInfo->$key) { $data[$key] = null; }
                }
    
                $emp_data->user_id = auth::user()->employee_id;
                $emp_data->last_name = $data['last_name'];
                $emp_data->first_name = $data['first_name'];
                $emp_data->middle_name = $data['middle_name'];
                $emp_data->locker_no = $data['locker_no'];
                $emp_data->sss = $data['sss'];
                $emp_data->tin = $data['tin'];
                $emp_data->pagibig = $data['pagibig'];
                $emp_data->philhealth = $data['philhealth'];
                $emp_data->prof_license = $data['prof_license'];
                $emp_data->license_no = $data['license_no'];
                $emp_data->emergency_contact = $data['emergency_contact'];
                $emp_data->emergency_relation = $data['emergency_relation'];
                $emp_data->emergency_address = $data['emergency_address'];
                $emp_data->emergency_number = $data['emergency_number'];
                $emp_data->birth_date = $data['birth_date'];
                $emp_data->birth_place = $data['birth_place'];
                $emp_data->present_address = $data['present_address'];
                $emp_data->provincial_address = $data['provincial_address'];
                $emp_data->mobile_personal = $data['mobile_personal'];
                $emp_data->mobile_work = $data['mobile_work'];
                $emp_data->email_personal = $data['email_personal'];
                $emp_data->email_work = $data['email_work'];
                $emp_data->civil_status = $data['civil_status'];
                $emp_data->citizenship = $data['citizenship'];
                $emp_data->gender = $data['gender'];
                $emp_data->spouse_name = $data['spouse_name'];
                $emp_data->spouse_occupation = $data['spouse_occupation'];
                $emp_data->father_name = $data['father_name'];
                $emp_data->father_occupation = $data['father_occupation'];
                $emp_data->mother_name = $data['mother_name'];
                $emp_data->mother_occupation = $data['mother_occupation'];
                $emp_data->religion = $data['religion'];
                
                $emp_data->save();
                return redirect('myprofile')->with("success",'Request for Profile Update has been successfully submitted.');
            }
        }

        $data['genders'] = $this->gender;
        $data['civil_statuses'] = $this->civil_stat;
        return view('users.edit.form', $data);
    }

    public function viewProfileUpdate($emp_id, $update_id) {
        $user_edit = UserEdit::find($update_id);

        $data = [];
        $data['update_details'] = $user_edit;
        
        return view('hris.employee.update', $data);
    }

    public function applyUpdates(Request $request) {
        if ($request->isMethod('post')) {
            $user_edit = UserEdit::find($request->input("update_id"));

            $user_edit->applied = true;
            $user_edit->response = 'Apply';
            $user_edit->applied_by = Auth::user()->user_id;

            $employee = $user_edit->employee;

            foreach($user_edit->editable_columns as $column) {
                if ($user_edit->$column != null) {
                    $employee->$column = $user_edit->$column;
                }
            }

            $user_edit->save();
            $employee->save();

            return redirect('hris/employee')->with('success','You have applied updates requested by '.$employee->getFullName());
        }
    }

    public function declineUpdates(Request $request) {
        if ($request->isMethod('post')) {
            $user_edit = UserEdit::find($request->input("update_id"));

            $user_edit->applied = true;
            $user_edit->response = 'Declined';
            $user_edit->applied_by = Auth::user()->user_id;
            $user_edit->remarks = $request->input('remarks');

            $user_edit->save();
            
            return redirect('hris/employee')->with('success','You have declined updates requested by '.$user_edit->employee->getFullName());
        }
    }
}
