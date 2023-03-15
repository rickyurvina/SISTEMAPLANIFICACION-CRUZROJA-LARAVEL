<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsStatusApprovedByToBdgTransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bdg_transaction_details', function (Blueprint $table) {
            $table->bigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->string('status')->nullable()->default(\App\States\TransactionDetails\Draft::label());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bdg_transaction_details', function (Blueprint $table) {
            //
        });
    }
}
