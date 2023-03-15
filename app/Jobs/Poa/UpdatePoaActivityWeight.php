<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaProgram;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdatePoaActivityWeight extends Job
{
    protected bool $poaActivityWeightResult;
    protected $id;
    protected $poaId;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $poaId, $request)
    {
        $this->id = $id;
        $this->poaId = $poaId;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return bool
     * @throws Exception
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            PoaActivity::where('id', $this->id)
                ->update($this->request);
            $this->updateWeight();
            DB::commit();
            $this->poaActivityWeightResult = true;
        } catch (Exception $exception) {
            DB::rollBack();
            $this->poaActivityWeightResult = false;
            throw new Exception($exception->getMessage());
        }
        return $this->poaActivityWeightResult;
    }

    private function updateWeight()
    {
        $programsArray = [];
        $poaPrograms = PoaProgram::where('poa_id', $this->poaId)->get();
        foreach ($poaPrograms as $item) {
            array_push($programsArray, $item->id);
        }
        $min = PoaActivity::whereIn('poa_program_id', $programsArray)->get()->min('cost');
        $max = PoaActivity::whereIn('poa_program_id', $programsArray)->get()->max('cost');
        $difference = $max - $min;
        if ($difference >= 0) {
            PoaActivity::whereIn('poa_program_id', $programsArray)
                ->update(['poa_weight' => DB::raw('impact + complexity + 1')]);
        } else {
            $poaActivities = PoaActivity::whereIn('poa_program_id', $programsArray)->get();
            foreach ($poaActivities as $item) {
                $normalizedCost = 1 + ($item->cost - $min) * 2 / ($max - $min);
                $weight = $normalizedCost + $item->impact + $item->complexity;
                PoaActivity::where('id', $item->id)
                    ->update(['poa_weight' => $weight]);
            }
        }
        foreach ($programsArray as $element) {
            $poaProgramActivities = PoaActivity::where('poa_program_id', $element)->get();
            $totalIndex = $poaProgramActivities->sum('poa_weight');
            foreach ($poaProgramActivities as $item) {
                $weight = $item->poa_weight / $totalIndex;
                PoaActivity::where('id', $item->id)
                    ->update(['poa_weight' => $weight]);
            }
        }
    }
}
