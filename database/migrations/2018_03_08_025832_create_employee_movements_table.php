<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('hris')->dropIfExists('employee_movements');
        Schema::connection('hris')->create('employee_movements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->date('effectivity');
            $table->string('type');
            $table->string('details');
            $table->string('remarks');
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
        Schema::connection('hris')->dropIfExists('employee_movements');
    }
}
