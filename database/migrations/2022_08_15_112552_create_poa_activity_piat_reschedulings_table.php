<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaActivityPiatReschedulingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             Schema::create('poa_activity_piat_reschedulings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poa_activity_piat_id');
            $table->text('description');
            $table->string('status')->default(\App\Models\Poa\Piat\PoaActivityPiatRescheduling::STATUS_OPENED);
            $table->integer('user_id');
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
        Schema::dropIfExists('poa_activity_piat_reschedulings');
    }
}
