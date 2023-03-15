<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProcesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processes', function (Blueprint $table) {
            //
            $table->text('attributions')->nullable();
            $table->integer('cycle_time')->nullable();
            $table->integer('people_number')->nullable();
            $table->string('client_type')->nullable();
            $table->text('services')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processes', function (Blueprint $table) {
            //
            $table->dropColumn('attributions');
            $table->dropColumn('cycle_time');
            $table->dropColumn('people_number');
            $table->dropColumn('client_type');
            $table->dropColumn('services');
        });
    }
}
