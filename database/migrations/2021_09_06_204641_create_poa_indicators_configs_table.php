<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaIndicatorsConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poa_indicator_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('poa_id');
            $table->integer('indicator_id');
            $table->integer('program_id')->nullable();
            $table->boolean('selected');
            $table->text('reason')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('poa_id')->references('id')->on('poa_poas');
            $table->foreign('program_id')->references('id')->on('poa_programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poa_indicator_configs');
    }
}
