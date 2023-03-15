<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsPiatPlanRequirment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poa_activity_piat_plan', function (Blueprint $table) {
            $table->dropColumn('responsable');
        });
        Schema::table('poa_activity_piat_requirements', function (Blueprint $table) {
            $table->dropColumn('responsable');
        });
        Schema::table('poa_activity_piat_plan', function (Blueprint $table) {
            $table->bigInteger('responsable')->nullable();
        });
        Schema::table('poa_activity_piat_requirements', function (Blueprint $table) {
            $table->bigInteger('responsable')->nullable();
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
    }
}
