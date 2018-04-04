<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PositionLevel as PositionLevel;

use DataTables;

class PositionLevelsController extends Controller
{
    //
    public function __construct( PositionLevel $position_level )
    {
        $this->position_level = $position_level->all();
    }

    public function show() {
        $data = [];
        $data['position_levels'] = PositionLevel::orderBy("level")->get();

        return view('hris.setup.positionlevels.show',$data);
    }

    public function newRecord(Request $request, PositionLevel $position_level)
    {
        $pos_instance = new PositionLevel();
        $data = [];

        $data['code'] = $request->input('code');
        $data['description'] = $request->input('description');
        $data['level'] = PositionLevel::maxLevel() + 1;
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:hris.position_levels',
                'description' => 'required|max:25|unique:hris.position_levels',
            ]);

            $position_level->create($data);
            return redirect('hris/setup/positionlevels');
        }

        $data['modify'] = 0;
        return view('hris.setup.positionlevels.form', $data);
    }

    public function modifyRecord(Request $request, PositionLevel $position_level, $pos_id)
    {
        $pos_instance = new PositionLevel();
        $data = [];

        $data['description'] = $request->input('description');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $dep_data = $this->position_level->find($pos_id);
            
            if ($dep_data->description != $data['description']) {
                $validation = 'required|max:25|unique:hris.position_levels';
            } else {
                $validation = 'required|max:25';
            }

            $this->validate($request, [
                'description' => $validation,
            ]);

            $dep_data->description = $data['description'];
            $dep_data->uid_modify = $data['uid_modify'];

            $dep_data->save();
            return redirect('hris/setup/positionlevels');
        }

        $data['modify'] = 0;
        return view('hris.setup.positionlevels.form', $data);
    }

    public function removeRecord($pos_id) {
        $dep_data = $this->position_level->find($pos_id);
        
        if ($dep_data->isUsed()) {
            return redirect('hris/setup/positionlevels')->with('fail',$dep_data->description.' could not be deleted as it was already associated with an existing employee.');
        } else {
            $dep_data->delete();
            return redirect('hris/setup/positionlevels');
        }
    }

    public function showRecord($pos_id){
        $data = [];

        $data['pos_id'] = $pos_id;
        $data['modify'] = 1;
                
        $dep_data = $this->position_level->find($pos_id);

        $data['code'] = $dep_data->code;
        $data['description'] = $dep_data->description;
        
        return view('hris.setup.positionlevels.form', $data);
    }

    public function changeLevel($pos_id, $move) {
        $pos_instance = new PositionLevel();
        $pos_data = $this->position_level->find($pos_id);
        
        if ($move == 1) {
            $swap_id = $pos_data->previousLevel()->id;
        } else {
            $swap_id = $pos_data->nextLevel()->id;
        }

        $pos_swap = $this->position_level->find($swap_id);

        $x = $pos_data->level;
        $y = $pos_swap->level;

        $pos_data->level = $y;
        $pos_swap->level = $x;

        $pos_data->save();
        $pos_swap->save();

        return redirect('hris/setup/positionlevels');
    }

    public function listLevels() {
        $pos_levels = PositionLevel::selectRaw('level, id, code, description')
                                        ->orderBy('level','asc');
        return Datatables::of($pos_levels)->make(true);
    }
}
