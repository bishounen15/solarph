<?php

use Illuminate\Database\Seeder;
use App\App as App;

class AppsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $apps = [
            [
                "app_code" => "HRIS",
                "app_title" => "HRIS System",
                "app_desc" => "-",
                "parent_id" => 0,
                "child_index" => 0,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "app_code" => "HRSETUP",
                "app_title" => "HRIS Setup",
                "app_desc" => "-",
                "parent_id" => 1,
                "child_index" => 1,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "app_code" => "PINFO",
                "app_title" => "Personnel Information",
                "app_desc" => "-",
                "parent_id" => 1,
                "child_index" => 2,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "app_code" => "EMPMOVE",
                "app_title" => "Employee Movement",
                "app_desc" => "-",
                "parent_id" => 1,
                "child_index" => 3,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "app_code" => "HRDASH",
                "app_title" => "HR Dashboard",
                "app_desc" => "-",
                "parent_id" => 1,
                "child_index" => 4,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
        ];

        foreach($apps as $app) {
            App::create($app);
        }
    }
}
