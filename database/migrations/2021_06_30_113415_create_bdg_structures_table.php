<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdgStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdg_structures', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->integer('type');
            $table->integer('level');
            $table->string('name');
            $table->integer('length')->nullable();
            $table->string('model_type')->nullable();
            $table->string('model_field')->nullable();
            $table->string('model_field_name')->nullable();
            $table->index(['model_type']);
            $table->unique(['year', 'type', 'level']);
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
        Schema::dropIfExists('bdg_structures');
    }
}
