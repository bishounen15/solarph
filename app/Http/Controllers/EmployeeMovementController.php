<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee as Employee;
use App\EmployeeMovement as EmployeeMovement;
use App\Division as Division;
use App\Department as Department;
use App\CorporateRank as CorporateRank;
use App\PositionLevel as PositionLevel;
use App\EmploymentStatus as EmploymentStatus;
use App\LevelLink as LevelLink;

use DataTables;

class EmployeeMovementController extends Controller
{
    //
    public function __construct( Division $divisions, Department $departments, EmploymentStatus $emp_statuses, CorporateRank $corporate_rank, PositionLevel $pos_levels, Employee $employees )
    {
        $this->division = $divisions->all();
        $this->department = $departments->all();
        $this->emp_status = $emp_statuses->all();
        $this->corporate_rank = $corporate_rank->orderBy("level")->get();
        $this->pos_level = $pos_levels->all();
        $this->employee = $employees->all();
    }

    public function regularization(Request $request) {
        $data = [];

        $data['effectivity'] = $request->input('effectivity');
        $data['type'] = 'Regularization';
        $data['details'] = 'Status change from Probationary to Regular';
        $data['remarks'] = $request->input('remarks');

        if ($request->isMethod('post')) {
            if (!empty($request->input('selected_employees'))) {
                $myError = '';

                foreach($request->input('selected_employees') as $emp_id) {
                    $emp_data = Employee::find($emp_id);

                    $this->validate($request, [
                        'effectivity' => 'required|date|after:'.$emp_data->date_hired,
                        'remarks' => 'required',
                    ]);

                    $data['employee_id'] = $emp_id;
                    EmployeeMovement::insert($data);
                                    
                    $emp_data->stat_id = 1;
                    $emp_data->save();
                }

                return redirect('hris/movement/regularization')->with("success",'Transaction Successful.');
            } else {
                return view('hris.movement.regularization',$data)->with("fail",'You have not selected an employee from the list.');
            }
        }

        return view('hris.movement.regularization', $data);
    }

    public function transfer(Request $request) {
        $data = [];

        $data['effectivity'] = $request->input('effectivity');
        $data['type'] = 'Transfer';
        $data['remarks'] = $request->input('remarks');

        if ($request->isMethod('post')) {
            if (!empty($request->input('selected_employees'))) {
                $myError = '';

                foreach($request->input('selected_employees') as $emp_id) {
                    $emp_data = Employee::find($emp_id);

                    $this->validate($request, [
                        'div_id' => 'required',
                        'dep_id' => 'required',
                        'effectivity' => 'required|date|after:'.$emp_data->date_hired,
                        'remarks' => 'required',
                    ]);

                    $data['employee_id'] = $emp_id;

                    $details = '';

                    if ($emp_data->div_id != $request->input('div_id')) {
                        $new_div = $this->division->find($request->input('div_id'))->code;
                        $details .= 'Transfered from site ' . $emp_data->division->code . ' to ' . $new_div; 
                    }

                    if ($emp_data->dep_id != $request->input('dep_id')) {
                        $new_dep = $this->department->find($request->input('dep_id'))->code;
                        if ($details != '') { $details .= ', '; }
                        $details .= 'Transfered from department ' . $emp_data->department->code . ' to ' . $new_dep;
                    }

                    $data['details'] = $details;
                    EmployeeMovement::insert($data);
                    
                    $emp_data->div_id = $request->input('div_id');
                    $emp_data->dep_id = $request->input('dep_id');
                    $emp_data->save();
                }

                return redirect('hris/movement/transfer')->with("success",'Transaction Successful.');
            } else {
                $data['divisions'] = $this->division;
                $data['departments'] = $this->department;

                $data['div_id'] = $request->input('div_id');
                $data['dep_id'] = $request->input('dep_id');
                return view('hris.movement.emptransfer',$data)->with("fail",'You have not selected an employee from the list.');
            }
        }

        $data['divisions'] = $this->division;
        $data['departments'] = $this->department;
        
        $data['div_id'] = $request->input('div_id');
        $data['dep_id'] = $request->input('dep_id');
        return view('hris.movement.emptransfer', $data);
    }

