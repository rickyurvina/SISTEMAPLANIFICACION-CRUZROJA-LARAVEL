<?php

namespace Database\Factories\Auth;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }

    /**
     * Set Roles permissions.
     *
     * @return Factory
     */
    public function permissions(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'permissions' => Permission::take(10)->pluck('id')->toArray()
            ];
        });
    }
}
