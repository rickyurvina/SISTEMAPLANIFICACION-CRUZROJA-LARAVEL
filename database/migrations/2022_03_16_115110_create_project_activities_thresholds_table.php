<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectActivitiesThresholdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prj_thresholds', function (Blueprint $table) {
            $table->id();
            $table->integer('progress_physic')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('thresholdable_id')->nullable();
            $table->string('thresholdable_type')->nullable();
            $table->index(['thresholdable_id', 'thresholdable_type']);
            $table->json('properties');
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
        Schema::dropIfExists('prj_thresholds');
    }
}
