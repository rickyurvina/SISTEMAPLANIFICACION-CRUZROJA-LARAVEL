<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPoaActivity extends Migration
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
            $table->foreignId('measure_id');
            $table->dropColumn('indicator_id');
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
            $table->dropColumn('measure_id');
            $table->foreignId('indicator_id');
        });
    }
}
