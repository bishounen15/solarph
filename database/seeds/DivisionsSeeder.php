<?php

use Illuminate\Database\Seeder;
use App\Division as Division;

class DivisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $divisions = [
            [
                "code" => "SPCRPI",
                "description" => "Solar Philippines Commercial Rooftop Projects Inc.",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
            [
                "code" => "SPMMC",
                "description" => "Solar Philippines Module Manufacturing Corp.",
                "uid_create" => "chris.nevalga@solarphilippines.ph",
                "uid_modify" => "",
            ],
        ];

        foreach($divisions as $division) {
            Division::create($division);
        }
    }
}
