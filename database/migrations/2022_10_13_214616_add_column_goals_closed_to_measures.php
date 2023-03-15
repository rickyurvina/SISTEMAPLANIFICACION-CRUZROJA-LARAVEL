<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGoalsClosedToMeasures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('msr_measures', function (Blueprint $table) {
            //
            $table->boolean('goals_closed')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('msr_measures', function (Blueprint $table) {
            //
            $table->dropColumn('goals_closed');

        });
    }
}
