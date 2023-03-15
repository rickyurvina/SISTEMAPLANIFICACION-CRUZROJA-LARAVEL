<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msr_period_children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->references('id')->on('msr_periods');
            $table->foreignId('period_id')->references('id')->on('msr_periods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msr_period_children');
    }
}
