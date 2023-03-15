<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsProcessActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('activities');
        Schema::create('process_activities', function (Blueprint $table) {
        });
        Schema::table('process_activities', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('code',5);
            $table->string('name',200);
            $table->string('expected_result',500);
            $table->integer('user_id');
            $table->string('specifications',500);
            $table->string('cares',500);
            $table->string('procedures',500);
            $table->string('equipment',500);
            $table->string('supplies',500);
            $table->foreignId('process_id');
            $table->integer('company_id');
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
        //
    }
}
