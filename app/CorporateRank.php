<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class CorporateRank extends Model implements Auditable
{
    protected $connection = 'hris';
    protected $fillable = [
        'code','description','level', 'uid_create', 'uid_modify',
    ];

    use \OwenIt\Auditing\Auditable;

    protected $auditInclude = [
        'code',
        'description',
        'level',
    ];
    
    public function isUsed() {
        $data = DB::connection('hris')->table('employees')
                        ->where('rank_id', $this->id)
                        ->count();
        return $data;
    }

    public static function maxID() {
        $max_id = DB::connection('hris')->table('corporate_ranks')
                                ->max('id');

        return $max_id;
    }

    public static function maxLevel() {
        $max_level = DB::connection('hris')->table('corporate_ranks')
                                ->max('level');

        return $max_level;
    }

    public function previousLevel() {
        $previous_level = DB::connection('hris')->table('corporate_ranks')
                                ->where('level','<',$this->level)
                                ->orderBy('level','desc')
                                ->get();

        return $previous_level->first();
    }

    public function nextLevel() {
        $next_level = DB::connection('hris')->table('corporate_ranks')
                                ->where('level','>',$this->level)
                                ->orderBy('level','asc')
                                ->get();

        return $next_level->first();
    }
}
