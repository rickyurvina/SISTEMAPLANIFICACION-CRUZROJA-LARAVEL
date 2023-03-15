<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdatePoaActivityProgress extends Job
{
    protected bool $poaActivityProgressResult;

    protected $id;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $request)
    {
        $this->id = $id;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return int
     * @throws Exception
     */
    public function handle()
    {
        try {//TODO VERIFICAR FUNCIONAMIENTO CON MEN Y WOMEN PROGRESS
            DB::beginTransaction();
            $progressTotal = 0;
            foreach ($this->request as $item) {
                if ($item['menWomenProgressType']) {
                    $item['actual'] = ($item['menProgress'] > 0 ? $item['menProgress'] : 0) + ($item['womenProgress'] > 0 ? $item['womenProgress'] : 0);
                }
                MeasureAdvances::where('measurable_type', PoaActivity::class)
                    ->where('measurable_id', $item['id'])->update([
                        'actual' => $item['actual'],
                        'men_progress' => $item['menProgress'],
                        'women_progress' => $item['womenProgress'],
                    ]);
                $progressTotal += $item['progress'];
            }
            $poaActivity = PoaActivity::find($this->id);
            $poaActivity->progress = $progressTotal;
            $poaActivity->save();
            DB::commit();
            $this->poaActivityProgressResult = true;
        } catch (Exception $exception) {
            $this->poaActivityProgressResult = false;
            throw new Exception($exception->getMessage());
        }
        return $this->poaActivityProgressResult;
    }
}
