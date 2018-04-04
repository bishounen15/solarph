<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Department extends Model implements Auditable
{
    protected $connection = 'hris';
    protected $fillable = [
        'code','description', 'uid_create', 'uid_modify',
    ];

    use \OwenIt\Auditing\Auditable;

    protected $auditInclude = [
        'code',
        'description',
    ];
    //
    public function isUsed() {
        $data = DB::connection('hris')->table('employees')
                        ->where('dep_id', $this->id)
                        ->count();
        return $data;
    }

    public function associated($div_id) {
        $data = DB::connection('hris')->table('deptlink')
                        ->where([
                            ["dep_id","=",$this->id],
                            ["div_id","=",$div_id],
                        ])
                        ->count();
        return $data;
    }
}
