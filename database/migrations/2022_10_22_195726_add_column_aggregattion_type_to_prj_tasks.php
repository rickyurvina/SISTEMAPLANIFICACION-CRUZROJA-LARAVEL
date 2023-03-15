<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAggregattionTypeToPrjTasks extends Migration
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
            $table->string('aggregation_type')->nullable();
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
            $table->dropColumn('aggregation_type');

        });
    }
}
