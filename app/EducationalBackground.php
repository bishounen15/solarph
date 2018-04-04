<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class EducationalBackground extends Model implements Auditable
{
    protected $connection = 'hris';
    protected $fillable = [
        'employee_id', 'rec_ix', 'level', 'degree', 'school', 'address', 'undergrad', 'graduate_year', 'uid_create', 'uid_modify',
    ];

    use \OwenIt\Auditing\Auditable;
    //
    protected $auditInclude = [
        'level',
        'degree',
        'school',
        'address',
        'undergrad',
        'graduate_year',
    ];

    public static function maxIndex($emp_id) {
        $max_index = DB::connection('hris')->table('educational_backgrounds')
                                ->where('employee_id', $emp_id)
                                ->max('rec_ix');

        return $max_index;
    }
}
