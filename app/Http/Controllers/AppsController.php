<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use App\App as App;

class AppsController extends Controller
{
    //
    public function __construct( App $app )
    {
        $this->app = $app->all();
    }

    public function index() {
        $data = [];
        $all_apps = App::where('parent_id', 0)->get();

        $data['apps'] = $all_apps;
        return view('apps.index', $data);
    }

    public function newApp(Request $request, App $app, $app_type, $app_id = 0)
    {
        $app_instance = new App();
        $data = [];

        $data['app_code'] = $request->input('app_code');
        $data['app_title'] = $request->input('app_title');
        $data['app_desc'] = $request->input('app_desc');
        $data['parent_id'] = $request->input('parent_id');

        if ($request->input('parent_id') == 0) { $child_index = 0; } else { $child_index = $app_instance->countChild($request->input('parent_id')) + 1; }

        $data['child_index'] = $child_index;
        $data['uid_create'] = auth::user()->email;
        $data['uid_modify'] = "";
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'app_code' => 'required|max:15|unique:apps',
                'app_title' => 'required|max:25|unique:apps',
            ]);

            if ($request->hasFile('app_image')) {
                $filenameWithExt = $request->file('app_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
                $extension = $request->file('app_image')->getClientOriginalExtension();
                $filenameToStore = $data['app_code'].".".$extension;

                $path = $request->file('app_image')->storeAs('public/images',$filenameToStore);
            }

            $app->create($data);
            return redirect('apps');
        }

        $data['app_type'] = $app_type;
        $data['app_id'] = $app_id;
        $data['modify'] = 0;
        return view('apps/form', $data);
    }

    public function modifyApp(Request $request, App $app, $app_id)
    {
        $app_instance = new App();
        $data = [];

        $data['app_title'] = $request->input('app_title');
        $data['app_desc'] = $request->input('app_desc');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $app_data = $this->app->find($app_id);
            
            if ($app_data->app_title != $data['app_title']) {
                $title_validation = 'required|max:25|unique:apps';
            } else {
                $title_validation = 'required|max:25';
            }

            $this->validate($request, [
                'app_title' => $title_validation,
            ]);

            if ($request->hasFile('app_image')) {
                $filenameWithExt = $request->file('app_image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
                $extension = $request->file('app_image')->getClientOriginalExtension();
                $filenameToStore = $app_data->app_code.".".$extension;

                $path = $request->file('app_image')->storeAs('public/images',$filenameToStore);
            }

            $app_data->app_title = $data['app_title'];
            $app_data->app_desc = $data['app_desc'];
            $app_data->uid_modify = $data['uid_modify'];

            $app_data->save();
            return redirect('apps');
        }

        $data['app_type'] = $app_type;
        $data['app_id'] = $app_id;
        $data['modify'] = 0;
        return view('apps/form', $data);
    }

    public function showApp($app_type, $app_id)
    {
        $data = [];

        $data['selected_app_id'] = $app_id;
        $data['modify'] = 1;
        $data['app_type'] = $app_type;
        $data['app_id'] = $app_id;
                
        $app_data = $this->app->find($app_id);

        $data['app_code'] = $app_data->app_code;
        $data['app_title'] = $app_data->app_title;
        $data['app_desc'] = $app_data->app_desc;
        $data['parent_id'] = $app_data->parent_id;
        $data['child_index'] = $app_data->child_index;
        $data['uid_create'] = $app_data->uid_create;
        $data['uid_modify'] = $app_data->uid_modify;
        
        return view('apps/form', $data);
    }
}
