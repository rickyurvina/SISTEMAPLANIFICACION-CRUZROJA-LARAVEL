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
        \DB::table('role_has_permissions')->delete();
        \DB::table('permissions')->delete();

        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $rows = [
            'super-admin' => [],
            'admin' => [
                'new' => 'p',
                'sheet-manage' => 'p',
                'sheet-view' => 'p',
                'logic-frame-manage' => 'p',
                'logic-frame-view' => 'p',
                'stakeholders-manage' => 'p',
                'stakeholders-view' => 'p',
                'risks-manage' => 'p',
                'risks-view' => 'p',
                'document-manage' => 'p',
                'document-view' => 'p',
                'budget-manage' => 'p',
                'budget-view' => 'p',
                'team-manage' => 'p',
                'team-view' => 'p',
                'gantt-manage' => 'p',
                'gantt-view' => 'p',
                'activities-manage' => 'p',
                'activities-view' => 'p',
                'acquisitions-manage' => 'p',
                'acquisitions-view' => 'p',
                'communication-manage' => 'p',
                'communication-view' => 'p',
                'files-manage' => 'p',
                'files-view' => 'p',
                'events-view' => 'p',
                'lessons-view' => 'p',
                'lessons-manage' => 'p',
                'validations-view' => 'p',
                'validations-manage' => 'p',
                'rescheduling-view' => 'p',
                'rescheduling-manage' => 'p',
                'evaluations-view' => 'p',
                'evaluations-manage' => 'p',
                'manage-logicFrame' => 'p',
                'manage-stakeholders' => 'p',
                'view-formulatedDocument' => 'p',
                'manage-governance' => 'p',
                'manage-timetable' => 'p',
                'view-calendar' => 'p',
                'view-acquisitions' => 'p',
                'manage-communication' => 'p',
                'view-learnedLessons' => 'p',
                'manage-learnedLessons' => 'p',
                'view-events' => 'p',
                'view-validations' => 'p',
                'manage-validations' => 'p',
                'view-reschedulings' => 'p',
                'manage-reschedulings' => 'p',
                'manage-evaluations' => 'p',
                'view-administrativeTasks' => 'p',
                'manage-administrativeTasks' => 'p',
                'view-summary' => 'p',
                'manage-acquisitions' => 'p',
                'view-communication' => 'p',
                'manage-calendar' => 'p',
                'view-stakeholders' => 'p',
                'view-referentialBudget' => 'p',
                'manage-team' => 'p',
                'view-team' => 'p',
                'read-team' => 'p',
                'super-admin' => 'p',
                'manage-referentialBudget' => 'p',
                'view-logicFrame' => 'p',
                'view-governance' => 'p',
                'view-timetable' => 'p',
                'manage-formulatedDocument' => 'p',
                'change-status' => 'p',
                'read' => 'p',
                'view-indexCard' => 'p',
                'manage-indexCard' => 'p',

                'approve-rescheduling' => 'p,o',
                'view-files' => 'p,r',
                'manage-files' => 'p,r',
                'view-evaluations' => 'p,r',
                'manage-activities' => 'p,r',
                'view-risks' => 'p,r',
                'view-activities' => 'p,r',
                'manage-risks' => 'r,p',

                'view' => 's,p,b,o,t,r,a,d',
                'manage' => 's,p,b,o,t,r,a,d',
                'view-reports' => 's,p,b,o,t,r,a,d',
                'approve' => 'o,b',
                'settings' => 's,p,b,o,t,r,a,d',

                'view-dashboard' => 's',
                'manage-plans' => 's',
                'view-plans' => 's',
                'update-indicators' => 's',
                'manage-templates' => 's',
                'view-templates' => 's',
                'manage-indicator-reports' => 's',
                'view-indicator-reports' => 's',
                'view-structure-poa' => 's',

                'manage-structure' => 'b',
                'view-structure' => 'b',
                'manage-classifier' => 'b',
                'view-classifier' => 'b',
                'manage-funding-source' => 'b',
                'view-funding-source' => 'b',
                'manage-geographic-source' => 'b',
                'view-geographic-classifier' => 'b',

                'view-changeControl' => 'o',
                'manage-changeGoal' => 'o',
                'view-changeGoal' => 'o',
                'view-requests' => 'o',
                'approve-requests' => 'o',
                'manage-activities-catalog' => 'o',
                'view-activities-catalog' => 'o',
                'manage-budget' => 'o',
                'view-budget' => 'o',

                'manage-changes' => 'r',
                'view-changes' => 'r',
                'view-indicators' => 'r',
                'manage-indicators' => 'r',
                'view-process-information' => 'r',
                'view-conformities' => 'r',
                'manage-conformities' => 'r',
                'close-conformities' => 'r',

                'manage-companies' => 'a',
                'view-companies' => 'a',
                'manage-users' => 'a',
                'view-users' => 'a',
                'manage-structure-organizational' => 'a',
                'view-structure-organizational' => 'a',
                'manage-catalogs'=>'a',
                'view-catalogs'=>'a'
            ]
        ];
        $this->attachPermissionsByRoleNames($rows);
    }

    public function getActionsMap()
    {
        return [
            's' => 'strategy',
            'p' => 'project',
            'b' => 'budget',
            'o' => 'poa',
            't' => 'administrative',
            'r' => 'process',
            'a' => 'admin',
            'd' => 'audit',
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
