<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdgTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdg_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('type', 2);
            $table->integer('number');
            $table->text('description');
            $table->string('status', 50);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->bigInteger('company_id');
            $table->index('company_id');
            $table->unique(['year', 'type', 'number', 'company_id']);
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
        Schema::dropIfExists('bdg_transactions');
    }
}
