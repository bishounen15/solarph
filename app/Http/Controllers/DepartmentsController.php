<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Department as Department;
use App\Division as Division;
use App\DeptLink as DeptLink;

use DataTables;

class DepartmentsController extends Controller
{
    //
    public function __construct( Division $division, Department $department )
    {
        $this->department = $department->all();
        $this->division = $division->all();
    }

    public function show() {
        $data = [];
        $data['departments'] = $this->department->all();

        return view('hris.setup.departments.show',$data);
    }

    public function newRecord(Request $request, Department $department)
    {
        $dep_instance = new Department();
        $data = [];

        $data['code'] = $request->input('code');
        $data['description'] = $request->input('description');
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:hris.departments',
                'description' => 'required|max:50|unique:hris.departments',
            ]);

            $department->create($data);

            if (!empty($request->input('selected_divisions'))) {
                $current_dept = Department::where('description','=',$data['description'])->first();

                $insLink = [];
                $insLink['dep_id'] = $current_dept->id;

                foreach($request->input('selected_divisions') as $div_id) {
                    $insLink['div_id'] = $div_id;
                    DB::connection('hris')->table('deptlink')->insert($insLink);
                }
            }

            return redirect('hris/setup/departments');
        }

        $data['divisions'] = $this->division->all();
        $data['modify'] = 0;
        return view('hris.setup.departments.form', $data);
    }

    public function modifyRecord(Request $request, Department $department, $dep_id)
    {
        $dep_instance = new Department();
        $data = [];

        $data['description'] = $request->input('description');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $dep_data = $this->department->find($dep_id);
            
            if ($dep_data->description != $data['description']) {
                $validation = 'required|max:50|unique:hris.departments';
            } else {
                $validation = 'required|max:50';
            }

            $this->validate($request, [
                'description' => $validation,
            ]);

            $dep_data->description = $data['description'];
            $dep_data->uid_modify = $data['uid_modify'];

            $dep_data->save();

            DB::connection('hris')->table('deptlink')->where([
                ["dep_id","=",$dep_id],
            ])->delete();

            if (!empty($request->input('selected_divisions'))) {
                $current_dept = Department::where('description','=',$data['description'])->first();

                $insLink = [];
                $insLink['dep_id'] = $current_dept->id;

                foreach($request->input('selected_divisions') as $div_id) {
                    $insLink['div_id'] = $div_id;
                    DB::connection('hris')->table('deptlink')->insert($insLink);
                }
            }

            return redirect('hris/setup/departments');
        }

        $data['modify'] = 0;
        return view('hris.setup.departments.form', $data);
    }

    public function removeRecord($dep_id) {
        $dep_data = $this->department->find($dep_id);
        
        if ($dep_data->isUsed()) {
            return redirect('hris/setup/departments')->with('fail',$dep_data->description.' could not be deleted as it was already associated with an existing employee.');
        } else {
            $dep_data->delete();
            DB::connection('hris')->table('deptlink')->where([
                ["dep_id","=",$dep_id],
            ])->delete();

            return redirect('hris/setup/departments');
        }
    }

    public function showRecord($dep_id){
        $data = [];

        $data['divisions'] = $this->division->all();
        $data['dep_id'] = $dep_id;
        $data['modify'] = 1;
                
        $dep_data = $this->department->find($dep_id);

        $data['code'] = $dep_data->code;
        $data['description'] = $dep_data->description;
        $data['dep_data'] = $dep_data;
        
        return view('hris.setup.departments.form', $data);
    }

    public function listDepartments() {
        $departments = Department::selectRaw('id, code, description');
        return Datatables::of($departments)->make(true);
    }
}
