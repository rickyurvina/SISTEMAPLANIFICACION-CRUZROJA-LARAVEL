<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsStrategy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //name on plan table
        Schema::table('plans', function (Blueprint $table) {
            $table->string('name',500)->change();
        });
        //name on plan_details
        Schema::table('plan_details', function (Blueprint $table) {
            $table->string('name',500)->change();
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
