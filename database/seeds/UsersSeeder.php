<?php

use Illuminate\Database\Seeder;
use App\User as User;
use App\App as App;
use App\UserAccess as UserAccess;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = User::create([
            "user_id" => "000000",
            "employee_id" => 0,
            "name" => "System Administrator",
            "email" => "system.admin@solarphilippines.ph",
            "password" => bcrypt("password@1"),
            "initialized" => 1,
        ]);

        $apps = App::where("parent_id","<>","0")->get();

        foreach($apps as $app) {
            $app_access = UserAccess::create([
                "app_id" => $app->id,
                "user_id" => 1,
            ]);
        }
    }
}
