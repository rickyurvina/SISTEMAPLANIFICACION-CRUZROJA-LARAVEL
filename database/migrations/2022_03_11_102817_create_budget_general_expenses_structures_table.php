<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetGeneralExpensesStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdg_general_expenses_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bdg_transaction_id');
            $table->integer('parent_id')->nullable();
            $table->string('code');
            $table->string('name');
            $table->integer('responsible_unit')->nullable();
            $table->integer('executing_unit')->nullable();
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
        Schema::dropIfExists('budget_general_expenses_structures');
    }
}
