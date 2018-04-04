<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\EmploymentHistory as EmploymentHistory;
use App\Employee as Employee;

class EmploymentHistoryController extends Controller
{
    //
    private $validations = [
        'company' => 'required|max:75',
        'address' => 'max:150',
        'position' => 'required|max:75',
        'reason' => 'required|max:50',
        'start' => 'date',
        'end' => 'date',
        'duties' => 'required',
    ];


    public function __construct( Employee $employee, EmploymentHistory $emp_hist )
    {
        $this->employee = $employee->all();
        $this->emp_hist = $emp_hist->all();
    }

    public function show($emp_id) {
        $data = [];
        $data['employee'] = Employee::find($emp_id);
        $data['employment_hist'] = Employee::find($emp_id)->employment_hist()->get();

        return view('hris.employee.employhist.show',$data);
    }

    public function newRecord(Request $request, EmploymentHistory $emp_hist, $emp_id)
    {
        $ehist_instance = new EmploymentHistory();
        $data = [];

        $data['employee_id'] = $emp_id;
        $data['rec_ix'] = EmploymentHistory::maxIndex($emp_id) + 1;
        $data['company'] = $request->input('company');
        $data['address'] = $request->input('address');
        $data['position'] = $request->input('position');
        $data['reason'] = $request->input('reason');
        $data['start'] = $request->input('start');
        $data['end'] = $request->input('end');
        $data['duties'] = $request->input('duties');
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, $this->validations);

            $emp_hist->create($data);
            return redirect('hris/employee/'.$emp_id.'/employhist')->with('success','Record Successfully Created!');
        }

        $data['emp_id'] = $emp_id;
        $data['modify'] = 0;
        return view('hris.employee.employhist.form', $data);
    }

    public function modifyRecord(Request $request, EmploymentHistory $emp_hist, $emp_id, $ehist_id)
    {
        $ehist_instance = new EmploymentHistory();
        $data = [];

        $data['company'] = $request->input('company');
        $data['address'] = $request->input('address');
        $data['position'] = $request->input('position');
        $data['reason'] = $request->input('reason');
        $data['start'] = $request->input('start');
        $data['end'] = $request->input('end');
        $data['duties'] = $request->input('duties');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $ehist_data = $this->emp_hist->find($ehist_id);
            
            $this->validate($request, $this->validations);

            $ehist_data->company = $data['company'];
            $ehist_data->address = $data['address'];
            $ehist_data->position = $data['position'];
            $ehist_data->reason = $data['reason'];
            $ehist_data->start = $data['start'];
            $ehist_data->end = $data['end'];
            $ehist_data->duties = $data['duties'];
            $ehist_data->uid_modify = $data['uid_modify'];

            $ehist_data->save();
            return redirect('hris/employee/'.$emp_id.'/employhist')->with('success','Record Successfully Updated!');
        }

        $data['emp_id'] = $emp_id;
        $data['ehist_id'] = $ehist_id;
        $data['modify'] = 1;
        return view('hris.employee.employhist.form', $data);
    }

    public function removeRecord($emp_id, $ehist_id) {
        $ehist_data = $this->emp_hist->find($ehist_id);
        $ehist_data->delete();
        return redirect('hris/employee/'.$emp_id.'/employhist');
    }

    public function showRecord($emp_id, $ehist_id){
        $data = [];

        $data['emp_id'] = $emp_id;
        $data['ehist_id'] = $ehist_id;
        $data['modify'] = 1;
                
        $ehist_data = $this->emp_hist->find($ehist_id);

        $data['company'] = $ehist_data->company;
        $data['address'] = $ehist_data->address;
        $data['position'] = $ehist_data->position;
        $data['reason'] = $ehist_data->reason;
        $data['start'] = $ehist_data->start;
        $data['end'] = $ehist_data->end;
        $data['duties'] = $ehist_data->duties;
        
        return view('hris.employee.employhist.form', $data);
    }
}
