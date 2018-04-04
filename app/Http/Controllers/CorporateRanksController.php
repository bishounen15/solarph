<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\CorporateRank as CorporateRank;
use App\LevelLink as LevelLink;
use App\PositionLevel as PositionLevel;

use DataTables;

class CorporateRanksController extends Controller
{
    //
    public function __construct( CorporateRank$corporate_rank )
    {
        $this->corporate_rank = $corporate_rank->all();
    }

    public function show() {
        return view('hris.setup.corpranks.show');
    }

    public function newRecord(Request $request, CorporateRank $corporate_rank)
    {
        $rank_instance = new CorporateRank();
        $data = [];

        $data['code'] = $request->input('code');
        $data['description'] = $request->input('description');
        $data['level'] = CorporateRank::maxLevel() + 1;
        $data['uid_create'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:hris.corporate_ranks',
                'description' => 'required|max:25|unique:hris.corporate_ranks',
            ]);

            $corporate_rank->create($data);
            return redirect('hris/setup/corpranks');
        }

        $data['modify'] = 0;
        return view('hris.setup.corpranks.form', $data);
    }

    public function modifyRecord(Request $request, CorporateRank $corporate_rank, $rank_id)
    {
        $rank_instance = new CorporateRank();
        $data = [];

        $data['description'] = $request->input('description');
        $data['uid_modify'] = auth::user()->email;
        
        if ($request->isMethod('post')) {
            $rank_data = $this->corporate_rank->find($rank_id);
            
            if ($rank_data->description != $data['description']) {
                $validation = 'required|max:25|unique:hris.corporate_ranks';
            } else {
                $validation = 'required|max:25';
            }

            $this->validate($request, [
                'description' => $validation,
            ]);

            $rank_data->description = $data['description'];
            $rank_data->uid_modify = $data['uid_modify'];

            $rank_data->save();
            return redirect('hris/setup/corpranks');
        }

        $data['modify'] = 1;
        return view('hris.setup.corpranks.form', $data);
    }

    public function removeRecord($rank_id) {
        $rank_data = $this->corporate_rank->find($rank_id);
        
        if ($rank_data->isUsed()) {
            return redirect('hris/setup/corpranks')->with('fail',$rank_data->description.' could not be deleted as it was already associated with an existing employee.');
        } else {
            $rank_data->delete();
            return redirect('hris/setup/corpranks');
        }
    }

    public function showRecord($rank_id){
        $data = [];

        $data['rank_id'] = $rank_id;
        $data['modify'] = 1;
                
        $rank_data = $this->corporate_rank->find($rank_id);

        $data['code'] = $rank_data->code;
        $data['description'] = $rank_data->description;
        
        return view('hris.setup.corpranks.form', $data);
    }

    public function changeLevel($rank_id, $move) {
        $rank_instance = new CorporateRank();
        $pos_data = $this->corporate_rank->find($rank_id);
        
        if ($move == 1) {
            $swap_id = $pos_data->previousLevel()->id;
        } else {
            $swap_id = $pos_data->nextLevel()->id;
        }

        $pos_swap = $this->corporate_rank->find($swap_id);

        $x = $pos_data->level;
        $y = $pos_swap->level;

        $pos_data->level = $y;
        $pos_swap->level = $x;

        $pos_data->save();
        $pos_swap->save();

        return redirect('hris/setup/corpranks');
    }

    public function listRanks() {
        $corp_ranks = CorporateRank::selectRaw('level, id, code, description')
                                        ->orderBy('level','asc');
        return Datatables::of($corp_ranks)->make(true);
    }

    public function assignLevels($rank_id) {
        $data = [];
        $data['rank'] = $this->corporate_rank->find($rank_id);
        $data['levels'] = LevelLink::notLinked($rank_id);
        $data['assigned_levels'] = LevelLink::corpLevels($rank_id);
        return view('hris.setup.corpranks.assign', $data);
    }

    public function assignment(Request $request) {
        $ids = [];
        foreach($request->input('assign') as $level) {
            array_push($ids,$level);
        }

        $pos = DB::connection('hris')->table('position_levels')->whereIn('id', $ids)
                                ->get();
        
        return $pos;
    }

    public function applyAssignment(Request $request, $rank_id) {
        $currLevels = DB::connection('hris')->table('level_links')->where("rank_id","=",$rank_id)->delete();

        foreach($request->input('unassign') as $level) {
            LevelLink::insert([
                "rank_id" => $rank_id,
                "level_id" => $level,
                "level" => LevelLink::maxLevel($rank_id) + 1,
            ]);
        }        

        return 'true';
    }
}
