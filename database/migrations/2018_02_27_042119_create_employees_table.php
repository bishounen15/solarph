<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('hris')->dropIfExists('employees');
        Schema::connection('hris')->create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_number');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->date('date_hired');
            $table->integer('div_id');
            $table->integer('dep_id');
            $table->string('position');
            $table->integer('pos_id');
            $table->integer('stat_id');
            $table->string('locker_no')->nullable();
            $table->integer('tax_id');
            $table->string('sss')->nullable();
            $table->string('tin')->nullable();
            $table->string('pagibig')->nullable();
            $table->string('philhealth')->nullable();
            $table->string('prof_license')->nullable();
            $table->string('license_no')->nullable();
            $table->string('emergency_contact');
            $table->string('emergency_relation');
            $table->string('emergency_address');
            $table->string('emergency_number');
            $table->date('birth_date');
            $table->string('birth_place')->nullable();
            $table->string('present_address')->nullable();
            $table->string('provincial_address')->nullable();
            $table->string('mobile_personal')->nullable();
            $table->string('mobile_work')->nullable();
            $table->string('email_personal')->nullable();
            $table->string('email_work')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('gender')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_occupation')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('religion')->nullable();
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
        Schema::connection('hris')->dropIfExists('employees');
    }
}
