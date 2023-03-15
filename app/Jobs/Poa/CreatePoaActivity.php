<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Jobs\Measure\CreateMeasureAdvances;
use App\Models\Measure\Calendar;
use App\Models\Measure\MeasureAdvances;
use App\Models\Measure\Period;
use App\Models\Poa\PoaActivity;
use Exception;
use Illuminate\Support\Facades\DB;

class CreatePoaActivity extends Job
{
    protected $poaProgramActivity;

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
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->poaProgramActivity = PoaActivity::create($this->request->all());
            $data = [
                'cost' => $this->poaProgramActivity->cost,
                'impact' => $this->poaProgramActivity->impact,
                'complexity' => $this->poaProgramActivity->complexity,
            ];
            $this->ajaxDispatch(new UpdatePoaActivityWeight($this->poaProgramActivity->id, $this->poaProgramActivity->program->poa->id, $data));
            $this->ajaxDispatch(new CreateMeasureAdvances($this->poaProgramActivity));
            DB::commit();
            return $this->poaProgramActivity;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
