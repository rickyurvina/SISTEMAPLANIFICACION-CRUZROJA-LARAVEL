<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnGoalsToPoaActivityPiat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poa_activity_piat', function (Blueprint $table) {
            //
            $table->text('goals')->change()->nullable();

        });
        Schema::table('poa_activity_piat_report', function (Blueprint $table) {
            //
            $table->text('positive_evaluation')->change()->nullable();
            $table->text('evaluation_for_improvement')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poa_activity_piat', function (Blueprint $table) {
            //
        });
    }
}
