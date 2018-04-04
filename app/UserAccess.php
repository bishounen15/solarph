<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    //
    public function user() {
        return $this->belongsTo('App\User','user_id' ,'id');
    }
}
