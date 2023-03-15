<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonConformitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('processes_non_conformities');
        Schema::create('processes_non_conformities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_id');
            $table->string('code', 5);
            $table->string('number');
            $table->string('type');
            $table->string('description', 500);
            $table->string('evidence', 500);
            $table->date('date');
            $table->json('causes')->nullable();
            $table->boolean('closing_verification')->default(false);
            $table->boolean('efficiency_verification')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('processes_non_conformities');
    }
}
