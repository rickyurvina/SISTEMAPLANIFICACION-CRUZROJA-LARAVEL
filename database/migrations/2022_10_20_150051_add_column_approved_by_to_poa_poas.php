<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnApprovedByToPoaPoas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poa_poas', function (Blueprint $table) {
            //
            $table->foreignId('approved_by')->nullable()->references('id')->on('users');
            $table->date('approved_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poa_poas', function (Blueprint $table) {
            //
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
        });
    }
}
