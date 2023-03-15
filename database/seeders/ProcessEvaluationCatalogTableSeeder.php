<?php

namespace Database\Seeders;

use App\Models\Common\Catalog;
use Illuminate\Database\Seeder;

class ProcessEvaluationCatalogTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $catalog_id = Catalog::CatalogName('process_evaluation_catalog')->first()->id;
        \DB::table('catalog_details')->insert(
            [
                'catalog_id' => $catalog_id,
                'code' => 'process_evaluation',
                'description' => 'Catalogo de Evaluacion de Procesos',
                'enabled' => 1,
                'properties' => '[
{
"y": "Excelente",
"x": "Nula",
"color": "#33CC33",
"evaluation_result": 5,
"performance": 5,
"importance": 1
},
{
"y": "Muy Bueno",
"x": "Nula",
"color": "#33CC33",
"evaluation_result": 4,
"performance": 4,
"importance": 1
},
{
"y": "Bueno",
"x": "Nula",
"color": "#F69200",
"evaluation_result": 3,
"performance": 3,
"importance": 1
},
{
"y": "Bajo",
"x": "Nula",
"color": "#F69200",
"evaluation_result": 2,
"performance": 2,
"importance": 1
},
{
"y": "Muy Bajo",
"x": "Nula",
"color": "#F69200",
"evaluation_result": 1,
"performance": 1,
"importance": 1
},

{
"y": "Excelente",
"x": "Baja",
"color": "#33CC33",
"evaluation_result": 10,
"performance": 5,
"importance": 2
},
{
"y": "Muy Bueno",
"x": "Baja",
"color": "#33CC33",
"evaluation_result": 8,
"performance": 4,
"importance": 2
},
{
"y": "Bueno",
"x": "Baja",
"color": "#F69200",
"evaluation_result": 6,
"performance": 3,
"importance": 2
},
{
"y": "Bajo",
"x": "Baja",
"color": "#F69200",
"evaluation_result": 4,
"performance": 2,
"importance": 2
},
{
"y": "Muy Bajo",
"x": "Baja",
"color": "#F69200",
"evaluation_result": 2,
"performance": 1,
"importance": 2
},

{
"y": "Excelente",
"x": "Media",
"color": "#33CC33",
"evaluation_result": 15,
"performance": 5,
"importance": 3
},
{
"y": "Muy Bueno",
"x": "Media",
"color": "#33CC33",
"evaluation_result": 12,
"performance": 4,
"importance": 3
},
{
"y": "Bueno",
"x": "Media",
"color": "#F69200",
"evaluation_result": 9,
"performance": 3,
"importance": 3
},
{
"y": "Bajo",
"x": "Media",
"color": "#F69200",
"evaluation_result": 6,
"performance": 2,
"importance": 3
},
{
"y": "Muy Bajo",
"x": "Media",
"color": "#F69200",
"evaluation_result": 3,
"performance": 1,
"importance": 3
},
{
"y": "Excelente",
"x": "Alta",
"color": "#FFFF00",
"evaluation_result": 20,
"performance": 5,
"importance": 4
},
{
"y": "Muy Bueno",
"x": "Alta",
"color": "#FFFF00",
"evaluation_result": 16,
"performance": 4,
"importance": 4
},
{
"y": "Bueno",
"x": "Alta",
"color": "#CC0027",
"evaluation_result": 12,
"performance": 3,
"importance": 4
},
{
"y": "Bajo",
"x": "Alta",
"color": "#CC0027",
"evaluation_result": 8,
"performance": 2,
"importance": 4
},
{
"y": "Muy Bajo",
"x": "Alta",
"color": "#CC0027",
"evaluation_result": 4,
"performance": 1,
"importance": 4
},
{
"y": "Excelente",
"x": "Vital",
"color": "#FFFF00",
"evaluation_result": 25,
"performance": 5,
"importance": 5
},
{
"y": "Muy Bueno",
"x": "Vital",
"color": "#FFFF00",
"evaluation_result": 20,
"performance": 4,
"importance": 5
},
{
"y": "Bueno",
"x": "Vital",
"color": "#CC0027",
"evaluation_result": 15,
"performance": 3,
"importance": 5
},
{
"y": "Bajo",
"x": "Vital",
"color": "#CC0027",
"evaluation_result": 10,
"performance": 2,
"importance": 5
},
{
"y": "Muy Bajo",
"x": "Vital",
"color": "#CC0027",
"evaluation_result": 5,
"performance": 1,
"importance": 5
}
]',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
        );
    }
}