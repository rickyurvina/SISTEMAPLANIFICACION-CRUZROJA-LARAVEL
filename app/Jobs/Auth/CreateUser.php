<?php

namespace App\Jobs\Auth;

use App\Abstracts\Job;
use App\Jobs\Admin\CreateContact;
use App\Models\Auth\Permission;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CreateUser extends Job
{
    protected $user;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @param  $request
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Permission
     * @throws Throwable
     */
    public function handle()
    {
        DB::transaction(function () {
            $this->user = User::create($this->request->input());

            if ($this->request->file('picture')) {
                $media = $this->getMedia($this->request->file('picture'), 'users');
                $this->user->attachMedia($media, 'picture');
            }

            if ($this->request->has('permissions')) {
                $this->user->permissions()->attach($this->request->get('permissions'));
            }

            if ($this->request->has('roles')) {
                $this->user->roles()->attach($this->request->get('roles'));
            }

            if ($this->request->has('companies')) {
                $this->user->companies()->attach($this->request->get('companies'));
            }

            if (empty($this->user->companies)) {
                return;
            }
            $company = [];
            $department = [];
            $contCompany = 0;
            if (isset($this->request->companyDepartments)){
                foreach ($this->request->companyDepartments as $element) {
                    if (array_search($element['company_id'], array_column($company, 'company_id')) === false) {
                        $company[$contCompany++] = $element['company_id'];
                    }
                    if (array_search($element['department_id'], array_column($department, 'department_id')) === false) {
                        $department[$element['department_id']] = ['company_id' => $element['company_id']];
                    }

                }
                $this->user->companies()->Sync($company);
                $this->user->departments()->Sync($department);
            }

            if (isset($this->request->userRolesIds)){
                $roles = [];
                foreach ($this->request->userRolesIds as $rol) {
                    if ($rol['selected']) {
                        $element = [];
                        $element['role_id'] = $rol['id'];
                        array_push($roles, $element);
                    }
                }
                $this->user->roles()->Sync($roles);
            }

            foreach ($this->request->files as $item) {
                $media = $this->getMedia($item['file'], 'user', null, $item['observation'], $item['user_id'], $item['date'])->id;
                $this->user->attachMedia($media, 'file');
            }
        });

        return $this->user;
    }
}
