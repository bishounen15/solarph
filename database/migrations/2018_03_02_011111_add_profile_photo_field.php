<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfilePhotoField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('hris')->table('employees', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('id_number');
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
        Schema::connection('hris')->table('employees', function (Blueprint $table) {
            $table->dropColumn('profile_photo');
        });
    }
}
