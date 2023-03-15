<?php

namespace Database\Seeders;

use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Score;
use App\Models\Poa\Piat\PoaActivityPiat;
use App\Models\Poa\Piat\PoaActivityPiatPlan;
use App\Models\Poa\Piat\PoaActivityPiatReport;
use App\Models\Poa\Piat\PoaActivityPiatRequirements;
use App\Models\Poa\Piat\PoaActivityPiatRescheduling;
use App\Models\Poa\Piat\PoaMatrixReportAgreementCommitment;
use App\Models\Poa\Piat\PoaMatrixReportBeneficiaries;
use App\Models\Poa\Piat\PoaPiatActivityResponsibles;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaActivityBeneficiary;
use App\Models\Poa\PoaIndicatorConfig;
use App\Models\Poa\PoaIndicatorGoalChangeRequest;
use App\Models\Poa\PoaProgram;
use App\Models\Poa\PoaRescheduling;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeletePoasScores extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            PoaIndicatorGoalChangeRequest::get()->delete();
            PoaActivity::where('id','!=',null)->forceDelete();
            PoaActivityBeneficiary::where('id','!=',null)->forceDelete();
            DB::table('matrix_beneficiary_matrix_report')->delete();
            DB::table('poa_departments')->delete();
            PoaActivityPiatPlan::where('id','!=',null)->forceDelete();
            PoaMatrixReportBeneficiaries::where('id','!=',null)->forceDelete();
            PoaMatrixReportAgreementCommitment::where('id','!=',null)->forceDelete();
            PoaActivityPiatReport::where('id','!=',null)->forceDelete();
            PoaActivityPiatRequirements::where('id','!=',null)->forceDelete();
            PoaActivityPiatRescheduling::where('id','!=',null)->forceDelete();
            PoaMatrixReportBeneficiaries::where('id','!=',null)->forceDelete();
            PoaPiatActivityResponsibles::where('id','!=',null)->forceDelete();
            PoaActivityPiat::where('id','!=',null)->forceDelete();
            PoaIndicatorConfig::where('id','!=',null)->forceDelete();
            PoaProgram::where('id','!=',null)->forceDelete();
            PoaRescheduling::where('id','!=',null)->forceDelete();
            Poa::where('id','!=',null)->forceDelete();
            MeasureAdvances::where('measurable_type', PoaActivity::class)->forceDelete();
            Score::whereNotNull('id')->update(['actual' => null, 'score' => null, 'color' => 'gray']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw  new \Exception($exception->getMessage());
        }
    }
}
