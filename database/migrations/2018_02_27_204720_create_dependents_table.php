<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('hris')->dropIfExists('dependents');
        Schema::connection('hris')->create('dependents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('rec_ix');
            $table->string('name');
            $table->string('relation');
            $table->date('birth_date');
            $table->string('gender');
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
        Schema::connection('hris')->dropIfExists('dependents');
    }
}
