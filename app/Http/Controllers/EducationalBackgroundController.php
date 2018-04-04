<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\EducationalBackground as EducationalBackground;
use App\Employee as Employee;
use App\EducationLevel as EducationLevel;

class EducationalBackgroundController extends Controller
{
    //
    private $validations = [
        'level' => 'required',
        'degree' => 'max:75',
        'school' => 'required|max:75',
        'address' => 'required|max:150',
        'undergrad' => 'boolean',
        'graduate_year' => 'integer',
    ];

    public function __construct( Employee $employee, EducationLevel $educ_level, EducationalBackground $educ_bg )
    {
        $this->employee = $employee->all();
        $this->educ_level = $educ_level->all();
        $this->educ_bg = $educ_bg->all();
    }

    public function show($emp_id) {
        $data = [];
        $data['employee'] = Employee::find($emp_id);
        $data['educational_bgs'] = Employee::find($emp_id)->educational_bg()->get();

        return view('hris.employee.educbackground.show',$data);
    }

    public function newRecord(Request $request, EducationalBackground $educ_bg, $emp_id)
    {
        $ebg_instance = new EducationalBackground();
        $data = [];

        $data['employee_id'] = $emp_id;
        $data['rec_ix'] = EducationalBackground::maxIndex($emp_id) + 1;
        $data['level'] = $request->input('level');
        $data['degree'] = $request->input('degree');
        $data['school'] = $request->input('school');
        $data['address'] = $request->input('address');
        $data['undergrad'] = $request->input('undergrad');
        $data['graduate_year'] = $request->input('graduate_year');
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, $this->validations);

            $educ_bg->create($data);
            return redirect('hris/employee/'.$emp_id.'/educbackground')->with('success','Record Successfully Created!');
        }

        $data['emp_id'] = $emp_id;
        $data['levels'] = $this->educ_level;
        $data['modify'] = 0;
        return view('hris.employee.educbackground.form', $data);
    }

    public function modifyRecord(Request $request, EducationalBackground $educ_bg, $emp_id, $ebg_id)
    {
        $ebg_instance = new EducationalBackground();
        $data = [];

        $data['level'] = $request->input('level');
        $data['degree'] = $request->input('degree');
        $data['school'] = $request->input('school');
        $data['address'] = $request->input('address');
        $data['undergrad'] = $request->input('undergrad');
        $data['graduate_year'] = $request->input('graduate_year');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $ebg_data = $this->educ_bg->find($ebg_id);
            
            $this->validate($request, $this->validations);

            $ebg_data->level = $data['level'];
            $ebg_data->degree = $data['degree'];
            $ebg_data->school = $data['school'];
            $ebg_data->address = $data['address'];
            $ebg_data->undergrad = $data['undergrad'];
            $ebg_data->graduate_year = $data['graduate_year'];
            $ebg_data->uid_modify = $data['uid_modify'];

            $ebg_data->save();
            return redirect('hris/employee/'.$emp_id.'/educbackground')->with('success','Record Successfully Updated!');
        }

        $data['emp_id'] = $emp_id;
        $data['ebg_id'] = $ebg_id;
        $data['levels'] = $this->educ_level;
        $data['modify'] = 1;
        return view('hris.employee.educbackground.form', $data);
    }

    public function removeRecord($emp_id, $ebg_id) {
        $ebg_data = $this->educ_bg->find($ebg_id);
        $ebg_data->delete();
        return redirect('hris/employee/'.$emp_id.'/educbackground');
    }

    public function showRecord($emp_id, $ebg_id){
        $data = [];

        $data['emp_id'] = $emp_id;
        $data['ebg_id'] = $ebg_id;
        $data['levels'] = $this->educ_level;
        $data['modify'] = 1;
                
        $ebg_data = $this->educ_bg->find($ebg_id);

        $data['level'] = $ebg_data->level;
        $data['degree'] = $ebg_data->degree;
        $data['school'] = $ebg_data->school;
        $data['address'] = $ebg_data->address;
        $data['undergrad'] = $ebg_data->undergrad;
        $data['graduate_year'] = $ebg_data->graduate_year;
        
        return view('hris.employee.educbackground.form', $data);
    }
}
