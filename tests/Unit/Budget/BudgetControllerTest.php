<?php

namespace Tests\Unit\Budget;

use App\Http\Controllers\Budget\BudgetController;
use App\Models\Budget\Transaction;
use Mockery;
use Tests\TestCase;

class BudgetControllerTest extends TestCase
{
    protected $budget;
    protected $view;
    protected $controller;

    public function setUp(): void
    {
        $this->budget = Mockery::mock('App\Http\Controllers\Budget');
        $this->view = Mockery::mock('Illuminate\View\Factory');
        $this->controller = new BudgetController($this->view);

    }


    public function testViewCreateCommitment()
    {
        $transaction=Mockery::type('App\Models\Budget\Transaction');
        $this->budget->shouldReceive('make')
            ->once();
        $this->controller->viewCreateCommitment();
    }

    public function tearDown(): void
    {
        \Mockery::close();
    }
}
