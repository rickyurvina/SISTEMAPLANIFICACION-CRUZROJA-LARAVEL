<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStateToPrjTaskActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prj_task_activities', function (Blueprint $table) {
            //
            $table->string('state')->nullable()->default(\App\Models\Projects\Activities\ActivityTask::STATE_OPEN);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prj_task_activities', function (Blueprint $table) {
            //
            $table->dropColumn('state');
        });
    }
}
