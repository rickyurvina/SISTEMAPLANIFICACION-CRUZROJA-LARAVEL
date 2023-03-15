<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableBdgCertificationCommitments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('bdg_certifications_commitments');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::create('bdg_certifications_commitments', function (Blueprint $table) {
            $table->id();
            $table->integer('certification_id');
            $table->integer('commitment_id');
            $table->integer('year');
            $table->foreignId('bdg_account_id');
            $table->bigInteger('amount');
            $table->timestamps();
        });
    }
}
