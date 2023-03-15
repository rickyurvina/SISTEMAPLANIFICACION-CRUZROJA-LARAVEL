<?php

namespace Database\Factories\Indicators\Threshold;


use App\Models\Indicators\Threshold\Threshold;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThresholdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Threshold::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $propertie = [
            [
                "Ascending",
                "Danger",
                "maxAD",
                "70"
            ],
            [
                "Ascending",
                "Warning",
                "minAW",
                "70"
            ],
            [
                "Ascending",
                "Warning",
                "maxAW",
                "85"
            ],
            [
                "Ascending",
                "Success",
                "minAS",
                "85"
            ],
            [
                "Descending",
                "Danger",
                "maxDD",
                "70"
            ],
            [
                "Descending",
                "Warning",
                "minDW",
                "70"
            ],
            [
                "Descending",
                "Warning",
                "maxDW",
                "85"
            ],
            [
                "Descending",
                "Success",
                "minDS",
                "85"
            ],
            [
                "Tolerance",
                "Danger",
                "maxTD",
                "70"
            ],
            [
                "Tolerance",
                "Warning",
                "minTW",
                "70"
            ],
            [
                "Tolerance",
                "Warning",
                "maxTW",
                "85"
            ],
            [
                "Tolerance",
                "Success",
                "minTS",
                "85"
            ]
        ];
        return [
            'name' =>'Por defecto',
            'properties' => $this->faker->randomElement([$propertie]),
        ];
    }
}
