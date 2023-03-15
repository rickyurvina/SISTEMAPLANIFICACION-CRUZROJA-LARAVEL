<?php

namespace Database\Factories\Auth;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password', // password
            'remember_token' => Str::random(10),
            'locale' => $this->faker->locale,
            'enabled' => $this->faker->boolean(),
            'companies' => ['1'],
            'roles' => ['1'],
        ];
    }

    /**
     * Indicate that the user is enabled.
     *
     * @return Factory
     */
    public function enabled()
    {
        return $this->state(function (array $attributes) {
            return [
                'enabled' => 1,
            ];
        });
    }

    /**
     * Indicate that the user is disabled.
     *
     * @return Factory
     */
    public function disabled()
    {
        return $this->state(function (array $attributes) {
            return [
                'enabled' => 0,
            ];
        });
    }
}
