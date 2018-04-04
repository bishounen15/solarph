<?php

use Illuminate\Database\Seeder;
use App\PositionLevel as PositionLevel;

class PositionLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $levels = [
            [
                "code" => "PRES",
                "description" => "President",
                "level" => 1,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SVP",
                "description" => "Senior Vice President",
                "level" => 2,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "VP",
                "description" => "Vice President",
                "level" => 3,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SDIR",
                "description" => "Senior Director",
                "level" => 4,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "DIR",
                "description" => "Director",
                "level" => 5,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SMGR",
                "description" => "Senior Department Manager",
                "level" => 6,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "MGR",
                "description" => "Department Manager",
                "level" => 7,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SSEC",
                "description" => "Senior Section Manager",
                "level" => 6,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SEC",
                "description" => "Section Manager",
                "level" => 6,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "POFC",
                "description" => "Principal Officer",
                "level" => 7,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SOFC",
                "description" => "Senior Officer",
                "level" => 8,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "OFC",
                "description" => "Officer",
                "level" => 9,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "PASSOC",
                "description" => "Principal Associate",
                "level" => 10,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SASSOC",
                "description" => "Senior Associate",
                "level" => 11,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "ASSOC",
                "description" => "Associate",
                "level" => 12,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
        ];

        foreach($levels as $level) {
            PositionLevel::create($level);
        }
    }
}
