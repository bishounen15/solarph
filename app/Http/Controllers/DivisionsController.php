<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Division as Division;

use DataTables;

class DivisionsController extends Controller
{
    //
    public function __construct( Division $division )
    {
        $this->division = $division->all();
    }

    public function show() {
        $data = [];
        $data['divisions'] = $this->division->all();

        return view('hris.setup.divisions.show',$data);
    }

    public function newRecord(Request $request, Division $division)
    {
        $div_instance = new Division();
        $data = [];

        $data['code'] = $request->input('code');
        $data['description'] = $request->input('description');
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:hris.divisions',
                'description' => 'required|max:50|unique:hris.divisions',
            ]);

            $division->create($data);
            return redirect('hris/setup/divisions');
        }

        $data['modify'] = 0;
        return view('hris.setup.divisions.form', $data);
    }

    public function modifyRecord(Request $request, Division $division, $div_id)
    {
        $div_instance = new Division();
        $data = [];

        $data['description'] = $request->input('description');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $div_data = $this->division->find($div_id);
            
            if ($div_data->description != $data['description']) {
                $validation = 'required|max:50|unique:hris.divisions';
            } else {
                $validation = 'required|max:50';
            }

            $this->validate($request, [
                'description' => $validation,
            ]);

            $div_data->description = $data['description'];
            $div_data->uid_modify = $data['uid_modify'];

            $div_data->save();
            return redirect('hris/setup/divisions');
        }

        $data['modify'] = 0;
        return view('hris.setup.divisions.form', $data);
    }

    public function removeRecord($div_id) {
        $div_data = $this->division->find($div_id);

        if ($div_data->isUsed()) {
            return redirect('hris/setup/divisions')->with('fail',$div_data->description.' could not be deleted as it was already associated with an existing department.');
        } else {
            $div_data->delete();
            return redirect('hris/setup/divisions');
        }
    }

    public function showRecord($div_id){
        $data = [];

        $data['div_id'] = $div_id;
        $data['modify'] = 1;
                
        $div_data = $this->division->find($div_id);

        $data['code'] = $div_data->code;
        $data['description'] = $div_data->description;
        
        return view('hris.setup.divisions.form', $data);
    }

    public function listDivisions() {
        $divisions = Division::selectRaw('id, code, description');
        return Datatables::of($divisions)->make(true);
    }
}
