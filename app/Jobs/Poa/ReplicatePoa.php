<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Jobs\Measure\CreateMeasureAdvances;
use App\Models\Poa\Piat\PoaActivityPiat;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\States\Poa\InProgress;
use App\States\Poa\Planning;
use Illuminate\Support\Facades\DB;

class ReplicatePoa extends Job
{
    protected $poa;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $newProgramId = [];
            $poaId = $this->request;

            $modelPoa = Poa::find($poaId);
            $poaYear = $modelPoa->year + 1;
            if ($modelPoa) {
                $poa_replicate = $modelPoa->replicate()->fill([
                    'year' => $poaYear,
                    'name' => __('general.title.new', ['type' => __('general.poa')]) . ' ' . $poaYear,
                    'progress' => 0,
                    'status' => InProgress::label(),
                    'phase' => Planning::label(),
                    'reviewed' => false,
                    'approved' => null
                ]);

                $poa_replicate->push(); //set in poa_poas table
                $dep = $modelPoa->departments;
                foreach ($dep as $d) {
                    $poa_replicate->departments()->syncWithoutDetaching($d);
                }

                $modelPoa->load('programs.poaActivities.poaActivityIndicator', 'programs.poaActivities.piats');
                $modelPoa->load('configs');
                $relations = $modelPoa->getRelations();
                foreach ($relations as $key => $relation) {
                    foreach ($relation as $relationRecord) {
                        if ($key == 'programs') {
                            $newRelationship = $relationRecord->replicate()->fill([
                                'progress' => 0
                            ]);
                            $newRelationship->poa_id = $poa_replicate->id;
                            $newRelationship->push(); //set in poa_programs table
                            array_push($newProgramId, $newRelationship->id);
                            $modelPoaActivities = $relationRecord->poaActivities;
                            foreach ($modelPoaActivities as $poaActivity) {
                                $newModelPoaActivities = $poaActivity->replicate()->fill([
                                    'status' => PoaActivity::STATUS_SCHEDULED,
                                    'progress' => 0
                                ]);
                                $newModelPoaActivities->poa_program_id = $newRelationship->id;
                                $newModelPoaActivities->push(); //set to poa_activities table
                                $this->ajaxDispatch(new CreateMeasureAdvances($poaActivity));
                                if ($poaActivity->piats) {
                                    $newModelPoaActivitiesPiat = $poaActivity->piats;
                                    foreach ($newModelPoaActivitiesPiat as $activitiesPiat) {
                                        $newModelPoaActivitiesPiat = $activitiesPiat->replicate()->fill([
                                            'is_terminated' => false,
                                            'approved_by' => -1,
                                            'status' => PoaActivityPiat::STATUS_PENDING,
                                            'number_male_respo' => 0,
                                            'number_female_respo' => 0,
                                            'males_beneficiaries' => 0,
                                            'females_beneficiaries' => 0,
                                            'males_volunteers' => 0,
                                            'females_volunteers' => 0
                                        ]);
                                        $newModelPoaActivitiesPiat->piatable_id = $newModelPoaActivities->id;
                                        $newModelPoaActivitiesPiat->push(); //set to poa_activity_piat table
                                        $newModelPoaActivitiesPiatPlans = $activitiesPiat->poaActivityPiatPlan;
                                        $newModelPoaActivitiesPiatRequirements = $activitiesPiat->poaActivityPiatRequirements;
                                        foreach ($newModelPoaActivitiesPiatPlans as $piatPlan) {
                                            $newModelPoaActivitiesPiatPlans = $piatPlan->replicate();
                                            $newModelPoaActivitiesPiatPlans->push();
                                        }
                                        foreach ($newModelPoaActivitiesPiatRequirements as $requirement) {
                                            $newModelPoaActivitiesPiatRequirements = $requirement->replicate();
                                            $newModelPoaActivitiesPiatRequirements->push();
                                        }
                                        if ($activitiesPiat->poaActivityReport->count() > 0) {
                                            $newModelPoaActivitiesPiatReports = $activitiesPiat->poaActivityReport->first()->replicate()->fill([
                                                'accomplished' => false,
                                                'approved_by' => -1
                                            ]);
                                            $newModelPoaActivitiesPiatReports->push();
                                        }
                                    }
                                }
                            }
                        } else if ($key == 'configs') {
                            if (count($newProgramId) > 0) {
                                foreach ($newProgramId as $newId) {
                                    $newRelationship = $relationRecord->replicate();
                                    $newRelationship->poa_id = $poa_replicate->id;
                                    $newRelationship->program_id = $newId;
                                    $newRelationship->push(); //set to poa_indicator_config table
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
            return $this->poa;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
