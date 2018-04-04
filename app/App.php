<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\UserAccess as UserAccess;

class App extends Model
{
    //
    protected $fillable = [
        'app_code','app_title','app_desc', 'parent_id', 'child_index', 'uid_create', 'uid_modify',
    ];

    public function parent() {
        return $this->belongsTo('App\App','parent_id' ,'id');
    }

    public function children() {
        $children = App::where('parent_id', '=' , $this->id)
                            ->orderBy('child_index','ASC');
        return $children->get();
    }

    public function access() {
        $access = UserAccess::where('app_id', '=' , $this->id);
        return $access->get();
    }

    public function countChild($parent_id) {
        $total_child = DB::table('apps')
                                ->where('parent_id', $parent_id)
                                ->count();

        return $total_child;
    }

    public function childApps($parent_id) {
        $child_apps = DB::table('apps')
                                ->where('parent_id', $parent_id)
                                ->orderBy('child_index')
                                ->get();

        return $child_apps;
    }
}
