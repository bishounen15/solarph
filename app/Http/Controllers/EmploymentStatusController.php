<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\EmploymentStatus as EmploymentStatus;

use DataTables;

class EmploymentStatusController extends Controller
{
    //
    public function __construct( EmploymentStatus $emp_status )
    {
        $this->emp_status = $emp_status->all();
    }

    public function show() {
        $data = [];
        $data['emp_statuses'] = $this->emp_status->all();

        return view('hris.setup.empstatus.show',$data);
    }

    public function newRecord(Request $request, EmploymentStatus $emp_status)
    {
        $emp_instance = new EmploymentStatus();
        $data = [];

        $data['code'] = $request->input('code');
        $data['description'] = $request->input('description');
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:hris.employment_statuses',
                'description' => 'required|max:25|unique:hris.employment_statuses',
            ]);

            $emp_status->create($data);
            return redirect('hris/setup/empstatus');
        }

        $data['modify'] = 0;
        return view('hris.setup.empstatus.form', $data);
    }

    public function modifyRecord(Request $request, EmploymentStatus $emp_status, $emp_id)
    {
        $emp_instance = new EmploymentStatus();
        $data = [];

        $data['description'] = $request->input('description');
        $data['active'] = $request->input('active');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $emp_data = $this->emp_status->find($emp_id);
            
            if ($emp_data->description != $data['description']) {
                $validation = 'required|max:25|unique:hris.employment_statuses';
            } else {
                $validation = 'required|max:25';
            }

            $this->validate($request, [
                'description' => $validation,
            ]);

            $emp_data->description = $data['description'];
            $emp_data->uid_modify = $data['uid_modify'];

            $emp_data->save();
            return redirect('hris/setup/empstatus');
        }

        $data['modify'] = 0;
        return view('hris.setup.empstatus.form', $data);
    }

    public function removeRecord($emp_id) {
        $emp_data = $this->emp_status->find($emp_id);
        
        if ($emp_data->isUsed()) {
            return redirect('hris/setup/empstatus')->with('fail',$emp_data->description.' could not be deleted as it was already associated with an existing employee.');
        } else {
            $emp_data->delete();
            return redirect('hris/setup/empstatus');
        }
    }

    public function activate($emp_id, $status) {
        $emp_data = $this->emp_status->find($emp_id);

        $emp_data->active = $status;
        $emp_data->uid_modify = auth::user()->email;

        $emp_data->save();
        return redirect('hris/setup/empstatus');
    }

    public function showRecord($emp_id){
        $data = [];

        $data['emp_id'] = $emp_id;
        $data['modify'] = 1;
                
        $emp_data = $this->emp_status->find($emp_id);

        $data['code'] = $emp_data->code;
        $data['description'] = $emp_data->description;
        
        return view('hris.setup.empstatus.form', $data);
    }

    public function listStatuses() {
        $emp_statuses = EmploymentStatus::selectRaw('active, id, code, description');
        return Datatables::of($emp_statuses)->make(true);
    }
}
