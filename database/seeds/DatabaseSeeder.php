<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            AppsSeeder::class,
            UsersSeeder::class,
            DivisionsSeeder::class,
            DepartmentsSeeder::class,
            CorporateRanksSeeder::class,
            PositionLevelsSeeder::class,
            LevelLinksSeeder::class,
            EmploymentStatusSeeder::class,
            TaxStatusSeeder::class,
        ]);
    }
}
