<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPrjTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prj_tasks', function (Blueprint $table) {
            //
            $table->dropColumn('impact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prj_tasks', function (Blueprint $table) {
            //
            $table->integer('impact')->default(1)->nullable();

        });
    }
}
