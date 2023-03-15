<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Company;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CreateCompany extends Job
{
    protected $request;
    protected Company $company;

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
     * @return Company
     */
    public function handle(): Company
    {
        DB::transaction(function () {
            $this->company = Company::create($this->request->all());

            setting()->setExtraColumns(['company_id' => $this->company->id]);
            setting()->forgetAll();

            $this->callSeeds();
            $this->updateSettings();
        });
        return $this->company;
    }

    protected function callSeeds()
    {
        // Set custom locale
        if ($this->request->has('locale')) {
            app()->setLocale($this->request->get('locale'));
        }

        // Company seeds
        Artisan::call('company:seed', [
            'company' => $this->company->id
        ]);

        if (!$user = user()) {
            return;
        }

        // Attach company to user logged in
        $user->companies()->attach($this->company->id);
    }

    protected function updateSettings()
    {
        if ($this->request->file('logo')) {
            $company_logo = $this->getMedia($this->request->file('logo'), 'settings', $this->company->id);

            if ($company_logo) {
                $this->company->attachMedia($company_logo, 'company_logo');
                setting()->set('company.logo', $company_logo->id);
            }
        }

        // Create settings
        setting()->set([
            'default.currency' => $this->request->get('currency'),
            'default.locale' => $this->request->get('locale', 'es_ES'),
            'company.name' => $this->request->get('name'),
            'company.domain' => $this->request->get('domain'),
            'company.identification' => $this->request->get('identification'),
            'company.phone' => $this->request->get('phone'),
            'company.fax' => $this->request->get('fax'),
            'company.web_site' => $this->request->get('web_site'),
            'company.description' => $this->request->get('description')
        ]);

        if (!empty($this->request->settings)) {
            foreach ($this->request->settings as $name => $value) {
                setting()->set([$name => $value]);
            }
        }

        setting()->save();
        setting()->forgetAll();
    }
}