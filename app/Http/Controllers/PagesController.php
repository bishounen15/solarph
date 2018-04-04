<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Users;
use App\App as App;

class PagesController extends Controller
{
    //
    public function index() {
        return view('index');
    }

    public function myapps() {
        $data = [];
        $apps = App::whereExists(function ($query) {
                            $query->select(DB::raw(1))
                                ->from(DB::raw('apps b'))
                                ->join(DB::raw('user_accesses c'),DB::raw("b.id"),"=",DB::raw("c.app_id"))
                                ->whereRaw(DB::raw('apps.id = b.parent_id'));
                        })->get();

        $data['apps'] = $apps;
        return view('myapps',$data);
    }

    public function hrsetup() {
        return view("hris.setup.index");
    }

    public function pinfo() {
        return view("hris.employee.index");
    }

    public function tksetup() {
        return __METHOD__;
    }

    public function ltssetup() {
        return __METHOD__;
    }
}
