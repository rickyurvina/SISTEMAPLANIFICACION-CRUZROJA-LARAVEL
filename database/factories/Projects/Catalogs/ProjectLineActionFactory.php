<?php

namespace Database\Factories\Projects\Catalogs;

use App\Models\Projects\Catalogs\ProjectLineAction;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectLineActionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectLineAction::class;

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
            'description' => $this->faker->streetName()
        ];
    }
}
