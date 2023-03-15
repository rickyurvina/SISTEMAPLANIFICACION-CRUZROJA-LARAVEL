<?php

namespace Database\Seeders;

use App\Abstracts\Model;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Permissions extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $rows = [
            'super-admin' => [],
            'admin' => [
                'home-panel' => 'r',
                'auth-roles' => 'c,r,u,d',
                'auth-users' => 'c,r,u,d',
                'admin-companies' => 'c,r,u,d',
                'admin-address' => 'c,r,u,d',
                'admin-contact' => 'c,r,u,d',
                'admin-social-networks' => 'c,r,u,d',
                'admin-departments' => 'c,r,u,d',
                'module-risk' => 'r',
                'module' => 'r',
                'module-poa' => 'r',
                'module-strategy' => 'r',
                'module-project' => 'r',
                'module-budget' => 'r',
                'module-audit' => 'r',
                'module-indicator' => 'r',
                'module-project-line-actions' => 'c,r,u,d',
                'super-admin-project' => 'p',
//                'new-project' => 'p',
//                'view-project' => 'p',
//                'sheet-manage-project' => 'p',
//                'sheet-view-project' => 'p',
//                'logic-frame-manage-project' => 'p',
//                'logic-frame-view-project' => 'p',
//                'stakeholders-manage-project' => 'p',
//                'stakeholders-view-project' => 'p',
//                'risks-manage-project' => 'p',
//                'risks-view-project' => 'p',
//                'document-manage-project' => 'p',
//                'document-view-project' => 'p',
//                'budget-manage-project' => 'p',
//                'budget-view-project' => 'p',
//                'team-manage-project' => 'p',
//                'team-view-project' => 'p',
//                'gantt-manage-project' => 'p',
//                'gantt-view-project' => 'p',
//                'activities-manage-project' => 'p',
//                'activities-view-project' => 'p',
//                'acquisitions-manage-project' => 'p',
//                'acquisitions-view-project' => 'p',
//                'communication-manage-project' => 'p',
//                'communication-view-project' => 'p',
//                'files-manage-project' => 'p',
//                'files-view-project' => 'p',
//                'events-view-project' => 'p',
//                'reports-view-project' => 'p',
//                'lessons-view-project' => 'p',
//                'lessons-manage-project' => 'p',
//                'validations-view-project' => 'p',
//                'validations-manage-project' => 'p',
//                'rescheduling-view-project' => 'p',
//                'rescheduling-manage-project' => 'p',
//                'evaluations-view-project' => 'p',
//                'evaluations-manage-project' => 'p',
                'crud-strategy' => 's',
                'read-strategy' => 's',
                'plan-crud-strategy' => 's',
                'template-crud-strategy' => 's',
                'crud-project' => 'p',
                'read-project' => 'p',
                'crud-budget' => 'b',
                'read-budget' => 'b',
                'crud-poa' => 'o',
                'read-poa' => 'o',
                'crud-admin' => 'a',
                'read-admin' => 'a',
                'approve-poas' => 'o',
                'review-poas' => 'o',
                'change-status' => 'p',
                'view-indexCard' => 'p',
                'manage-indexCard' => 'p',
                'view-logicFrame' => 'p',
                'manage-logicFrame' => 'p',
                'view-stakeholders' => 'p',
                'manage-stakeholders' => 'p',
                'view-risks' => 'p',
                'manage-risks' => 'p',
                'view-formulatedDocument' => 'p',
                'manage-formulatedDocument' => 'p',
                'view-referentialBudget' => 'p',
                'manage-referentialBudget' => 'p',
                'view-governance' => 'p',
                'manage-governance' => 'p',
                'view-timetable' => 'p',
                'manage-timetable' => 'p',
                'view-calendar' => 'p',
                'manage-calendar' => 'p',
                'view-activities' => 'p',
                'manage-activities' => 'p',
                'view-acquisitions' => 'p',
                'manage-acquisitions' => 'p',
                'view-communication' => 'p',
                'manage-communication' => 'p',
                'view-files' => 'p',
                'manage-files' => 'p',
                'view-learnedLessons' => 'p',
                'manage-learnedLessons' => 'p',
                'view-events' => 'p',
                'view-reports' => 'p',
                'view-validations' => 'p',
                'manage-validations' => 'p',
                'view-reschedulings' => 'p',
                'manage-reschedulings' => 'p',
                'view-evaluations' => 'p',
                'manage-evaluations' => 'p',
                'view-administrativeTasks' => 'p',
                'manage-administrativeTasks' => 'p',
                'view-summary' => 'p',
                'approve-rescheduling' => 'p',
                'approve-piat-matrix'=>'o',
                'approve-piat-report'=>'o',
            ]
        ];
        $this->attachPermissionsByRoleNames($rows);
    }

    public function getActionsMap()
    {
        return [
            // 'c' => 'create',
            // 'r' => 'read',
            // 'u' => 'update',
            // 'd' => 'delete',
            'p' => 'project',
            's' => 'strategy',
            'b' => 'budget',
            'o' => 'poa',
            'a' => 'admin',
            'r'=>'process',
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
