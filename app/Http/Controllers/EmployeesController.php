<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Employee as Employee;
use App\Mail\UserCreated;

use App\User as User;
use App\Division as Division;
use App\Department as Department;
use App\CorporateRank as CorporateRank;
use App\PositionLevel as PositionLevel;
use App\EmploymentStatus as EmploymentStatus;
use App\TaxStatus as TaxStatus;
use App\Gender as Gender;
use App\CivilStatus as CivilStatus;
use App\DeptLink as DeptLink;
use App\LevelLink as LevelLink;
use DataTables;

use Barryvdh\DomPDF\Facade as PDF;

class EmployeesController extends Controller
{
    //
    
    public function __construct( Gender $genders, CivilStatus $civil_status, Division $divisions, Department $departments, EmploymentStatus $emp_statuses, TaxStatus $tax_statuses, CorporateRank $corporate_rank, PositionLevel $pos_levels, Employee $employees )
    {
        $this->gender = $genders->all();
        $this->civil_stat = $civil_status->all();
        $this->division = $divisions->all();
        $this->department = $departments->all();
        $this->emp_status = $emp_statuses->all();
        $this->tax_status = $tax_statuses->all();
        $this->corporate_rank = $corporate_rank->all();
        $this->pos_level = $pos_levels->all();
        $this->employee = $employees->all();
    }

    public function show() {
        return view('hris.employee.index');
    }

