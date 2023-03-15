<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msr_measures', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10);
            $table->string('name', 500);
            $table->text('description')->nullable();
            $table->string('type', 50);
            $table->string('data_type', 50);
            $table->string('aggregation_type', 50);
            $table->boolean('yes_good')->nullable();
            $table->boolean('higher_better')->nullable();
            $table->string('base_line', 50)->nullable();
            $table->integer('baseline_year')->nullable();
            $table->json('series');
            $table->double('weight')->default(1);
            $table->string('category')->nullable();
            $table->boolean('is_mandatory')->nullable();

            $table->foreignId('calendar_id')->references('id')->on('msr_calendars');
            $table->foreignId('scoring_type_id')->references('id')->on('msr_scoring_types');
            $table->foreignId('unit_id')->nullable()->references('id')->on('indicator_units');
            $table->foreignId('source_id')->nullable()->references('id')->on('indicator_sources');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->nullableMorphs('indicatorable');
            $table->integer('company_id')->unsigned();
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
        Schema::dropIfExists('msr_measures');
    }
}
