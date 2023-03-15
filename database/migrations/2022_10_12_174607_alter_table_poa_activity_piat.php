<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePoaActivityPiat extends Migration
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
            $table->dropColumn('id_poa_activities');
            $table->string('piatable_type')->nullable();
            $table->unsignedBigInteger('piatable_id')->nullable();
            $table->index(['piatable_type', 'piatable_id']);
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
        Schema::table('poa_activity_piat', function (Blueprint $table) {
            $table->unsignedSmallInteger('id_poa_activities');
            $table->dropColumn('piatable_type');
            $table->dropColumn('piatable_id');
        });
    }
}
