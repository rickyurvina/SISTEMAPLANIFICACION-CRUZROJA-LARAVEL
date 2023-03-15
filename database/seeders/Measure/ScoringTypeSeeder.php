<?php

namespace Database\Seeders\Measure;

use DB;
use Illuminate\Database\Seeder;

class ScoringTypeSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('msr_scoring_types')->insert(
            [
                [
                    'code' => 'yes-no',
                    'name' => 'Si/No',
                    'config' => json_encode([])
                ],
                [
                    'code' => 'goal-only',
                    'name' => 'Meta',
                    'config' => json_encode([
                        1 => [
                            "color" => "green",
                            "value" => 100,
                            "label" => 'Meta'
                        ]
                    ])
                ],
                [
                    'code' => 'goal-red-flag',
                    'name' => 'Meta/Alerta Roja',
                    'config' => json_encode([
                        1 => [
                            "color" => "red",
                            "value" => 33.33333,
                            "label" => 'Rojo'
                        ],
                        2 => [
                            "color" => "green",
                            "value" => 66.66667,
                            "label" => 'Meta'
                        ]
                    ])
                ],
                [
                    'code' => 'three-colors',
                    'name' => '3 Colores',
                    'config' => json_encode([
                        1 => [
                            "color" => "red",
                            "value" => 0,
                            "label" => 'Peor'
                        ],
                        2 => [
                            "color" => "red",
                            "value" => 33.33333,
                            "label" => 'Rojo'
                        ],
                        3 => [
                            "color" => "green",
                            "value" => 66.66667,
                            "label" => 'Meta'
                        ],
                        4 => [
                            "color" => "green",
                            "value" => 100,
                            "label" => 'Mejor'
                        ]
                    ])
                ],
                [
                    'code' => 'two-colors',
                    'name' => '2 Colores',
                    'config' => json_encode([
                        1 => [
                            "color" => "red",
                            "value" => 0,
                            "label" => 'Peor'
                        ],
                        2 => [
                            "color" => "green",
                            "value" => 50,
                            "label" => 'Meta'
                        ],
                        3 => [
                            "color" => "green",
                            "value" => 100,
                            "label" => 'Mejor'
                        ]
                    ])
                ],
                [
                    'code' => '2-colors-stabilize',
                    'name' => 'Banda 2 Colores',
                    'config' => json_encode([
                        1 => [
                            "color" => "red",
                            "value" => 0,
                            "label" => 'Bajo',
                        ],
                        2 => [
                            "color" => "green",
                            "value" => 50,
                            "label" => 'Objetivo',
                        ],
                        3 => [
                            "color" => "green",
                            "value" => 100,
                            "label" => 'Mejor',
                        ],
                        4 => [
                            "color" => "green",
                            "value" => 50,
                            "label" => 'Objetivo',
                        ],
                        5 => [
                            "color" => "red",
                            "value" => 0,
                            "label" => 'Alto',
                        ]
                    ])
                ]
            ]);
    }
}