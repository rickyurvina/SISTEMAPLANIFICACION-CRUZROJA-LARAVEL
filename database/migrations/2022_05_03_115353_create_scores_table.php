<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msr_scores', function (Blueprint $table) {
            $table->id();
            $table->double('actual')->nullable();
            $table->double('score')->nullable();
            $table->string('color');
            $table->double('goal')->nullable();
            $table->double('variance')->nullable();
            $table->double('variance_percent')->nullable();
            $table->double('toward_goal_percent')->nullable();
            $table->string('data_type')->nullable();
            $table->json('thresholds');
            $table->foreignId('period_id')->references('id')->on('msr_periods');
            $table->morphs('scoreable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msr_scores');
    }
}
