<?php

use Illuminate\Database\Seeder;
use App\CorporateRank as CorporateRank;

class CorporateRanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ranks = [
            [
                "code" => "CORP",
                "description" => "Corporate Officer",
                "level" => 1,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SMGT",
                "description" => "Senior Management",
                "level" => 2,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "MMGT",
                "description" => "Middle Management",
                "level" => 3,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "LMGT",
                "description" => "Lower Management",
                "level" => 4,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SPC",
                "description" => "Specialists",
                "level" => 5,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "ASSOC",
                "description" => "Associates",
                "level" => 6,
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
        ];

        foreach($ranks as $rank) {
            CorporateRank::create($rank);
        }
    }
}
