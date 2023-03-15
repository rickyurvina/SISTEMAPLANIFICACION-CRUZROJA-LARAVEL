<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyLengthColumnsIndicatorsResultsObjectives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prj_tasks', function (Blueprint $table) {
            $table->string('text', 500)->change();
        });
        Schema::table('prj_project_objectives', function (Blueprint $table) {
            $table->string('name', 500)->change();
            $table->string('description', 2000)->change();
        });
        Schema::table('indicators', function (Blueprint $table) {
            $table->string('name', 500)->change();
            $table->string('results', 500)->change();
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
    }
}
