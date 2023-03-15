<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMeasureIdToPrjTasks extends Migration
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
            $table->dropColumn('indicator_id');
            $table->unsignedBigInteger('measure_id')->nullable();
            $table->foreign('measure_id')->references('id')->on('msr_measures');
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
            $table->foreignId('indicator_id');
            $table->dropColumn('measure_id');
        });
    }
}
