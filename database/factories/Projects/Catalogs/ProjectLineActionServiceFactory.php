<?php

namespace Database\Factories\Projects\Catalogs;

use App\Models\Projects\Catalogs\ProjectLineAction;
use App\Models\Projects\Catalogs\ProjectLineActionService;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectLineActionServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectLineActionService::class;

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
            'prj_project_catalog_line_actions_id' => ProjectLineAction::factory()
        ];
    }
}
