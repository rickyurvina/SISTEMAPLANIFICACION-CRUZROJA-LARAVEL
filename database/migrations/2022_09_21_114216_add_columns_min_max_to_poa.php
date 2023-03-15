<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsMinMaxToPoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poa_poas', function (Blueprint $table) {
            $table->integer('min')->default(49)->nullable();
            $table->integer('max')->default(80)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poa', function (Blueprint $table) {
            //
            $table->dropColumn('min');
            $table->dropColumn('max');
        });
    }
}
