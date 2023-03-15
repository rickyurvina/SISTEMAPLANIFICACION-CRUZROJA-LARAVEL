<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectLessonLearnedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prj_project_learned_lessons', function (Blueprint $table) {
            $table->id();
            $table->text('background')->nullable();
            $table->text('causes')->nullable();
            $table->text('learned_lesson')->nullable();
            $table->text('corrective_lesson')->nullable();
            $table->text('evidences')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('phase')->nullable();
            $table->string('state')->nullable();
            $table->string('type')->nullable();
            $table->string('knowledge')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->index('company_id')->nullable();
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
        Schema::dropIfExists('project_lesson_learneds');
    }
}
