<?php

use Illuminate\Database\Seeder;
use App\EmploymentStatus as EmploymentStatus;

class EmploymentStatusSeeder extends Seeder
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
            [ "code" => "REG", "description" => "Regular", "active" => 1, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "PROB", "description" => "Probationary", "active" => 1, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "PROJECT", "description" => "Project-Based", "active" => 1, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "TERM", "description" => "Terminated", "active" => 0, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "RESIGN", "description" => "Resigned", "active" => 0, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "EOC", "description" => "End of Contract", "active" => 0, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "REHIRE", "description" => "Rehired", "active" => 1, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "CONSULT", "description" => "Consultant", "active" => 1, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "TRANSFER", "description" => "Transfered", "active" => 1, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "DEC", "description" => "Deceased", "active" => 0, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
            [ "code" => "CONTR", "description" => "Contractual", "active" => 1, "uid_create" => "chris.nevalga@solarphilippines.ph" ],
        ];

        foreach($statuses as $status) {
            EmploymentStatus::create($status);
        }
    }
}
