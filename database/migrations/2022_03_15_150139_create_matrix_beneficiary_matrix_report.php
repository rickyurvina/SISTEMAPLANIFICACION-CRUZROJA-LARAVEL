<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatrixBeneficiaryMatrixReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('matrix_beneficiary_matrix_report')) {
            Schema::create('matrix_beneficiary_matrix_report', function (Blueprint $table) {
                $table->increments('id');
                $table->foreignId('matrix_beneficiary_id')->references('id')->on('poa_matrix_report_beneficiaries');
                $table->foreignId('matrix_report_id')->references('id')->on('poa_activity_piat_report');
                $table->string('observations', 255)->nullable(true);
                $table->string('belong_to_board', 255)->nullable(true);
                $table->time('participation_initial_time')->nullable(true);
                $table->time('participation_end_time')->nullable(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matrix_beneficiary_matrix_report');
    }
}
