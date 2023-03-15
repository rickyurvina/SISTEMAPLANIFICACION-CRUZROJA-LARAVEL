<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProgramToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_registered_template_details', function (Blueprint $table) {
            $table->boolean('program')->default(0);

        });
        Schema::table('plan_template_details', function (Blueprint $table) {
            $table->boolean('program')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_registered_template_details', function (Blueprint $table) {

        });
        Schema::table('plan_template_details', function (Blueprint $table) {

        });
    }
}
