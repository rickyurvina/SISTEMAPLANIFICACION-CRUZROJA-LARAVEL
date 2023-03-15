<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeToRiskActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_actions', function (Blueprint $table) {
            //
            $table->string('type')->nullable()->default(\App\Models\Risk\RiskAction::TYPE_AVOID);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_actions', function (Blueprint $table) {
            //
            $table->dropColumn('type');
        });
    }
}
