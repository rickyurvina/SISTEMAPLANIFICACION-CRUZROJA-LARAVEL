<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaMatrixReportBeneficiaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('poa_matrix_report_beneficiaries')) {
            Schema::create('poa_matrix_report_beneficiaries', function (Blueprint $table) {
                $table->increments('id');
                $table->string('names')->nullable(true);
                $table->string('surnames')->nullable(true);
                $table->string('gender');
                $table->string('identification', 11)->nullable(true);
                $table->string('disability', 2);
                $table->integer('age')->nullable(true);
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
        Schema::dropIfExists('poa_matrix_report_beneficiaries');
    }
}
