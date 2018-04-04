<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('hris')->dropIfExists('user_edits');
        Schema::connection('hris')->create('user_edits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('locker_no')->nullable();
            $table->string('sss')->nullable();
            $table->string('tin')->nullable();
            $table->string('pagibig')->nullable();
            $table->string('philhealth')->nullable();
            $table->string('prof_license')->nullable();
            $table->string('license_no')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_relation')->nullable();
            $table->string('emergency_address')->nullable();
            $table->string('emergency_number')->nullable();
            $table->date('birth_date')->nullable();
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
            $table->boolean('applied')->default(false);
            $table->string('response')->nullable();
            $table->integer('applied_by')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::connection('hris')->dropIfExists('user_edits');
    }
}