    public function newRecord(Request $request, Employee $employee)
    {
        $emp_instance = new Employee();
        $data = [];

        $data['id_number'] = $request->input('id_number');
        $data['last_name'] = $request->input('last_name');
        $data['first_name'] = $request->input('first_name');
        $data['middle_name'] = $request->input('middle_name');
        $data['date_hired'] = $request->input('date_hired');
        $data['div_id'] = $request->input('div_id');
        $data['dep_id'] = $request->input('dep_id');
        $data['position'] = $request->input('position');
        $data['rank_id'] = $request->input('rank_id');
        $data['pos_id'] = $request->input('pos_id');
        $data['stat_id'] = $request->input('stat_id');
        $data['sup_id'] = $request->input('sup_id');
        $data['locker_no'] = $request->input('locker_no');
        $data['tax_id'] = $request->input('tax_id');
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
        $data['father_occupation'] = $request->input('father_occupation');
        $data['mother_name'] = $request->input('mother_name');
        $data['mother_occupation'] = $request->input('mother_occupation');
        $data['religion'] = $request->input('religion');
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'id_number' => 'required|max:15|unique:hris.employees',
                'last_name' => 'required|max:35',
                'first_name' => 'required|max:35',
                'middle_name' => 'required|max:35',
                'date_hired' => 'required|after:'.$data['birth_date'],
                'div_id' => 'required',
                'dep_id' => 'required',
                'position' => 'required|max:50',
                'rank_id' => 'required',
                'pos_id' => 'required',
                'stat_id' => 'required',
                'locker_no' => 'nullable|max:20',
                'tax_id' => 'required',
                'sss' => 'nullable|max:20',
                'tin' => 'nullable|max:20',
                'pagibig' => 'nullable|max:20',
                'philhealth' => 'nullable|max:20',
                'prof_license' => 'nullable|max:35',
                'license_no' => 'nullable|max:25',
                'emergency_contact' => 'required|max:35',
                'emergency_relation' => 'required|max:15',
                'emergency_address' => 'required|max:150',
                'emergency_number' => 'required|max:50',
                'birth_date' => 'required',
                'birth_place' => 'nullable|max:50',
                'present_address' => 'nullable|max:150',
                'provincial_address' => 'nullable|max:150',
                'mobile_personal' => 'nullable|max:50',
                'mobile_work' => 'nullable|max:50',
                'email_personal' => 'required_without_all:email_personal,email_work|nullable|max:50|email|unique:users,email',
                'email_work' => 'required_without_all:email_personal,email_work|nullable|max:50|email|unique:users,email',
                'civil_status' => 'nullable',
                'citizenship' => 'nullable|max:25',
                'gender' => 'nullable',
                'spouse_name' => 'nullable|max:35',
                'spouse_occupation' => 'nullable|max:35',
                'father_name' => 'nullable|max:35',
                'father_occupation' => 'nullable|max:35',
                'mother_name' => 'nullable|max:35',
                'mother_occupation' => 'nullable|max:35',
                'religion' => 'nullable|max:35',
                'profile_photo' => 'image|nullable|max:1999',
            ]);

            if ($request->hasFile('profile_photo')) {
                $filenameWithExt = $request->file('profile_photo')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
                $extension = $request->file('profile_photo')->getClientOriginalExtension();
                $filenameToStore = $data['id_number'].".".$extension;

                $path = $request->file('profile_photo')->storeAs('public/images/employees',$filenameToStore);
                $data['profile_photo'] = $filenameToStore;
            }

            $employee->create($data);

            $new_emp = Employee::where("id_number","=",$data["id_number"])->first();
            $hash_password = str_random(6);
            $data['password'] = $hash_password;

            User::create([
                'user_id' => $data['id_number'],
                'employee_id' => $new_emp->id,
                'name' => $new_emp->getFullName(),
                'email' => $data['email_work'] != null ? $data['email_work'] : $data['email_personal'],
                'password' => bcrypt($hash_password),
            ]);

            Mail::to($data['email_work'] != null ? $data['email_work'] : $data['email_personal'])->send(new UserCreated($data));
            //return new App\Mail\UserCreated($data);

            // dd($hash_password);
            return redirect('hris/employee')->with('success','Record Successfully Created!');
        }

        $data['divisions'] = $this->division;
        $superiors = Employee::getQualifiedSuperiors(0,0,PositionLevel::maxID());
        $data['superiors'] = $superiors;
        $data['departments'] = $this->department;
        $data['ranks'] = $this->corporate_rank;
        $data['pos_levels'] = $this->pos_level;
        $data['emp_statuses'] = $this->emp_status;
        $data['tax_statuses'] = $this->tax_status;
        $data['genders'] = $this->gender;
        $data['civil_statuses'] = $this->civil_stat;

        $data['modify'] = 0;
        return view('hris.employee.form', $data);
    }

    public function modifyRecord(Request $request, Employee $employee, $emp_id)
    {
        $emp_instance = new Employee();
        $data = [];

        $data['last_name'] = $request->input('last_name');
        $data['first_name'] = $request->input('first_name');
        $data['middle_name'] = $request->input('middle_name');
        $data['date_hired'] = $request->input('date_hired');
        $data['div_id'] = $request->input('div_id');
        $data['dep_id'] = $request->input('dep_id');
        $data['position'] = $request->input('position');
        $data['rank_id'] = $request->input('rank_id');
        $data['pos_id'] = $request->input('pos_id');
        $data['stat_id'] = $request->input('stat_id');
        $data['sup_id'] = $request->input('sup_id');
        $data['locker_no'] = $request->input('locker_no');
        $data['tax_id'] = $request->input('tax_id');
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
        $data['father_occupation'] = $request->input('father_occupation');
        $data['mother_name'] = $request->input('mother_name');
        $data['mother_occupation'] = $request->input('mother_occupation');
        $data['religion'] = $request->input('religion');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $emp_data = $this->employee->find($emp_id);
            
            $this->validate($request, [
                'last_name' => 'required|max:35',
                'first_name' => 'required|max:35',
                'middle_name' => 'required|max:35',
                'date_hired' => 'required|after:'.$data['birth_date'],
                // 'div_id' => 'required',
                // 'dep_id' => 'required',
                'position' => 'required|max:50',
                // 'rank_id' => 'required',
                // 'pos_id' => 'required',
                // 'stat_id' => 'required',
                'locker_no' => 'nullable|max:20',
                'tax_id' => 'required',
                'sss' => 'nullable|max:20',
                'tin' => 'nullable|max:20',
                'pagibig' => 'nullable|max:20',
                'philhealth' => 'nullable|max:20',
                'prof_license' => 'nullable|max:35',
                'license_no' => 'nullable|max:25',
                'emergency_contact' => 'required|max:35',
                'emergency_relation' => 'required|max:15',
                'emergency_address' => 'required|max:150',
                'emergency_number' => 'required|max:50',
                'birth_date' => 'required',
                'birth_place' => 'nullable|max:50',
                'present_address' => 'nullable|max:150',
                'provincial_address' => 'nullable|max:150',
                'mobile_personal' => 'nullable|max:50',
                'mobile_work' => 'nullable|max:50',
                'email_personal' => 'nullable|max:50|email',
                'email_work' => 'nullable|max:50|email',
                'civil_status' => 'nullable',
                'citizenship' => 'nullable|max:25',
                'gender' => 'nullable',
                'spouse_name' => 'nullable|max:35',
                'spouse_occupation' => 'nullable|max:35',
                'father_name' => 'nullable|max:35',
                'father_occupation' => 'nullable|max:35',
                'mother_name' => 'nullable|max:35',
                'mother_occupation' => 'nullable|max:35',
                'religion' => 'nullable|max:35',
                'profile_photo' => 'image|nullable|max:1999',
            ]);

            if ($request->hasFile('profile_photo')) {
                $filenameWithExt = $request->file('profile_photo')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
                $extension = $request->file('profile_photo')->getClientOriginalExtension();
                $filenameToStore = $emp_data->id_number.".".$extension;

                $path = $request->file('profile_photo')->storeAs('public/images/employees',$filenameToStore);
                $emp_data->profile_photo = $filenameToStore;
            }

            $emp_data->last_name = $data['last_name'];
            $emp_data->first_name = $data['first_name'];
            $emp_data->middle_name = $data['middle_name'];
            $emp_data->date_hired = $data['date_hired'];
            // $emp_data->div_id = $data['div_id'];
            // $emp_data->dep_id = $data['dep_id'];
            $emp_data->position = $data['position'];
            // $emp_data->rank_id = $data['rank_id'];
            // $emp_data->pos_id = $data['pos_id'];
            // $emp_data->stat_id = $data['stat_id'];
            $emp_data->sup_id = $data['sup_id'];
            $emp_data->locker_no = $data['locker_no'];
            $emp_data->tax_id = $data['tax_id'];
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
            $emp_data->uid_modify = $data['uid_modify'];           
            
            $emp_data->save();
            return redirect('hris/employee')->with('success','Record Successfully Updated!');
        }

        $data['modify'] = 0;
        return view('hris.employee.form', $data);
    }

    public function removeRecord($emp_id) {
        $emp_data = $this->employee->find($emp_id);
        $emp_data->delete();
        return redirect('hris/employee');
    }

    public function showRecord($emp_id){
        $data = [];

        $data['emp_id'] = $emp_id;
        $data['modify'] = 1;

        $emp_data = $this->employee->find($emp_id);

        $data['divisions'] = $this->division;
        $departments = DeptLink::getDepartments($emp_data->div_id);
        $poslevels = LevelLink::getLevels($emp_data->rank_id);
        $superiors = $emp_data->getQualifiedSuperiors($emp_data->div_id,$emp_data->dep_id,$emp_data->pos_id);
        $data['departments'] = $departments;
        $data['superiors'] = $superiors;
        $data['ranks'] = $this->corporate_rank;
        $data['pos_levels'] = $poslevels;
        $data['emp_statuses'] = $this->emp_status;
        $data['tax_statuses'] = $this->tax_status;
        $data['genders'] = $this->gender;
        $data['civil_statuses'] = $this->civil_stat;
        
        $data['id_number'] = $emp_data->id_number;
        $data['last_name'] = $emp_data->last_name;
        $data['first_name'] = $emp_data->first_name;
        $data['middle_name'] = $emp_data->middle_name;
        $data['date_hired'] = $emp_data->date_hired;
        $data['div_id'] = $emp_data->div_id;
        $data['dep_id'] = $emp_data->dep_id;
        $data['position'] = $emp_data->position;
        $data['rank_id'] = $emp_data->rank_id;
        $data['pos_id'] = $emp_data->pos_id;
        $data['stat_id'] = $emp_data->stat_id;
        $data['sup_id'] = $emp_data->sup_id;
        $data['locker_no'] = $emp_data->locker_no;
        $data['tax_id'] = $emp_data->tax_id;
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
        
        return view('hris.employee.form', $data);
    }

    public function viewProfile($emp_id) {
        $data = [];
        $data['emp_id'] = $emp_id;

        $emp_data = $this->employee->find($emp_id);
        $data['employee_info'] = $emp_data;
        $data['emp_subordinates'] = $emp_data->subordinates();
        $data['emp_dependents'] = $emp_data->dependents()->get();
        $data['emp_educ_bgs'] = $emp_data->educational_bg()->get();
        $data['emp_employ_hists'] = $emp_data->employment_hist()->get();
        $data['age'] = $emp_data->age();

        return view('hris.employee.profile.show', $data);
    }

    public function exportPDF($emp_id) {
        $data = [];
        $data['emp_id'] = $emp_id;

        $emp_data = $this->employee->find($emp_id);
        $data['employee_info'] = $emp_data;
        $data['emp_dependents'] = $emp_data->dependents()->get();
        $data['emp_educ_bgs'] = $emp_data->educational_bg()->get();
        $data['emp_employ_hists'] = $emp_data->employment_hist()->get();
        $data['age'] = $emp_data->age();

        $pdf = PDF::loadView('hris.employee.profile.show', $data);
        return $pdf->download('profile.pdf');
    }

    public function listEmployees()
    {
        $employees = Employee::join("departments","employees.dep_id","=","departments.id")
                                ->join("divisions","employees.div_id","=","divisions.id")
                                ->join("employment_statuses","employees.stat_id","=","employment_statuses.id")
                                ->leftJoin("user_edits", function($join) {
                                    $join->on("employees.id","=","user_edits.user_id")
                                            ->on("user_edits.applied",DB::raw("0"));
                                })
                                ->selectRaw("CASE WHEN user_edits.id IS NULL THEN 0 ELSE 1 END as with_edit, IFNULL(user_edits.id,0) AS edit_id, employees.id, employees.id_number, CONCAT(employees.last_name,', ',employees.first_name,' ',employees.middle_name) AS full_name, employees.position, employment_statuses.description AS status, divisions.code AS division, departments.description AS department")
                                ->orderByRaw("with_edit DESC, departments.description ASC, employees.id_number ASC");
        return Datatables::of($employees)->make(true);
    }

    public function auditTrail($emp_id) {
        $data = [];
        $data['employee'] = Employee::find($emp_id);

        return view('hris.employee.profile.audit',$data);
    }
}
