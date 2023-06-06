<?php

namespace Database\Seeders;

use App\Models\Measure\Measure;
use App\Models\Measure\MeasureAdvances;
use App\Models\Projects\Activities\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanProjects extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        try {
            DB::beginTransaction();
            \DB::table('prj_links')->delete();
            \DB::table('prj_project_acquisitions')->delete();
            \DB::table('prj_project_articulations')->delete();
            \DB::table('prj_project_beneficiaries')->delete();
            \DB::table('prj_project_catalog_line_action_service_activities')->delete();
            \DB::table('prj_project_communication_matrix')->delete();
            \DB::table('prj_project_cooperators')->delete();
            \DB::table('prj_project_evaluations')->delete();
            \DB::table('prj_project_financiers')->delete();
            \DB::table('prj_project_learned_lessons')->delete();
            \DB::table('prj_project_locations')->delete();
            \DB::table('prj_project_members')->delete();
            \DB::table('prj_project_members_areas')->delete();
            \DB::table('prj_project_members_subsidiaries')->delete();

            \DB::table('risk_actions')->delete();
            \DB::table('prj_tasks_services')->delete();
            \DB::table('prj_project_stakeholder_actions')->delete();
            \DB::table('prj_project_referential_budget')->delete();
            \DB::table('prj_tasks')->delete();
            \DB::table('prj_project_objectives')->delete();

            \DB::table('prj_project_priority_zones')->delete();
            \DB::table('prj_project_reschedulings')->delete();
            \DB::table('prj_project_stakeholders')->delete();
            \DB::table('prj_state_validations')->delete();
            \DB::table('prj_task_work_logs')->delete();
            \DB::table('prj_task_activities')->delete();
            \DB::table('prj_thresholds')->delete();
            \DB::table('prj_projects')->delete();

            //eliminar indicadores
            \DB::table('goal_indicators')->delete();
            \DB::table('indicator_parent_child')->delete();
            \DB::table('indicators')->delete();

            $measureAdvances = MeasureAdvances::where('measurable_type', Task::class)->get();
            $measureAdvances->each->forceDelete();

            \DB::table('bdg_accounts')->delete();
            \DB::table('bdg_transaction_details')->delete();
            \DB::table('bdg_transactions')->delete();

            \DB::table('processes_non_conformities_actions')->delete();
            \DB::table('processes_non_conformities')->delete();
            \DB::table('process_plan_changes_activities')->delete();
            \DB::table('process_plan_changes')->delete();
            \DB::table('process_activities')->delete();
            \DB::table('processes')->delete();

            \DB::table('risk_actions')->delete();
            \DB::table('risks')->delete();


            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw  new \Exception($exception->getMessage());
        }
    }
}
