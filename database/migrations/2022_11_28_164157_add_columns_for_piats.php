<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsForPiats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('poa_activity_piat', function (Blueprint $table) {
            $table->date('end_date')->nullable();
        });
        Schema::table('poa_activity_piat_plan', function (Blueprint $table) {
            $table->date('end_date')->nullable();
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
            $table->dropColumn('end_date');
        });

        Schema::table('poa_activity_piat_plan', function (Blueprint $table) {
            $table->dropColumn('end_date');
        });
    }
}
