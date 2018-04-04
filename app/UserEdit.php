<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEdit extends Model
{
    //
    protected $connection = 'hris';
    public $fillable = [
        'user_id', 'last_name', 'first_name', 'middle_name', 'date_hired',
        'locker_no', 'sss', 'tin', 'pagibig', 'philhealth', 'prof_license', 'license_no',
        'emergency_contact', 'emergency_address', 'emergency_relation', 'emergency_number', 'birth_date',
        'birth_place', 'present_address', 'provincial_address', 'mobile_personal', 'mobile_work',
        'email_personal', 'email_work', 'civil_status', 'gender', 'religion',
        'spouse_name', 'spouse_occupation', 'father_name', 'father_occupation', 
        'mother_name', 'mother_occupation', 'applied', 'response', 'applied_by', 'remarks',
    ];

    public function employee() {
        return $this->belongsTo('App\Employee','user_id' ,'id');
    }

    public $editable_columns = [
        'last_name', 'first_name', 'middle_name', 'date_hired',
        'locker_no', 'sss', 'tin', 'pagibig', 'philhealth', 'prof_license', 'license_no',
        'emergency_contact', 'emergency_address', 'emergency_relation', 'emergency_number', 'birth_date',
        'birth_place', 'present_address', 'provincial_address', 'mobile_personal', 'mobile_work',
        'email_personal', 'email_work', 'civil_status', 'gender', 'religion',
        'spouse_name', 'spouse_occupation', 'father_name', 'father_occupation', 
        'mother_name', 'mother_occupation',
    ];
}
