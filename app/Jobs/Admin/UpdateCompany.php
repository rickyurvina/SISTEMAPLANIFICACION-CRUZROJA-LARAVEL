<?php

namespace App\Jobs\Admin;

use App\Abstracts\Job;
use App\Models\Admin\Company;

class UpdateCompany extends Job
{
    protected $request;

    /**
     * Create a new job instance.
     *
     * @param $request
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
        Company::where('id', $this->request->get('id'))
            ->update([
                'level' => $this->request->get('level'),
                'parent_id' => $this->request->get('parent_id')
            ]);

        // Clear settings
        setting()->setExtraColumns(['company_id' => $this->request->get('id')]);
        setting()->forgetAll();

        $this->updateSettings();

    }


    protected function updateSettings()
    {
        // Update settings
        setting()->set([
            'localisation.timezone' => 'UTC',
            'localisation.date_format' => 'd M Y',
            'localisation.date_separator' => 'space',
            'localisation.percent_position' => 'after',
            'default.list_limit' => '25',
            'default.currency' => 'USD',
            'default.locale' =>'es_ES',
            'company.name' => $this->request->get('name'),
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