<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStateValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prj_state_validations', function (Blueprint $table) {
            $table->id();
            $table->string('state')->nullable();
            $table->json('validations')->nullable();
            $table->string('status')->default(\App\Models\Projects\ProjectStateValidations::STATUS_NO_VALIDATED)->nullable();
            $table->foreignId('prj_project_id')->nullable();
            $table->foreignId('user_id')->nullable();
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
        Schema::dropIfExists('project_state_validations');
    }
}
