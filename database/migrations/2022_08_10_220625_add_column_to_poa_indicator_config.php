<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPoaIndicatorConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poa_indicator_configs', function (Blueprint $table) {
            //
            $table->dropColumn('indicator_id');
            $table->foreignId('measure_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poa_indicator_configs', function (Blueprint $table) {
            //
            $table->foreignId('indicator_id');
            $table->dropColumn('measure_id');
        });
    }
}
