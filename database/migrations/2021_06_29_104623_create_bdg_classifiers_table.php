<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdgClassifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdg_classifiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->unsigned();
            $table->foreign('parent_id')->references('id')->on('bdg_classifiers');
            $table->string('code');
            $table->string('full_code')->nullable();
            $table->string('title');
            $table->string('description');
            $table->integer('level');
            $table->integer('enable')->default(1);
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
        Schema::dropIfExists('bdg_classifiers');
    }
}
