<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaPiatRequestSivolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poa_piat_request_sivols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poa_activity_piat_id')->nullable();;
            $table->text('description')->nullable();
            $table->string('status')->default(\App\Models\Poa\Piat\PoaActivityPiatRescheduling::STATUS_OPENED);
            $table->integer('number_request');
            $table->integer('number_activated')->nullable();
            $table->text('response')->nullable();;
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
        Schema::dropIfExists('poa_piat_request_sivols');
    }
}
