<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaActivityPiatReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('poa_activity_piat_report')) {
            Schema::create('poa_activity_piat_report', function (Blueprint $table) {
                $table->increments('id');
                $table->foreignId('id_poa_activity_piat')->references('id')->on('poa_activity_piat');
                $table->boolean('accomplished');
                $table->string('description', 255)->nullable(true);
                $table->string('positive_evaluation', 255)->nullable(true);
                $table->string('evaluation_for_improvement', 255)->nullable(true);
                $table->date('date');
                $table->time('initial_time')->nullable(true);
                $table->time('end_time')->nullable(true);
                $table->integer('created_by');
                $table->integer('approved_by');
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
        Schema::dropIfExists('poa_activity_piat_report');
    }
}
