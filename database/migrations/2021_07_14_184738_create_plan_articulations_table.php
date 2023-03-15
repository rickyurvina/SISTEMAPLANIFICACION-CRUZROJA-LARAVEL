<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanArticulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_articulations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_source_id')->nullable()->unsigned();
            $table->foreign('plan_source_id')->references('id')->on('plans');

            $table->unsignedBigInteger('plan_source_registered_template_id')->nullable()->unsigned();
            $table->foreign('plan_source_registered_template_id')->references('id')->on('plan_registered_template_details');

            $table->unsignedBigInteger('plan_source_detail_id')->nullable()->unsigned();
            $table->foreign('plan_source_detail_id')->references('id')->on('plan_details');

            $table->unsignedBigInteger('plan_target_detail_id')->nullable()->unsigned();
            $table->foreign('plan_target_detail_id')->references('id')->on('plan_details');


            $table->unsignedBigInteger('plan_target_registered_template_id')->nullable()->unsigned();
            $table->foreign('plan_target_registered_template_id')->references('id')->on('plan_registered_template_details');

            $table->unsignedBigInteger('plan_target_id')->nullable()->unsigned();
            $table->foreign('plan_target_id')->references('id')->on('plans');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_articulations');
    }
}
