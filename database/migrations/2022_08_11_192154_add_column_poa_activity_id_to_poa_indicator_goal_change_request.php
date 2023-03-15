<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPoaActivityIdToPoaIndicatorGoalChangeRequest extends Migration
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
            $table->integer('period')->nullable();
            $table->foreignId('poa_activity_id')->references('id')->on('poa_activities');

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
        });
    }
}
