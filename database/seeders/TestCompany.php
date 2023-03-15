<?php

namespace Database\Seeders;

use App\Abstracts\Model;
use App\Jobs\Admin\CreateCompany;
use App\Jobs\Auth\CreateUser;
use App\Traits\Jobs;
use Illuminate\Database\Seeder;

class TestCompany extends Seeder
{
    use Jobs;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(Permissions::class);

        $this->createCompany();

        $this->createUser();

        Model::reguard();
    }

    private function createCompany()
    {
        $company = $this->dispatch(new CreateCompany([
            'name' => 'My company',
            'domain' => 'company.com',
            'parent_id' => null,
            'currency' => 'USD',
            'locale' => 'es_es',
            'enabled' => '1',
            'identification' => '0000000000001',
            'phone' => '',
            'fax' => '',
            'level' => 1,
            'web_site' => 'www.company.com',
            'description' => 'Company',
        ]));

        session(['company_id' => $company->id]);

        $this->command->info('Test company created.');
    }

    public function createUser()
    {
        $this->dispatch(new CreateUser([
            'name' => 'Test User',
            'email' => 'test@company.com',
            'password' => '123456',
            'locale' => 'en-GB',
            'companies' => [session('company_id')],
            'roles' => ['1'],
            'enabled' => '1',
        ]));

        $this->command->info('Test user created.');
    }
}
