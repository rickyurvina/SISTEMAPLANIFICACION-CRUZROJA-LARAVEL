<?php

namespace Tests\Unit\Poa;

use App\Http\Controllers\Poa\PoaController;
use App\Jobs\Admin\CreateCompany;
use App\Jobs\Poa\CreatePoa;
use App\Models\Admin\Company;
use App\Models\Auth\User;
use App\Models\Poa\Poa;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery;
use Tests\Feature\FeatureTestCase;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class PoaControllerTest extends TestCase //PHPUnit_Framework_TestCase 
{
    /** @before */
    public function create_mocks() {

        $this->poaModel = Mockery::mock('App\Models\Poa\Poa');
        $this->companyModel = Mockery::mock('App\Models\Admin\Company');
        $this->view = Mockery::mock('Illuminate\View\Factory');
    }

    /** @after */
    public function close_mocks() {
        Mockery::close();
    }

    /**@return void */
    // public function testPoaListView() {
    //     $response = $this->get('poa/poas');

    //     $response->assertStatus(302);
    // }

    /**@return void */
    // public function testPoaReportsView() {

    //     $theUser = User::find(1);
    //     // $response = $this->actingAs($admin)->get(route('companies.index'));
    //     // $response->assertOk();
    //     dd($theUser->toArray());
    //     $response = $this->actingAs($theUser)->get(route('poa.reports', [1]));

    //     // $response->assertOk();
    //     $response->assertStatus(200);
    // }

    /** @test */
    public function testStore() {

//        $companyData = [
//            'level' => 1,
//            'parent_id' => null,
//            'domain' => '',
//            'enabled' => true,
//        ];
//        $this->companyModel->shouldReceive('find')->with(1)->once()/*->andReturn(Company::class)*/;
//        $companySaved = (new CreateCompany($companyData))->handle();
//        dd($companySaved);
//        $data = [
//            'year' => 2023,
//            'name' => 'Nuevo Test Poa',
//            'user_id_in_charge' => 1,
//            'status' => 'EN PROCESO',
//            'phase' => 'Planificación',
//            'company_id' => 1,
//        ];
//
//        $this->poaModel->shouldReceive('create');
//        $poaSaved = (new CreatePoa($data))->handle();
//
//        dd($poaSaved);
    }

    /** @test */
    // public function testIndex() {

    //     $ctr = new PoaController();

    //     $newArray = [];
    //     for($i = 1; $i <= 2; $i++) {
    //         $poa = ([
    //             'id' => $i, 
    //             'year' => 2022,
    //             'name' => 'Nuevo Poa',
    //             'user_id_in_charge' => 1,
    //             'status' => 'EN PROCESO',
    //             'progress' => 0,
    //             'company_id' => 1,
    //             'reviewed' => false,
    //             'approve' => null,
    //             'phase' => 'Planificación',
    //         ]);
    //         array_push($newArray, $poa);
    //     }
        
    //     //$this->poaModel->shouldReceive('count')->once()->andReturn(1);
    //     // $this->poaModel->shouldReceive('collect')->once()->andReturn($poa);

    //     return $ctr->index()->with('modules.poa.poas.list', $newArray);
    // }
}
