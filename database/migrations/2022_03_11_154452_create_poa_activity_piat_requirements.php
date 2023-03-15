<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaActivityPiatRequirements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('poa_activity_piat_requirements')) {
            Schema::create('poa_activity_piat_requirements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_poa_activity_piat')->references('id')->on('poa_activity_piat');
                $table->string('description', 255);
                $table->integer('quantity')->nullable(true);
                $table->double('approximate_cost')->nullable(true);
                $table->foreignId('responsable');
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
        Schema::dropIfExists('poa_activity_piat_requirements');
    }
}
