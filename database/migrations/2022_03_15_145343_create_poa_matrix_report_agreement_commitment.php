<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaMatrixReportAgreementCommitment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('poa_matrix_report_agreement_commitment')) {
            Schema::create('poa_matrix_report_agreement_commitment', function (Blueprint $table) {
                $table->increments('id');
                $table->foreignId('id_poa_activity_piat_report')->references('id')->on('poa_activity_piat_report');
                $table->string('description', 255)->nullable(true);
                $table->integer('responsable');
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
        Schema::dropIfExists('poa_matrix_report_agreement_commitment');
    }
}
