<?php

Use App\DeptLink as DeptLink;
Use App\LevelLink as LevelLink;
Use App\Employee as Employee;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@index')->name('index');

Route::group(['middleware'=>['auth','revalidate']], function() {
    // Main Routes
    Route::get('/myapps', 'PagesController@myapps')->name('myapps');
    Route::get('/myprofile', 'UsersController@myProfile')->name('myprofile');
    
    Route::get('/myprofile/edit', 'UserEditsController@editProfile')->name('edit_profile');
    Route::post('/myprofile/edit', 'UserEditsController@submitProfile')->name('submit_profile_update');
    
    // User Maintenance Routes
    Route::get('/users','UsersController@index')->name('users');
    Route::get('/users/list', 'UsersController@listUsers')->name('list_users');
    Route::get('/users/access/{user_id}','UsersController@setUserAccess')->name('user_access');
    Route::post('/users/access/{user_id}','UsersController@setUserAccess')->name('set_user_access');

    // Application Maintenance Routes
    Route::get('/apps','AppsController@index')->name('apps');
    Route::get('/apps/new/{app_type}','AppsController@newApp')->name('new_app');
    Route::post('/apps/new/{app_type}','AppsController@newApp')->name('create_app');
    Route::get('/apps/{app_type}/{app_id}','AppsController@showApp')->name('show_app');
    Route::post('/apps/{app_id}','AppsController@modifyApp')->name('modify_app');
    Route::get('/apps/new/{app_type}/{app_id}','AppsController@newApp')->name('new_child');
    Route::post('/apps/new/{app_type}/{app_id}','AppsController@newApp')->name('create_child');

    Route::get('/hris/setup','PagesController@hrsetup')->name("HRSETUP");
    // HRIS Routes
    // ** HR Setup **
    Route::get('/hris/divisions/list', 'DivisionsController@listDivisions')->name('list_divisions');
    Route::get('/hris/setup/divisions','DivisionsController@show')->name("divisions");
    Route::get('/hris/setup/divisions/new','DivisionsController@newRecord')->name("new_division");
    Route::post('/hris/setup/divisions/new','DivisionsController@newRecord')->name("create_division");
    Route::get('/hris/setup/divisions/{div_id}','DivisionsController@showRecord')->name("show_division");
    Route::post('/hris/setup/divisions/{div_id}','DivisionsController@modifyRecord')->name("modify_division");
    Route::get('/hris/setup/divisions/remove/{div_id}','DivisionsController@removeRecord')->name("remove_division");
    // Route::delete('/hris/setup/divisions/remove','DivisionsController@removeRecord')->name("remove_division");

    Route::get('/hris/departments/list', 'DepartmentsController@listDepartments')->name('list_departments');
    Route::get('/hris/setup/departments','DepartmentsController@show')->name("departments");
    Route::get('/hris/setup/departments/new','DepartmentsController@newRecord')->name("new_department");
    Route::post('/hris/setup/departments/new','DepartmentsController@newRecord')->name("create_department");
    Route::get('/hris/setup/departments/{dep_id}','DepartmentsController@showRecord')->name("show_department");
    Route::post('/hris/setup/departments/{dep_id}','DepartmentsController@modifyRecord')->name("modify_department");
    Route::get('/hris/setup/departments/remove/{dep_id}','DepartmentsController@removeRecord')->name("remove_department");
    Route::get('/hris/setup/departments/link/{dep_id}/{div_id}','DepartmentLinkController@linkDivision')->name("link_division");
    Route::get('/hris/setup/departments/unlink/{dep_id}/{div_id}','DepartmentLinkController@unlinkDivision')->name("unlink_division");

    Route::get('/hris/ranks/list', 'CorporateRanksController@listRanks')->name('list_ranks');
    Route::get('/hris/setup/corpranks','CorporateRanksController@show')->name("corporate_ranks");
    Route::get('/hris/setup/corpranks/new','CorporateRanksController@newRecord')->name("new_corporate_rank");
    Route::post('/hris/setup/corpranks/new','CorporateRanksController@newRecord')->name("create_corporate_rank");
    Route::get('/hris/setup/corpranks/{rank_id}','CorporateRanksController@showRecord')->name("show_corporate_rank");
    Route::post('/hris/setup/corpranks/{rank_id}','CorporateRanksController@modifyRecord')->name("modify_corporate_rank");
    Route::get('/hris/setup/corpranks/remove/{rank_id}','CorporateRanksController@removeRecord')->name("remove_corporate_rank");
    Route::get('/hris/setup/corpranks/changelevel/{rank_id}/{move}','CorporateRanksController@changeLevel')->name("change_corporate_rank");
    Route::get('/hris/setup/corpranks/assign/{rank_id}','CorporateRanksController@assignLevels')->name("assign_levels");
    Route::post('/hris/setup/corpranks/assign/assignment','CorporateRanksController@assignment')->name("corpassign_ajax");
    Route::post('/hris/setup/corpranks/assign/apply/{rank_id}','CorporateRanksController@applyAssignment')->name("corpapply_ajax");

    Route::get('/hris/positionlevels/list', 'PositionLevelsController@listLevels')->name('list_pos_levels');
    Route::get('/hris/setup/positionlevels','PositionLevelsController@show')->name("position_levels");
    Route::get('/hris/setup/positionlevels/new','PositionLevelsController@newRecord')->name("new_position_level");
    Route::post('/hris/setup/positionlevels/new','PositionLevelsController@newRecord')->name("create_position_level");
    Route::get('/hris/setup/positionlevels/{pos_id}','PositionLevelsController@showRecord')->name("show_position_level");
    Route::post('/hris/setup/positionlevels/{pos_id}','PositionLevelsController@modifyRecord')->name("modify_position_level");
    Route::get('/hris/setup/positionlevels/remove/{pos_id}','PositionLevelsController@removeRecord')->name("remove_position_level");
    Route::get('/hris/setup/positionlevels/changelevel/{pos_id}/{move}','PositionLevelsController@changeLevel')->name("change_position_level");

    Route::get('/hris/employmentstatus/list', 'EmploymentStatusController@listStatuses')->name('list_emp_status');
    Route::get('/hris/setup/empstatus','EmploymentStatusController@show')->name("emp_status");
    Route::get('/hris/setup/empstatus/new','EmploymentStatusController@newRecord')->name("new_emp_status");
    Route::post('/hris/setup/empstatus/new','EmploymentStatusController@newRecord')->name("create_emp_status");
    Route::get('/hris/setup/empstatus/{pos_id}','EmploymentStatusController@showRecord')->name("show_emp_status");
    Route::post('/hris/setup/empstatus/{pos_id}','EmploymentStatusController@modifyRecord')->name("modify_emp_status");
    Route::get('/hris/setup/empstatus/remove/{pos_id}','EmploymentStatusController@removeRecord')->name("remove_emp_status");
    Route::get('/hris/setup/empstatus/activate/{emp_id}/{status}','EmploymentStatusController@activate')->name("activate_emp_status");

    Route::get('/hris/taxstatus/list', 'TaxStatusController@listTaxStatuses')->name('list_tax_status');
    Route::get('/hris/setup/taxstatus','TaxStatusController@show')->name("tax_status");
    Route::get('/hris/setup/taxstatus/new','TaxStatusController@newRecord')->name("new_tax_status");
    Route::post('/hris/setup/taxstatus/new','TaxStatusController@newRecord')->name("create_tax_status");
    Route::get('/hris/setup/taxstatus/{tax_id}','TaxStatusController@showRecord')->name("show_tax_status");
    Route::post('/hris/setup/taxstatus/{tax_id}','TaxStatusController@modifyRecord')->name("modify_tax_status");
    Route::get('/hris/setup/taxstatus/remove/{tax_id}','TaxStatusController@removeRecord')->name("remove_tax_status");

    // **** AJAX ****
    Route::get('/hris/employee/getdept/{div_id}', function($div_id) {
        $departments = DeptLink::getDepartments($div_id);
        return $departments;
    });

    Route::get('/hris/employee/getlevels/{rank_id}', function($rank_id) {
        $levels = LevelLink::getLevels($rank_id);
        return $levels;
    });

    Route::get('/hris/employee/getsup/{div_id}/{dep_id}/{sup_id}', function($div_id,$dep_id,$pos_id) {
        $superiors = Employee::getQualifiedSuperiors($div_id, $dep_id, $pos_id);
        return $superiors;
    });

    Route::get('/hris/employee/supinfo/{sup_id}', function($sup_id) {
        $superior = Employee::find($sup_id);
        $data = [
            "position" => $superior->position,
            "level" => $superior->level->description,
            "email" => $superior->work_email,
        ];        
        return $data;
    });

    // ** Personnel Information **
    Route::get('/hris/employee/list', 'EmployeesController@listEmployees')->name('list_employees');
    Route::get('/hris/employee','EmployeesController@show')->name("PINFO");
    Route::get('/hris/employee/profile/{emp_id}','EmployeesController@viewProfile')->name("employee_profile");
    // Route::get('/hris/employee/profile/{emp_id}/pdf','EmployeesController@exportPDF')->name("pdf_profile");
    Route::get('/hris/employee/new','EmployeesController@newRecord')->name("new_employee");
    Route::post('/hris/employee/new','EmployeesController@newRecord')->name("create_employee");
    Route::get('/hris/employee/{emp_id}','EmployeesController@showRecord')->name("edit_employee");
    Route::post('/hris/employee/{emp_id}','EmployeesController@modifyRecord')->name("modify_employee");
    Route::get('/hris/employee/{emp_id}/audit','EmployeesController@auditTrail')->name("audit_employee");

    Route::get('/employee/{emp_id}/update/{update_id}', 'UserEditsController@viewProfileUpdate')->name('view_profile_update');
    
    Route::post('/employee/applyupdate', 'UserEditsController@applyUpdates')->name('apply_profile_update');
    Route::post('/employee/declineupdate', 'UserEditsController@declineUpdates')->name('decline_profile_update');

    Route::get('hris/dashboard', 'EmployeeChartsController@index')->name("HRDASH");

    // ** Dependents **
    Route::get('/hris/employee/{emp_id}/dependent','DependentsController@show')->name("dependents");
    Route::get('/hris/employee/{emp_id}/dependent/new','DependentsController@newRecord')->name("new_dependent");
    Route::post('/hris/employee/{emp_id}/dependent/new','DependentsController@newRecord')->name("create_dependent");
    Route::get('/hris/employee/{emp_id}/dependent/{dep_id}','DependentsController@showRecord')->name("edit_dependent");
    Route::post('/hris/employee/{emp_id}/dependent/{dep_id}','DependentsController@modifyRecord')->name("modify_dependent");
    Route::get('/hris/employee/{emp_id}/dependent/remove/{dep_id}','DependentsController@removeRecord')->name("remove_dependent");

    // ** Educational Background **
    Route::get('/hris/employee/{emp_id}/educbackground','EducationalBackgroundController@show')->name("educ_bgs");
    Route::get('/hris/employee/{emp_id}/educbackground/new','EducationalBackgroundController@newRecord')->name("new_educ_bg");
    Route::post('/hris/employee/{emp_id}/educbackground/new','EducationalBackgroundController@newRecord')->name("create_educ_bg");
    Route::get('/hris/employee/{emp_id}/educbackground/{ebg_id}','EducationalBackgroundController@showRecord')->name("edit_educ_bg");
    Route::post('/hris/employee/{emp_id}/educbackground/{ebg_id}','EducationalBackgroundController@modifyRecord')->name("modify_educ_bg");
    Route::get('/hris/employee/{emp_id}/educbackground/remove/{ebg_id}','EducationalBackgroundController@removeRecord')->name("remove_educ_bg");

    // ** Employment History **
    Route::get('/hris/employee/{emp_id}/employhist','EmploymentHistoryController@show')->name("emp_hist");
    Route::get('/hris/employee/{emp_id}/employhist/new','EmploymentHistoryController@newRecord')->name("new_emp_hist");
    Route::post('/hris/employee/{emp_id}/employhist/new','EmploymentHistoryController@newRecord')->name("create_emp_hist");
    Route::get('/hris/employee/{emp_id}/employhist/{ehist_id}','EmploymentHistoryController@showRecord')->name("edit_emp_hist");
    Route::post('/hris/employee/{emp_id}/employhist/{ehist_id}','EmploymentHistoryController@modifyRecord')->name("modify_emp_hist");
    Route::get('/hris/employee/{emp_id}/employhist/remove/{ehist_id}','EmploymentHistoryController@removeRecord')->name("remove_emp_hist");

    Route::get('/hris/employee/{emp_id}/employhist','EmploymentHistoryController@show')->name("emp_hist");

    // ** Employee Movement **
    Route::get('/hris/movement/list', 'EmployeeMovementController@probationary')->name('list_probi');
    Route::get('/hris/movement/activelist', 'EmployeeMovementController@activeEmployees')->name('list_active');

    Route::get('/hris/movement/regularization','EmployeeMovementController@regularization')->name("EMPMOVE");
    Route::post('/hris/movement/regularization','EmployeeMovementController@regularization')->name("regularize_employee");
    Route::get('/hris/movement/transfer','EmployeeMovementController@transfer')->name("emp_transfer");
    Route::post('/hris/movement/transfer','EmployeeMovementController@transfer')->name("transfer_employee");
    Route::get('/hris/movement/promotion','EmployeeMovementController@promotion')->name("emp_promote");
    Route::post('/hris/movement/promotion','EmployeeMovementController@promotion')->name("promote_employee");
    Route::get('/hris/movement/resignation','EmployeeMovementController@resignation')->name("emp_resign");
    Route::post('/hris/movement/resignation','EmployeeMovementController@resignation')->name("resign_employee");

    // OTKS Routes
    Route::get('/otks/setup','PagesController@tksetup')->name("TKSETUP");

    // LTS Routes
    Route::get('/lts/setup','PagesController@ltssetup')->name("LTSSETUP");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
