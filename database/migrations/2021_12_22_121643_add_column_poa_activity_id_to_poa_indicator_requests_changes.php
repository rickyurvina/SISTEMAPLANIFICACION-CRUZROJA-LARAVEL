<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPoaActivityIdToPoaIndicatorRequestsChanges extends Migration
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
            $table->foreignId('poa_activity_id')->nullable();
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
