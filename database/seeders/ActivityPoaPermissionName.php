<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivityPoaPermissionName extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->create();

    }

    private function create()
    {
        $rows = [
            'admin' => [
                'edit-activity-name' => 'o',
            ]
        ];
        $this->attachPermissionsByRoleNames($rows);
    }

    public function getActionsMap()
    {
        return [
            'o' => 'poa',
        ];
    }

    public function attachPermissionsByRoleNames($roles)
    {
        foreach ($roles as $role_name => $permissions) {
            $role = $this->createRole($role_name);

            foreach ($permissions as $id => $permission) {
                $this->attachPermissionsByAction($role, $id, $permission);
            }
        }
    }

    public function createRole($name)
    {
        return Role::firstOrCreate([
            'name' => $name,
        ]);
    }

    public function attachPermissionsByAction($role, $page, $action_list)
    {
        $actions_map = collect($this->getActionsMap());

        $actions = explode(',', $action_list);

        foreach ($actions as $short_action) {
            $action = $actions_map->get($short_action);

            $name = $action . '-' . $page;

            $this->attachPermission($role, $name);
        }
    }

    public function attachPermission($role, $permission)
    {
        if (is_string($permission)) {
            $permission = $this->createPermission($permission);
        }

        if ($role->hasPermissionTo($permission->name)) {
            return;
        }

        $role->givePermissionTo($permission);
    }

    public function createPermission($name, $display_name = null)
    {
        $display_name = $display_name ? trans('auth.permission' . $name) == 'auth.permission' . $name ? $this->getPermissionDisplayName($name) : trans($name) : $this->getPermissionDisplayName($name);

        return Permission::firstOrCreate([
            'name' => $name,
        ], [
            'display_name' => $display_name
        ]);
    }

    public function getPermissionDisplayName($name)
    {
        return Str::title(str_replace('-', ' ', $name));
    }
}
