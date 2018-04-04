<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationalBackgroundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('hris')->dropIfExists('educational_backgrounds');
        Schema::connection('hris')->create('educational_backgrounds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('rec_ix');
            $table->string('level');
            $table->string('degree');
            $table->string('school');
            $table->string('address');
            $table->boolean('undergrad');
            $table->integer('graduate_year');
            $table->string('uid_create');
            $table->string('uid_modify')->nullable();
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
        Schema::connection('hris')->dropIfExists('educational_backgrounds');
    }
}
