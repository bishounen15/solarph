<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User as User;
use App\App as App;

use DataTables;

class UsersController extends Controller
{
    //
    public function __construct( User $user )
    {
        $this->user = $user->all();
    }

    public function index() {
        $data = [];
        $data['users'] = $this->user->all();
        return view('users.index', $data);
    }

    public function myProfile() {
        $emp_data = auth::user()->information;

        $data = [];
        // $data['emp_id'] = $emp_data->id;

        $data['employee_info'] = $emp_data;
        $data['emp_subordinates'] = $emp_data->subordinates();
        $data['emp_dependents'] = $emp_data->dependents()->get();
        $data['emp_educ_bgs'] = $emp_data->educational_bg()->get();
        $data['emp_employ_hists'] = $emp_data->employment_hist()->get();
        $data['age'] = $emp_data->age();

        return view('hris.employee.profile.show', $data);
    }

    public function setUserAccess(Request $request, $user_id) {
        $data = [];
        $user_data = User::find($user_id);

        if ($request->isMethod('post')) {
            DB::table('user_accesses')->where('user_id','=',$user_id)->delete();

            if (!empty($request->input('selected_apps'))) {
                $data['user_id'] = $user_id;
                
                foreach($request->input('selected_apps') as $app_id) {
                    $data['app_id'] = $app_id;    
                    DB::table('user_accesses')->insert($data);
                }
            }

            if ($user_data->information != null) { $username = $user_data->information->getFullName(); } else { $username = $user_data->name; }
                return redirect('/users')->with('success','User Access for ' . $username . ' successfully updated.');
        }

        $apps = App::where("parent_id","=","0")->orderBy("parent_id","asc")->get();
        $user  = User::find($user_id);
        $data['apps'] = $apps;
        $data['user'] = $user;

        return view('users.access',$data);
    }

    public function listUsers()
    {
        $users = User::leftJoin("sp_hris.employees","users.employee_id","=","sp_hris.employees.id")
                        ->leftJoin("sp_hris.departments","sp_hris.employees.dep_id","=","sp_hris.departments.id")
                        ->leftJoin("sp_hris.divisions","sp_hris.employees.div_id","=","sp_hris.divisions.id")
                        ->selectRaw("users.id, CASE WHEN sp_hris.employees.id IS NULL THEN users.name ELSE " .
                                    "CONCAT(sp_hris.employees.last_name,', ',sp_hris.employees.first_name,' ',sp_hris.employees.middle_name) END AS user_name, " .
                                    "IFNULL(sp_hris.divisions.code,'-') AS division, IFNULL(sp_hris.departments.description,'-') AS department, " .
                                    "users.email");
        return Datatables::of($users)->make(true);
    }
}
