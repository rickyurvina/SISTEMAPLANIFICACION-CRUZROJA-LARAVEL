<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsScoreToPlansAndPlanDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            //
            $table->double('score')->nullable();
            $table->string('color')->default('gray')->nullable();
        });

        Schema::table('plan_details', function (Blueprint $table) {
            //
            $table->double('score')->nullable();
            $table->string('color')->default('gray')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            //
            $table->dropColumn('score');
            $table->dropColumn('color');
        });

        Schema::table('plan_details', function (Blueprint $table) {
            //
            $table->dropColumn('score');
            $table->dropColumn('color');
        });
    }
}
