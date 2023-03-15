<?php

namespace Database\Factories\Projects\Catalogs;

use App\Models\Projects\Catalogs\ProjectLineAction;
use App\Models\Projects\Catalogs\ProjectLineActionService;
use App\Models\Projects\Catalogs\ProjectLineActionServiceActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectLineActionServiceActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectLineActionServiceActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->postcode(),
            'name' => $this->faker->name(),
            'description' => $this->faker->streetName(),
            'service_id' => ProjectLineActionService::factory()
        ];
    }
}
