<?php

namespace App\Jobs\Poa;

use App\Abstracts\Job;
use App\Models\Poa\Piat\PoaActivityPiat;
use App\Models\Poa\Piat\PoaPiatActivityResponsibles;
use Exception;
use Illuminate\Support\Facades\DB;

class CreatePoaActivityPiat extends Job
{
    protected $poaActivityPiat;

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
     * @throws Exception        $this->request = $this->getRequestInstance($request);

     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->poaActivityPiat = PoaActivityPiat::create($this->request->all());
            if (count($this->request->users_selected)>0){
                $usersSelected=$this->request->users_selected;
                foreach ($usersSelected as $item){
                    PoaPiatActivityResponsibles::create([
                        'user_id'=>$item,
                        'poa_activity_piat_id'=>  $this->poaActivityPiat->id
                    ]);
                }
            }
            DB::commit();
            return $this->poaActivityPiat;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}
