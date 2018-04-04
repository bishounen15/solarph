<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\PositionLevel as PositionLevel;

class LevelLink extends Model
{
    //
    protected $connection = 'hris';
    
    public static function maxLevel($rank_id) {
        $max_level = DB::connection('hris')->table('level_links')
                                ->where("rank_id","=",$rank_id)
                                ->max('level');

        return $max_level;
    }

    public static function corpLevels($rank_id) {
        $corp_levels = LevelLink::join("position_levels","level_links.level_id","=","position_levels.id")
                                ->where("rank_id","=",$rank_id)
                                ->get();
        return $corp_levels;
    }

    public static function notLinked($rank_id) {
        $pos_levels = PositionLevel::whereNotExists(function ($query) use ($rank_id) {
                            $query->select(DB::raw(1))
                                  ->from('level_links')
                                  ->whereRaw('position_levels.id = level_links.level_id AND level_links.rank_id = ?',[$rank_id]);
                        })
                        ->get();
        return $pos_levels;
    }

    public static function getLevels($rank_id) {
        $departments = DB::connection('hris')->table('level_links')
                                ->join('position_levels','level_links.level_id','=','position_levels.id')
                                ->where(
                                    "rank_id","=",$rank_id
                                )
                                ->orderBy('level_links.level')
                                ->get();

        return $departments;
    }
}
