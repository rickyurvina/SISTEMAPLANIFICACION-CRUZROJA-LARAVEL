<?php

namespace Database\Seeders\Strategy;

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('plans')->delete();
        
        \DB::table('plans')->insert(array (
            0 => 
            array (
                'id' => 1,
                'plan_template_id' => 1,
                'code' => '001',
                'name' => 'PLAN ESTRATÉGICO 2021-2025',
                'description' => 'Las organizaciones humanitarias tienen diversos
desafíos, que deben ser abordados desde su
fortalecimiento y evolución constante. Las
problemáticas socioeconómicas que sufre la
región requieren ser tratadas con acciones
integrales y con una estrecha cooperación entre
pares, para generar resiliencia y desarrollo en las
personas que se han visto afectadas por estos
problemas y que han visto aumentar su
vulnerabilidad.',
                'showVision' => true,
                'vision' => 'Al 2025, Cruz Roja Ecuatoriana será un
referente nacional de la acción humanitaria
neutral, imparcial, a través de su
voluntariado y personal comprometido,
brindando servicios de calidad a las
comunidades, contribuyendo a su desarrollo
sostenible, basados en una gestión
innovadora, transparente y eficiente.',
                'showMission' => true,
                'mission' => 'La CRE trabaja para aliviar y prevenir
el sufrimiento humano, promoviendo
comunidades resilientes orientadas al
desarrollo sostenible, mediante el
accionar neutral e imparcial de su
personal humanitario y el continuo
desarrollo de la Sociedad Nacional,
sustentados en los Principios
Fundamentales del Movimiento.',
                'showTemporality' => true,
                'temporality_start' => 2021,
                'temporality_end' => 2025,
                'responsable' => '1',
                'status' => 'draft',
                'company_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-01-26 04:37:12',
                'updated_at' => '2022-01-26 04:37:12',
            ),
        ));
        
        
    }
}