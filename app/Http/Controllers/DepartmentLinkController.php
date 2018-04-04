<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DeptLink as DeptLink;

class DepartmentLinkController extends Controller
{
    //
    public function linkDivision($dep_id, $div_id) {
        DB::connection('hris')->table('deptlink')->create(
            ['dep_id' => $dep_id, 'div_id' => $div_id]
        );
        return redirect('hris/setup/departments');
    }

    public function unlinkDivision($dep_id, $div_id) {
        DB::connection('hris')->table('deptlink')->where([
            ["dep_id","=",$dep_id],
            ["div_id","=",$div_id],
        ])->delete();
        return redirect('hris/setup/departments');
    }
}
