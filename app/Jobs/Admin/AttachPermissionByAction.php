<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttachPermissionByAction extends Job
{

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
        $this->request = $this->getRequestInstance($request);

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        //
        try {
            $roles = $this->request->all();
            DB::beginTransaction();
            foreach ($roles as $role_name => $permissions) {
                $role = $this->createRole($role_name);

                foreach ($permissions as $id => $permission) {
                    $this->attachPermissionsByAction($role, $id, $permission);
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw  new \Exception($exception->getMessage());
        }
    }

    /**
     * @param $name
     * @return Role|\Spatie\Permission\Models\Role
     */
    public function createRole($name)
    {
        return Role::firstOrCreate([
            'name' => $name,
        ]);
    }

    public function attachPermissionsByAction($role, $page, $action_list)
    {
        $actions_map = collect($this->getActionsMap());

        if (is_array($action_list)) {
            $actions = explode(',', $action_list['action']);
        } else {
            $actions = explode(',', $action_list);
        }

        foreach ($actions as $short_action) {
            $action = $actions_map->get($short_action);
            if ($action) {
                $name = $action . '-' . $page;
            } else {
                $name = $page;
            }
            $this->attachPermission($role, $name, $action_list);
        }
    }

    /**
     * @return string[]
     */
    public function getActionsMap()
    {
        return [
            'p' => 'project',
            's' => 'strategy',
            'b' => 'budget',
            'o' => 'poa',
            'a' => 'admin',
            'r' => 'process',
        ];
    }

    public function attachPermission($role, $permission, $action_list = [])
    {
        if (is_string($permission)) {
            $permission = $this->createPermission($permission,'', $action_list);
        }

        if ($role->hasPermissionTo($permission->name)) {
            return;
        }

        $role->givePermissionTo($permission);
    }

    /**
     * @param $name
     * @param $display_name
     * @return Permission|\Spatie\Permission\Models\Permission
     */
    public function createPermission($name, $display_name = null, $action_list = []): \Spatie\Permission\Models\Permission|Permission
    {
        $display_name = $display_name ? trans('auth.permission' . $name) == 'auth.permission' . $name ? $this->getPermissionDisplayName($name) : trans($name) : $this->getPermissionDisplayName($name);

        return Permission::firstOrCreate([
            'name' => $name,
        ], [
            'display_name' => $display_name,
            'spanish_label' => $action_list['spanish_label']
        ]);
    }

    /**
     * @param $name
     * @return string
     */
    public function getPermissionDisplayName($name): string
    {
        return Str::title(str_replace('-', ' ', $name));
    }
}
