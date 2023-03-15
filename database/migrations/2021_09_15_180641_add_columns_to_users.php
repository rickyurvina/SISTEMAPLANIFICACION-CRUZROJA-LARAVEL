<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('employer_cost', 10, 2)->nullable();
            $table->json('competencies')->nullable();
            $table->json('working_skills')->nullable();
            $table->text('work_experience')->nullable();
            $table->string('contract_type', 255)->nullable();
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->string('surname', 255)->nullable();
            $table->string('personal_phone', 255)->nullable();
            $table->date('date_birth')->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('job_title', 255)->nullable();
            $table->string('business_phone', 255)->nullable();
            $table->text('photo')->nullable();
            $table->text('personal_notes')->nullable();
            $table->integer('company_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
