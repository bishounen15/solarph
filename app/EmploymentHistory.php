<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class EmploymentHistory extends Model implements Auditable
{
    protected $connection = 'hris';
    protected $fillable = [ 'employee_id', 'rec_ix', 'company', 'position', 'address', 'reason', 'start', 'end', 'duties', 'uid_create', 'uid_modify', ];

    use \OwenIt\Auditing\Auditable;
    //
    protected $auditInclude = [
        'company',
        'position',
        'address',
        'reason',
        'start',
        'end',
        'duties',
    ];

    public static function maxIndex($emp_id) {
        $max_index = DB::connection('hris')->table('employment_histories')
                                ->where('employee_id', $emp_id)
                                ->max('rec_ix');

        return $max_index;
    }
}
