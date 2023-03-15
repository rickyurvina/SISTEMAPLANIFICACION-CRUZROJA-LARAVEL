<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonConformitiesActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes_non_conformities_actions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->foreignId('processes_non_conformities_id');
            $table->string('status');
            $table->foreignId('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('implantation_date');
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
        Schema::dropIfExists('process_non_conformities_actions');
    }
}
