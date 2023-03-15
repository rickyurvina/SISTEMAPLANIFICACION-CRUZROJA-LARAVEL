<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdgAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdg_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('type');
            $table->string('code', 100);
            $table->text('name');
            $table->text('description')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('company_id');
            $table->nullableMorphs('accountable');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('bdg_accounts');
            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bdg_accounts');
    }
}
