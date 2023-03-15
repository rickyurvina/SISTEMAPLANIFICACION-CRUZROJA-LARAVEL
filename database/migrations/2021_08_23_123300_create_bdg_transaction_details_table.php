<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdgTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdg_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->bigInteger('debit')->nullable();
            $table->bigInteger('credit')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('account_id');
            $table->bigInteger('company_id');
            $table->index('company_id');
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
        Schema::dropIfExists('bdg_transaction_details');
    }
}
