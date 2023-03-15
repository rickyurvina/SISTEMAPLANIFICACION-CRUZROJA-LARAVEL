<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsMenWomenToMeasureAdvances extends Migration
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
            $table->double('men')->nullable();
            $table->double('women')->nullable();
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
            $table->dropColumn('men');
            $table->dropColumn('women');
        });
    }
}
