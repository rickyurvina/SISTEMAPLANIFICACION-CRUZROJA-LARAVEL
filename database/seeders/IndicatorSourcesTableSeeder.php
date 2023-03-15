<?php

namespace Database\Seeders;

use App\Models\Indicators\Threshold\Threshold;
use Illuminate\Database\Seeder;

class IndicatorSourcesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Threshold::factory()->times(1)->create();

        \DB::table('indicator_sources')->delete();

        \DB::table('indicator_sources')->insert(array (
            0 =>
            array (
                'id' => 2,
                'institution' => 'CRE',
                'name' => 'Base de datos atenciones',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'id' => 3,
                'institution' => 'CRE',
                'name' => 'Base de datos diagnósticos',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'id' => 4,
                'institution' => 'CRE',
                'name' => 'Registro de firmas',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'id' => 5,
                'institution' => 'CRE',
                'name' => 'Acta de reunión',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'id' => 6,
                'institution' => 'CRE',
                'name' => 'Acta de entrega - recepción',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'id' => 7,
                'institution' => 'CRE',
                'name' => 'Encuestas',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'id' => 8,
                'institution' => 'CRE',
                'name' => 'Entrevistas',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 =>
            array (
                'id' => 9,
                'institution' => 'CRE',
                'name' => 'Informes',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 =>
            array (
                'id' => 10,
                'institution' => 'CRE',
                'name' => 'Estados financieros',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 =>
            array (
                'id' => 11,
                'institution' => 'CRE',
                'name' => 'Procesos',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 =>
            array (
                'id' => 12,
                'institution' => 'CRE',
                'name' => 'Políticas',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 =>
            array (
                'id' => 13,
                'institution' => 'CRE',
                'name' => 'Inventarios',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 =>
            array (
                'id' => 14,
                'institution' => 'CRE',
                'name' => 'Correos',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 =>
            array (
                'id' => 15,
                'institution' => 'CRE',
                'name' => 'Oficios / memorando',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 =>
            array (
                'id' => 16,
                'institution' => 'CRE',
                'name' => 'Convenios / acuerdos',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 =>
            array (
                'id' => 17,
                'institution' => 'CRE',
                'name' => 'Cartas de interes / compromiso',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 =>
            array (
                'id' => 18,
                'institution' => 'CRE',
                'name' => 'Videos',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 =>
            array (
                'id' => 19,
                'institution' => 'CRE',
                'name' => 'Expediente fotográfico',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 =>
            array (
                'id' => 20,
                'institution' => 'CRE',
                'name' => 'Permiso de funcionamiento',
                'description' => NULL,
                'type' => 'Survey',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 =>
            array (
                'id' => 21,
                'institution' => 'CRE',
                'name' => 'Plan de contingencia',
                'description' => NULL,
                'type' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 =>
            array (
                'id' => 22,
                'institution' => 'CRE',
                'name' => 'Planes',
                'description' => NULL,
                'type' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 =>
            array (
                'id' => 23,
                'institution' => 'CRE',
                'name' => 'Diagnóstico comunitario',
                'description' => NULL,
                'type' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 =>
            array (
                'id' => 24,
                'institution' => 'CRE',
                'name' => 'Certificados',
                'description' => NULL,
                'type' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 =>
            array (
                'id' => 25,
                'institution' => 'CRE',
                'name' => 'Contratos',
                'description' => NULL,
                'type' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}