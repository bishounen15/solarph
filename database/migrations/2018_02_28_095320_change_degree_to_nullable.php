<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDegreeToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('hris')->table('educational_backgrounds', function (Blueprint $table) {
            $table->string('degree')->nullable()->change();
            $table->boolean('undergrad')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection('hris')->table('educational_backgrounds', function (Blueprint $table) {
            $table->string('degree')->change();
            $table->boolean('undergrad')->change();
        });
    }
}
