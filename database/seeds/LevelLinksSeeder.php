<?php

use Illuminate\Database\Seeder;
use App\LevelLink as LevelLink;

class LevelLinksSeeder extends Seeder
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
            [ "rank_id" => 1, "level_id" => 1, "level" => 1, ],
            [ "rank_id" => 1, "level_id" => 2, "level" => 2, ],
            [ "rank_id" => 1, "level_id" => 3, "level" => 3, ],
            [ "rank_id" => 2, "level_id" => 3, "level" => 1, ],
            [ "rank_id" => 2, "level_id" => 4, "level" => 2, ],
            [ "rank_id" => 2, "level_id" => 5, "level" => 3, ],
            [ "rank_id" => 3, "level_id" => 5, "level" => 1, ],
            [ "rank_id" => 3, "level_id" => 6, "level" => 2, ],
            [ "rank_id" => 3, "level_id" => 7, "level" => 3, ],
            [ "rank_id" => 4, "level_id" => 7, "level" => 1, ],
            [ "rank_id" => 4, "level_id" => 8, "level" => 2, ],
            [ "rank_id" => 4, "level_id" => 9, "level" => 3, ],
            [ "rank_id" => 5, "level_id" => 10, "level" => 1, ],
            [ "rank_id" => 5, "level_id" => 11, "level" => 2, ],
            [ "rank_id" => 5, "level_id" => 12, "level" => 3, ],
            [ "rank_id" => 6, "level_id" => 13, "level" => 1, ],
            [ "rank_id" => 6, "level_id" => 14, "level" => 2, ],
            [ "rank_id" => 6, "level_id" => 15, "level" => 3, ],
        ];

        foreach($levels as $level) {
            LevelLink::create($level);
        }
    }
}
