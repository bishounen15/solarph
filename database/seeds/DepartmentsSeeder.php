<?php

use Illuminate\Database\Seeder;
use App\Department as Department;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $departments = [
            [
                "code" => "ADM",
                "description" => "Administration",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "BD",
                "description" => "Business Development",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "CBG",
                "description" => "Commercial Busuness Group",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "CONS",
                "description" => "Construction",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "DES",
                "description" => "Design",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "FIN",
                "description" => "Finance",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "HR",
                "description" => "Human Resources",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "IBD",
                "description" => "International Business Development",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "LAND",
                "description" => "Land Acquisition",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "LEGAL",
                "description" => "Legal",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "MAN",
                "description" => "ManCom",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "MAR",
                "description" => "Marketing",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "OOTC",
                "description" => "Office of the CEO",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "PARC",
                "description" => "Permitting and Regulatory Compliance",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "PD",
                "description" => "Project Development",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "PDMG",
                "description" => "Product Management",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "PLMG",
                "description" => "Plant Management",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "PM",
                "description" => "Project Management",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "PWMK",
                "description" => "Power Marketing",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "QAIT",
                "description" => "Quality and Information Technology",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "RS",
                "description" => "Rooftop Sales",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SC",
                "description" => "Supply Chain",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
        ];

        foreach($departments as $department) {
            Department::create($department);
        }
        
        $depts = Department::all();

        foreach($depts as $dept) {
            DB::connection('hris')->table('deptlink')->insert(
                ['dep_id' => $dept->id, 'div_id' => 1]
            );
        }
    }
}
