<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prj_project_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('variables');
            $table->text('methodology');
            $table->string('phase');
            $table->string('state');
            $table->json('resources');
            $table->text('systematization');
            $table->foreignId('user_id')->nullable();
            $table->index('company_id');
            $table->foreignId('company_id')->nullable();
            $table->foreignId('prj_project_id')->nullable();
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
        Schema::dropIfExists('project_evaluations');
    }
}
