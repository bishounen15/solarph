<?php

use Illuminate\Database\Seeder;
use App\TaxStatus as TaxStatus;

class TaxStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = [
            [ "code" => "M", "description" => "Married", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "ME1", "description" => "Married w/ 1 Dependent", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "ME2", "description" => "Married w/ 2 Dependents", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "ME3", "description" => "Married w/ 3 Dependents", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "ME4", "description" => "Married w/ 4 Dependents", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "S", "description" => "Single", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "S1", "description" => "Single w/ 1 Dependent", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "S2", "description" => "Single w/ 2 Dependents", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "S3", "description" => "Single w/ 3 Dependents", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "S4", "description" => "Single w/ 4 Dependents", "uid_create" => "chris.nevalga@solarphilippines.ph" ],
        ];

        foreach($statuses as $status) {
            TaxStatus::create($status);
        }
    }
}
