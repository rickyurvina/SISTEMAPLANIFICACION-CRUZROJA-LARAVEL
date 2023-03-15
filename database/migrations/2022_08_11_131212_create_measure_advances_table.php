<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasureAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msr_measure_advances', function (Blueprint $table) {
            $table->id();
            $table->double('goal')->nullable();
            $table->double('actual')->nullable();
            $table->string('aggregation_type', 50);
            $table->foreignId('period_id')->references('id')->on('msr_periods');
            $table->morphs('measurable');
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
        Schema::dropIfExists('msr_measure_advances');
    }
}
