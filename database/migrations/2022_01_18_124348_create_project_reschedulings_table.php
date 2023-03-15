<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectReschedulingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prj_project_reschedulings', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('status')->nullable();
            $table->string('state')->nullable();
            $table->string('phase')->nullable();
            $table->foreignId('prj_project_id');
            $table->foreignId('user_id');
            $table->integer('approved_id')->nullable();
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
        Schema::dropIfExists('project_reschedulings');
    }
}
