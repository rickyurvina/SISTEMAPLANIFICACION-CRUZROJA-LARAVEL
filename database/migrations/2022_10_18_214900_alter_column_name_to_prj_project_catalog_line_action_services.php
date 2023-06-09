<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnNameToPrjProjectCatalogLineActionServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prj_project_catalog_line_action_services', function (Blueprint $table) {
            //
            $table->text('name')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prj_project_catalog_line_action_services', function (Blueprint $table) {
            //
            $table->string('name')->change();
        });
    }
}
