<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupId extends Migration
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
            $table->integer('sup_id')->nullable()->after('stat_id');
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
            $table->dropColumn('sup_id');
        });
    }
}
