<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAddDescFromApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('apps', function (Blueprint $table) {
            $table->renameColumn('add_desc', 'app_desc');
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
        Schema::table('apps', function (Blueprint $table) {
            $table->renameColumn('app_desc', 'add_desc');
        });
    }
}
