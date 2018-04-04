<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class TaxStatus extends Model implements Auditable
{
    protected $connection = 'hris';
    protected $fillable = [
        'code','description', 'uid_create', 'uid_modify',
    ];
    
    use \OwenIt\Auditing\Auditable;
    //
    protected $auditInclude = [
        'code',
        'description',
    ];
    public function isUsed() {
        $data = DB::connection('hris')->table('employees')
                        ->where('tax_id', $this->id)
                        ->count();
        return $data;
    }
}
