<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeptLink extends Model
{
    //
    protected $connection = 'hris';
    protected $fillable = [
        'div_id','dep_id',
    ];

    public function checkLink($dep_id, $div_id) {
        $isLinked = DB::connection('hris')->table('deptlink')
                                ->where([
                                    ["dep_id","=",$dep_id],
                                    ["div_id","=",$div_id],
                                ])
                                ->count();
        return $isLinked;
    }

    public function getLink($dep_id, $div_id) {
        $myLink = DB::connection('hris')->table('deptlink')
                                ->where([
                                    ["dep_id","=",$dep_id],
                                    ["div_id","=",$div_id],
                                ])
                                ->get();

        return $myLink;
    }

    public static function getDepartments($div_id) {
        $departments = DB::connection('hris')->table('deptlink')
                                ->join('departments','deptlink.dep_id','=','departments.id')
                                ->where(
                                    "div_id","=",$div_id
                                )
                                ->orderBy('departments.description')
                                ->get();

        return $departments;
    }
}
