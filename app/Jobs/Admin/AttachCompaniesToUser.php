<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AttachCompaniesToUser extends Job
{

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
            $companies = [];
            DB::beginTransaction();
            $roles = $this->request->all();
            foreach ($roles as $role) {
                $company = self::extractCompaniesFromRoles($role);
                if ($company) {
                    array_push($companies, $company->id);
                }
            }
            user()->companies()->sync($companies);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param $role
     * @return string
     */
    public function extractCompaniesFromRoles($role)
    {
        $company = '';
        $name = strtolower($role);
        $name = trim($name);
        $arrayName = explode("_", $name);
        if (is_array($arrayName)) {
            if ($arrayName[0] == 'junta') {
                $item = $arrayName[1];
                $company = Company::whereHas('settings', function (Builder $q) use ($item) {
                    $q->where('value', $item)->withoutGlobalScope(\App\Scopes\Company::class);
                })->enabled()->first();
            }
        }
        return $company ?? '';
    }
}
