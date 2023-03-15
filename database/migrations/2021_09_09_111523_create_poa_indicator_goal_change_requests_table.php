<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaIndicatorGoalChangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poa_indicator_goal_change_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poa_activity_indicator_id');
            $table->unsignedBigInteger('indicator_id');
            $table->double('period');
            $table->double('old_value');
            $table->double('new_value');
            $table->text('request_justification');
            $table->text('answer_justification')->nullable();
            $table->integer('request_user');
            $table->integer('answer_user')->nullable();
            $table->string('status', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poa_indicator_goal_change_requests');
    }
}
