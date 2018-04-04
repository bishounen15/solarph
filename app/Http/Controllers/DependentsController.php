<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Dependent as Dependent;
use App\Employee as Employee;
use App\Gender as Gender;
use App\Relation as Relation;

class DependentsController extends Controller
{
    //
    private $validations = [
        'name' => 'required|max:35',
        'relation' => 'required|max:15',
        'birth_date' => 'required|date',
        'gender' => 'required|max:15',
    ];

    public function __construct( Gender $gender, Relation $relation, Dependent $dependent )
    {
        $this->gender = $gender->all();
        $this->relation = $relation->all();
        $this->dependent = $dependent->all();
    }

    public function show($emp_id) {
        $data = [];
        $data['employee'] = Employee::find($emp_id);
        $data['dependents'] = Employee::find($emp_id)->dependents()->get();

        return view('hris.employee.dependents.show',$data);
    }

    public function newRecord(Request $request, Dependent $dependent, $emp_id)
    {
        $dep_instance = new dependent();
        $data = [];

        $data['employee_id'] = $emp_id;
        $data['rec_ix'] = Dependent::maxIndex($emp_id) + 1;
        $data['name'] = $request->input('name');
        $data['relation'] = $request->input('relation');
        $data['birth_date'] = $request->input('birth_date');
        $data['gender'] = $request->input('gender');
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, $this->validations);

            $dependent->create($data);
            return redirect('hris/employee/'.$emp_id.'/dependent')->with('success','Record Successfully Created!');
        }

        $data['emp_id'] = $emp_id;
        $data['genders'] = $this->gender;
        $data['relations'] = $this->relation;
        $data['modify'] = 0;
        return view('hris.employee.dependents.form', $data);
    }

    public function modifyRecord(Request $request, Dependent $dependent, $emp_id, $dep_id)
    {
        $dep_instance = new dependent();
        $data = [];

        $data['name'] = $request->input('name');
        $data['relation'] = $request->input('relation');
        $data['birth_date'] = $request->input('birth_date');
        $data['gender'] = $request->input('gender');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $dep_data = $this->dependent->find($dep_id);
            
            $this->validate($request, $this->validations);

            $dep_data->name = $data['name'];
            $dep_data->relation = $data['relation'];
            $dep_data->birth_date = $data['birth_date'];
            $dep_data->gender = $data['gender'];
            $dep_data->uid_modify = $data['uid_modify'];

            $dep_data->save();
            return redirect('hris/employee/'.$emp_id.'/dependent')->with('success','Record Successfully Updated!');
        }

        $data['emp_id'] = $emp_id;
        $data['dep_id'] = $dep_id;
        $data['modify'] = 1;
        return view('hris.employee.dependents.form', $data);
    }

    public function removeRecord($emp_id, $dep_id) {
        $dep_data = $this->dependent->find($dep_id);
        $dep_data->delete();
        return redirect('hris/employee/'.$emp_id.'/dependent');
    }

    public function showRecord($emp_id, $dep_id){
        $data = [];

        $data['emp_id'] = $emp_id;
        $data['dep_id'] = $dep_id;
        $data['genders'] = $this->gender;
        $data['relations'] = $this->relation;
        $data['modify'] = 1;
                
        $dep_data = $this->dependent->find($dep_id);

        $data['name'] = $dep_data->name;
        $data['relation'] = $dep_data->relation;
        $data['birth_date'] = $dep_data->birth_date;
        $data['gender'] = $dep_data->gender;
        
        return view('hris.employee.dependents.form', $data);
    }
}
