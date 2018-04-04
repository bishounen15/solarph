<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Employee as Employee;

use ConsoleTVs\Charts\Classes\Chartjs\Chart as Charts;

class EmployeeChartsController extends Controller
{
    //
    private $rgb = [
        '0,0,255','255,0,0','0,255,0','200,55,0','0,200,55','55,0,200','150,105,0','0,150,105','105,0,150','100,155,0',
        '0,100,155','155,0,100','50,205,0','0,50,205','50,0,205','100,100,100','255,150,50','50,150,255','255,255,0','0,255,255',
        '255,0,255','150,150,150','255,150,255','255,255,150','150,255,255',
    ];

    public function index() {
        $charts = [];

        $query_results = DB::connection('hris')->table('employees')
                                        ->selectRaw("departments.description as category, COUNT(*) AS total")
                                        ->join('departments','employees.dep_id','=','departments.id')
                                        ->join('employment_statuses','employees.stat_id','=','employment_statuses.id')
                                        ->where('employment_statuses.active','=','1')
                                        ->groupBy("departments.description")
                                        ->orderBy('total','desc')
                                        ->get();

        array_push($charts,$this->generateChart($query_results,'Active Employees per Department','bar', false, false));

        $query_results = DB::connection('hris')->table('employees')
                                        ->selectRaw("TRIM(BOTH ' ' FROM IFNULL(CASE employees.gender WHEN '' THEN 'Not Set' ELSE employees.gender END,'Not Set')) as category, COUNT(*) AS total")
                                        ->join('employment_statuses','employees.stat_id','=','employment_statuses.id')
                                        ->where('employment_statuses.active','=','1')
                                        ->groupBy(DB::raw("TRIM(BOTH ' ' FROM IFNULL(CASE employees.gender WHEN '' THEN 'Not Set' ELSE employees.gender END,'Not Set'))"))
                                        ->orderBy('total','asc')
                                        ->get();

        array_push($charts,$this->generateChart($query_results,'Active Employees per Gender','bar'));

        $query_results = DB::connection('hris')->table('employees')
                                        ->selectRaw("employment_statuses.description as category, COUNT(*) AS total")
                                        ->join('employment_statuses','employees.stat_id','=','employment_statuses.id')
                                        ->where('employment_statuses.active','=','1')
                                        ->groupBy("employment_statuses.description")
                                        ->orderBy('total','desc')
                                        ->get();

        array_push($charts,$this->generateChart($query_results,'Active Employees per Employment Status','bar',false,true));

        // dd($charts);

        return view('hris.dashboard.index',['charts' => $charts]);                    
    }

    private function generateChart($query_results, $title, $type, $minimalist = false, $legend = true) {
        $results = json_decode($query_results);
        $chart = new Charts;
        // Add the dataset (we will go with the chart template approach)
        $chart->title($title, 34);
        $chart->minimalist($minimalist);
        $chart->barWidth(0.75); 
        $chart->displayLegend($legend);

        $colors = [];
        $bgcolors = [];
        $data = [];
        $labels = [];
        
        $i = 0;

        foreach($results as $result) {
            array_push($colors,'rgb('.$this->rgb[$i].')');
            array_push($bgcolors,'rgba('.$this->rgb[$i].',0.6)');
            
            array_push($data,$result->total);
            array_push($labels,$result->category);
            
            // array_push($labels,$result->category . " [" . $result->total . "]");
            
            if ($i == 24) {
                $i = 0;
            } else {
                $i++;
            }
        }

        $chart->dataset('',$type, $data)->color($colors)->backgroundColor($bgcolors);
        $chart->labels($labels);
        
        return $chart;
    }
}
