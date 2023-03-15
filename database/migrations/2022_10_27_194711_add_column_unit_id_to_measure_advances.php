<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUnitIdToMeasureAdvances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('msr_measure_advances', function (Blueprint $table) {
            //
            $table->integer('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('indicator_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('msr_measure_advances', function (Blueprint $table) {
            //
            $table->dropColumn('unit_id');
        });
    }
}