    public function promotion(Request $request) {
        $data = [];

        $data['effectivity'] = $request->input('effectivity');
        $data['remarks'] = $request->input('remarks');

        if ($request->isMethod('post')) {
            if (!empty($request->input('selected_employees'))) {
                $myError = '';

                foreach($request->input('selected_employees') as $emp_id) {
                    $emp_data = Employee::find($emp_id);

                    $this->validate($request, [
                        'rank_id' => 'required',
                        'pos_id' => 'required',
                        'effectivity' => 'required|date|after:'.$emp_data->date_hired,
                        'remarks' => 'required',
                    ]);

                    $data['employee_id'] = $emp_id;

                    $details = '';

                    if ($emp_data->rank_id != $request->input('rank_id')) {
                        $new_rank = $this->corporate_rank->find($request->input('rank_id'));

                        if ($emp_data->rank->level > $new_rank->level) {
                            $data['type'] = 'Promotion';
                            $msg = 'Promoted';
                        } else {
                            $data['type'] = 'Demotion';
                            $msg = 'Demoted';
                        }

                        $details .= $msg . ' from rank ' . $emp_data->rank->description . ' to ' . $new_rank->description; 
                    }

                    if ($emp_data->pos_id != $request->input('pos_id')) {
                        $new_pos = $this->pos_level->find($request->input('pos_id'));

                        if ($details == '') {
                            if ($emp_data->level->corpLevel($emp_data->rank_id)->level > $new_pos->corpLevel($request->input('rank_id'))->level) {
                                $data['type'] = 'Promotion';
                                $msg = 'Promoted';
                            } else {
                                $data['type'] = 'Demotion';
                                $msg = 'Demoted';
                            }
                        } else {
                            $details .= ', ';
                        }

                        $details .= $msg . ' from level ' . $emp_data->level->description . ' to ' . $new_pos->description; 
                    }

                    $data['details'] = $details;
                    EmployeeMovement::insert($data);
                    
                    $emp_data->rank_id = $request->input('rank_id');
                    $emp_data->pos_id = $request->input('pos_id');
                    $emp_data->save();
                }

                return redirect('hris/movement/promotion')->with("success",'Transaction Successful.');
            } else {
                $poslevels = LevelLink::getLevels($request->input('rank_id'));
                $data['ranks'] = $this->corporate_rank;
                $data['pos_levels'] = $poslevels;
                $data['rank_id'] = $request->input('rank_id');
                $data['pos_id'] = $request->input('pos_id');
                return view('hris.movement.promotion',$data)->with("fail",'You have not selected an employee from the list.');
            }
        }

        $poslevels = LevelLink::getLevels($request->input('rank_id'));
        $data['ranks'] = $this->corporate_rank;
        $data['pos_levels'] = $poslevels;
        $data['rank_id'] = $request->input('rank_id');
        $data['pos_id'] = $request->input('pos_id');
        return view('hris.movement.promotion', $data);
    }

    public function resignation(Request $request) {
        $data = [];

        $data['effectivity'] = $request->input('effectivity');
        $data['type'] = 'Resignation';
        $data['remarks'] = $request->input('remarks');

        if ($request->isMethod('post')) {
            if (!empty($request->input('selected_employees'))) {
                $myError = '';

                foreach($request->input('selected_employees') as $emp_id) {
                    $emp_data = Employee::find($emp_id);

                    $this->validate($request, [
                        'stat_id' => 'required',
                        'effectivity' => 'required|date|after:'.$emp_data->date_hired,
                        'remarks' => 'required',
                    ]);

                    $data['employee_id'] = $emp_id;

                    $details = '';

                    $new_stat = $this->emp_status->find($request->input('stat_id'));
                    $details .= 'Status Change from ' . $emp_data->status->description . ' to ' . $new_stat->description; 
                    
                    $data['details'] = $details;
                    EmployeeMovement::insert($data);
                    
                    $emp_data->stat_id = $request->input('stat_id');
                    $emp_data->save();
                }

                return redirect('hris/movement/resignation')->with("success",'Transaction Successful.');
            } else {
                $data['emp_statuses'] = EmploymentStatus::where('active','=','0')->get();
                $data['stat_id'] = $request->input('stat_id');
                return view('hris.movement.resignation',$data)->with("fail",'You have not selected an employee from the list.');
            }
        }

        $data['emp_statuses'] = EmploymentStatus::where('active','=','0')->get();
        $data['stat_id'] = $request->input('stat_id');
        return view('hris.movement.resignation', $data);
    }

    public function probationary()
    {
        $employees = Employee::join("departments","employees.dep_id","=","departments.id")
                                ->selectRaw("employees.id, employees.last_name, employees.first_name, employees.middle_name, CONCAT(employees.last_name,', ',employees.first_name,' ',employees.middle_name) AS full_name, employees.position, departments.description")
                                ->where("employees.stat_id","=","2");
        return Datatables::of($employees)->make(true);
    }

    public function activeEmployees()
    {
        $employees = Employee::join("departments","employees.dep_id","=","departments.id")
                                ->join("employment_statuses","employees.stat_id","=","employment_statuses.id")
                                ->selectRaw("employees.id, employees.last_name, employees.first_name, employees.middle_name, CONCAT(employees.last_name,', ',employees.first_name,' ',employees.middle_name) AS full_name, employees.position, departments.description")
                                ->where("employment_statuses.active","=","1");
        return Datatables::of($employees)->make(true);
    }
}
