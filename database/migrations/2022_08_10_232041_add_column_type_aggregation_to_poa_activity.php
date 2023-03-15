<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeAggregationToPoaActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poa_activities', function (Blueprint $table) {
            //
            $table->string('aggregation_type', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poa_activities', function (Blueprint $table) {
            //
            $table->dropColumn('aggregation_type');
        });
    }
}
