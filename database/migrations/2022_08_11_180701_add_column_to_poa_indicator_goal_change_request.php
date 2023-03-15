<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPoaIndicatorGoalChangeRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poa_indicator_goal_change_requests', function (Blueprint $table) {
            //
            $table->dropColumn('poa_activity_indicator_id');
            $table->dropColumn('indicator_id');
            $table->dropColumn('period');
            $table->dropColumn('poa_activity_id');
            $table->foreignId('measure_advance_id')->references('id')->on('msr_measure_advances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poa_indicator_goal_change_requests', function (Blueprint $table) {
            //
            $table->integer('poa_activity_indicator_id');
            $table->integer('indicator_id');
            $table->integer('period');
            $table->integer('poa_activity_id');
            $table->dropColumn('measure_advance_id');
        });
    }
}
