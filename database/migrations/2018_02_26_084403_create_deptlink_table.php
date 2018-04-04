<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeptlinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('hris')->dropIfExists('deptlink');
        Schema::connection('hris')->create('deptlink', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dep_id');
            $table->integer('div_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('hris')->dropIfExists('deptlink');
    }
}
