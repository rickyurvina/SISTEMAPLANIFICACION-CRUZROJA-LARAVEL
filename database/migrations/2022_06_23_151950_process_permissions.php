<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProcessPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::table('permissions')
//            ->insert([
//                array (
//                    'id' => 130,
//                    'name' => 'process-view-process',
//                    'display_name' => 'Process View Process',
//                    'guard_name' => 'web',
//                    'created_at' => '2022-06-22 11:56:25',
//                    'updated_at' => '2022-06-22 11:56:25',
//                ),
//                129 =>
//                    array (
//                        'id' => 131,
//                        'name' => 'process-manage-process',
//                        'display_name' => 'Process Manage Process',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:25',
//                        'updated_at' => '2022-06-22 11:56:25',
//                    ),
//                130 =>
//                    array (
//                        'id' => 132,
//                        'name' => 'process-view-process-information',
//                        'display_name' => 'Process View Process Information',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                131 =>
//                    array (
//                        'id' => 133,
//                        'name' => 'process-manage-risks-process',
//                        'display_name' => 'Process Manage Risks Process',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                132 =>
//                    array (
//                        'id' => 134,
//                        'name' => 'process-view-risks-process',
//                        'display_name' => 'Process View Risks Process',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                133 =>
//                    array (
//                        'id' => 135,
//                        'name' => 'process-manage-activities-process',
//                        'display_name' => 'Process Manage Activities Process',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                134 =>
//                    array (
//                        'id' => 136,
//                        'name' => 'process-view-activities-process',
//                        'display_name' => 'Process View Activities Process',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                135 =>
//                    array (
//                        'id' => 137,
//                        'name' => 'process-manage-changes',
//                        'display_name' => 'Process Manage Changes',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                136 =>
//                    array (
//                        'id' => 138,
//                        'name' => 'process-view-changes',
//                        'display_name' => 'Process View Changes',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                137 =>
//                    array (
//                        'id' => 139,
//                        'name' => 'process-manage-indicators',
//                        'display_name' => 'Process Manage Indicators',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                138 =>
//                    array (
//                        'id' => 140,
//                        'name' => 'process-view-indicators',
//                        'display_name' => 'Process View Indicators',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                139 =>
//                    array (
//                        'id' => 141,
//                        'name' => 'process-view-conformities',
//                        'display_name' => 'Process View Conformities',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                140 =>
//                    array (
//                        'id' => 142,
//                        'name' => 'process-manage-conformities',
//                        'display_name' => 'Process Manage Conformities',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                141 =>
//                    array (
//                        'id' => 143,
//                        'name' => 'process-view-files-process',
//                        'display_name' => 'Process View Files Process',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                142 =>
//                    array (
//                        'id' => 144,
//                        'name' => 'process-manage-files-process',
//                        'display_name' => 'Process Manage Files Process',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 11:56:26',
//                        'updated_at' => '2022-06-22 11:56:26',
//                    ),
//                143 =>
//                    array (
//                        'id' => 145,
//                        'name' => 'process-close-conformities',
//                        'display_name' => 'Process Close Conformities',
//                        'guard_name' => 'web',
//                        'created_at' => '2022-06-22 12:37:43',
//                        'updated_at' => '2022-06-22 12:37:43',
//                    ),
//            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
