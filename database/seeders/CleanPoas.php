<?php

namespace Database\Seeders;

use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;
use App\Models\Projects\Activities\Task;
use Illuminate\Database\Seeder;

class CleanPoas extends Seeder
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
            \DB::beginTransaction();
            \DB::table('poa_indicator_configs')->delete();
            \DB::table('poa_activities')->delete();
            \DB::table('poa_programs')->delete();
            \DB::table('poa_indicator_goal_change_requests')->delete();
            \DB::table('poa_poas')->delete();
            \DB::table('poa_reschedulings')->delete();

            \DB::table('poa_matrix_report_agreement_commitment')->delete();
            \DB::table('matrix_beneficiary_matrix_report')->delete();
            \DB::table('poa_activity_piat_report')->delete();
            \DB::table('poa_activity_piat_plan')->delete();
            \DB::table('poa_activity_piat_requirements')->delete();
            \DB::table('poa_activity_piat')->delete();

            $measureAdvances = MeasureAdvances::where('measurable_type', PoaActivity::class)->get();
            $measureAdvances->each->forceDelete();

            \DB::commit();

        }catch (\Exception $exception){
            \DB::rollBack();

            throw new \Exception($exception->getMessage());
        }
    }
}
