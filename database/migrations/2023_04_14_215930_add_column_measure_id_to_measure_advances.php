<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMeasureIdToMeasureAdvances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('msr_measure_advances', function (Blueprint $table) {
            $table->bigInteger('measure_id')->nullable();
            $table->foreign('measure_id')->references('id')->on('msr_measures');
            $table->index('measure_id');
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
            $table->dropForeign('measure_id');
            $table->dropColumn('measure_id');
        });
    }
}
