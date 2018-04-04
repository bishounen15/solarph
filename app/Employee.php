<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\PositionLevel as PositionLevel;

use OwenIt\Auditing\Contracts\Auditable;

class Employee extends Model implements Auditable
{
    protected $connection = 'hris';
    protected $fillable = [
        'id_number',
        'last_name',
        'first_name',
        'middle_name',
        'date_hired',
        'div_id',
        'dep_id',
        'position',
        'rank_id',
        'pos_id',
        'stat_id',
        'locker_no',
        'tax_id',
        'sss',
        'tin',
        'pagibig',
        'philhealth',
        'prof_license',
        'license_no',
        'emergency_contact',
        'emergency_relation',
        'emergency_address',
        'emergency_number',
        'birth_date',
        'birth_place',
        'present_address',
        'provincial_address',
        'mobile_personal',
        'mobile_work',
        'email_personal',
        'email_work',
        'civil_status',
        'citizenship',
        'gender',
        'spouse_name',
        'spouse_occupation',
        'father_name',
        'father_occupation',
        'mother_name',
        'mother_occupation',
        'religion',
        'profile_photo',
        'uid_create',
        'uid_modify',
    ];

    use \OwenIt\Auditing\Auditable;
    //
    protected $auditInclude = [
        'id_number', 'last_name', 'first_name', 'middle_name', 'date_hired',
        'div_id', 'dep_id', 'position', 'rank_id', 'pos_id',
        'stat_id', 'sup_id', 'locker_no', 'tax_id', 'sss',
        'tin', 'pagibig', 'philhealth', 'prof_license', 'license_no',
        'emergency_contact', 'emergency_address', 'emergency_relation', 'emergency_number', 'birth_date',
        'birth_place', 'present_address', 'provincial_address', 'mobile_personal', 'mobile_work',
        'email_personal', 'email_work', 'civil_status', 'gender', 'religion',
        'spouse_name', 'spouse_occupation', 'father_name', 'father_occupation', 
        'mother_name', 'mother_occupation', 'profile_photo',
    ];

    public function age() {
        $data = DB::connection('hris')->table('employees')
                        ->selectRaw('FLOOR(DATEDIFF(NOW(),birth_date) / 365.25) AS age')
                        ->where('id', $this->id)
                        ->get();
        return $data->first()->age;
    }

    public function getFullName() {
        $full_name = $this->last_name . ', ' . $this->first_name . ' ' . $this->middle_name;
        return $full_name;
    }

    public static function getQualifiedSuperiors($div_id, $dep_id, $pos_id) {
        $pos_instance = PositionLevel::find($pos_id);
        $pos_level = $pos_instance->level;

        $data = Employee::where([
                            ['div_id', '=' , $div_id],
                            ['dep_id', '=' , $dep_id],
                        ])
                        ->whereExists(function ($query) use ($pos_level) {
                            $query->select(DB::connection('hris')->raw(1))
                                  ->from('position_levels')
                                  ->whereRaw('employees.pos_id = position_levels.id AND position_levels.level < ?',[$pos_level]);
                        })
                        ->get();
        return $data;
    }

    public function superior() {
        return $this->belongsTo('App\Employee','sup_id' ,'id');
    }

    public function division() {
        return $this->belongsTo('App\Division','div_id' ,'id');
    }

    public function department() {
        return $this->belongsTo('App\Department','dep_id' ,'id');
    }

    public function rank() {
        return $this->belongsTo('App\CorporateRank','rank_id' ,'id');
    }

    public function level() {
        return $this->belongsTo('App\PositionLevel','pos_id' ,'id');
    }

    public function corporateLevel() {
        $corporate_level = $this->join("corporate_ranks","employees.rank_id", "=", "corporate_ranks.id")
                                    ->join("position_levels","employees.pos_id","=","position_levels.id")
                                    ->join("level_links", function($join) {
                                        $join->on("employees.rank_id","=","level_links.rank_id")
                                                ->on("employees.pos_id","=","level_links.level_id");
                                    })
                                    ->select("corporate_ranks.level as corp","level_links.level")
                                    ->where("employees.id","=",$this->id)
                                    ->first();

        return $corporate_level;
    }

    public function status() {
        return $this->belongsTo('App\EmploymentStatus','stat_id' ,'id');
    }

    public function tax_status() {
        return $this->belongsTo('App\TaxStatus','tax_id' ,'id');
    }

    public function subordinates() {
        $subordinates = Employee::where('sup_id', '=' , $this->id)
                                        ->orderByRaw('last_name ASC, first_name ASC, middle_name ASC');
        return $subordinates->get();
    }

    public function dependents() {
        return $this->hasMany('App\Dependent');
    }

    public function educational_bg() {
        return $this->hasMany('App\EducationalBackground');
    }
    
    public function employment_hist() {
        return $this->hasMany('App\EmploymentHistory');
    }
}
