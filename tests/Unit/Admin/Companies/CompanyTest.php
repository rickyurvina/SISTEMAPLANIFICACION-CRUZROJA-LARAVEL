<?php

namespace Tests\Unit\Admin\Companies;

use App\Models\Admin\Company;
use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function tearDown() :void {
        \Mockery::close();
    }

    /**
     *
     * @test
     * @return void
     */
    public function can_view_index()
    {
        $admin = User::find(1);
        $response = $this->actingAs($admin)->get(route('companies.index'));
        $response->assertOk();
    }

    /**
     *
     * @test
     * @return void
     */
    public function can_view_button_cancel()
    {
        $admin = User::find(1);
        $company = Company::find(1);
        $response = $this->actingAs($admin)->get(route('companies.edit', $company));
        $response->assertSeeInOrder([
            'a href=',
            route('companies.index'),
            "Cancelar",
        ]);
        $response->assertOk();
    }
}
