<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class EmploymentStatus extends Model implements Auditable
{
    protected $connection = 'hris';
    protected $fillable = [
        'code','description', 'uid_create', 'uid_modify',
    ];
    
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude = [
        'code',
        'description',
        'active',
    ];
    //
    public function isUsed() {
        $data = DB::connection('hris')->table('employees')
                        ->where('stat_id', $this->id)
                        ->count();
        return $data;
    }
}
