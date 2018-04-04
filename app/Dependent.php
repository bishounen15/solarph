<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Dependent extends Model implements Auditable
{
    protected $connection = 'hris';
    protected $fillable = [
        'employee_id','rec_ix','name', 'relation', 'birth_date', 'gender', 'uid_create', 'uid_modify',
    ];
    //
    // public function employee() {
    //     return $this->belongsTo('App\Employee','employee_id' ,'id');
    // }
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude = [
        'name',
        'relation',
        'birth_date',
        'gender',
    ];      

    public function age() {
        $data = DB::connection('hris')->table('dependents')
                        ->selectRaw('FLOOR(DATEDIFF(NOW(),birth_date) / 365.25) AS age')
                        ->where('id', $this->id)
                        ->get();
        return $data->first()->age;
    }

    public static function maxIndex($emp_id) {
        $max_index = DB::connection('hris')->table('dependents')
                                ->where('employee_id', $emp_id)
                                ->max('rec_ix');

        return $max_index;
    }
}
