<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaActivityPiat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('poa_activity_piat')) {
            // Code to create table
            Schema::create('poa_activity_piat', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('place', 255);
                $table->date('date');
                $table->time('initial_time')->nullable(true);
                $table->time('end_time')->nullable(true);
                $table->integer('province');
                $table->integer('canton');
                $table->integer('parish');
                $table->foreignId('id_poa_activities')->references('id')->on('poa_activities');
                $table->integer('number_male_respo')->nullable(true);
                $table->integer('number_female_respo')->nullable(true);
                $table->integer('males_beneficiaries')->nullable(true);
                $table->integer('females_beneficiaries')->nullable(true);
                $table->integer('males_volunteers')->nullable(true);
                $table->integer('females_volunteers')->nullable(true);
                $table->string('goals', 255);
                $table->string('status', 10);
                $table->integer('created_by');
                $table->integer('approved_by');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poa_activity_piat');

    }
}
