<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmploymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('hris')->dropIfExists('employment_histories');
        Schema::connection('hris')->create('employment_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('rec_ix');
            $table->string('company');
            $table->string('position');
            $table->string('address');
            $table->string('reason');
            $table->date('start');
            $table->date('end');
            $table->text('duties');
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
        Schema::connection('hris')->dropIfExists('employment_histories');
    }
}
