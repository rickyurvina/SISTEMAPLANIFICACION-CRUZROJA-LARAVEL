<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoumnsToNonConformities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processes_non_conformities', function (Blueprint $table) {
            //
            $table->string('state')->default(\App\Models\Process\NonConformities::TYPE_OPEN);
            $table->text('criteria')->nullable();
            $table->date('verification_close_date')->nullable();
            $table->date('verification_effectiveness_date')->nullable();
            $table->bigInteger('raised_by')->nullable();
            $table->bigInteger('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processes_non_conformities', function (Blueprint $table) {
            //
            $table->dropColumn('state');
            $table->dropColumn('criteria');
            $table->dropColumn('verification_close_date');
            $table->dropColumn('verification_effectiveness_date');
            $table->dropColumn('raised_by');
            $table->dropColumn('user_id');
        });
    }
}
