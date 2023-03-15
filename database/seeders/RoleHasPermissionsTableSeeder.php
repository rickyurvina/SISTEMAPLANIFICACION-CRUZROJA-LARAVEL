<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('role_has_permissions')->delete();
        $permissions = Permission::get()->pluck('id');
        foreach ($permissions as $permission) {
            \DB::table('role_has_permissions')->insert(array(
                1 =>
                    array(
                        'permission_id' => $permission,
                        'role_id' => 1,
                    ),
                2 =>
                    array(
                        'permission_id' => $permission,
                        'role_id' => 2,
                    ),
            ));
        }
    }
}