<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrjProjectCatalogLineActionServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('prj_project_catalog_line_action_services')->delete();
        
        \DB::table('prj_project_catalog_line_action_services')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'GR101',
                'name' => 'Fortalecimiento de capacidades en adaptación al cambio climático',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'GR102',
                'name' => 'Diagnósticos de riesgos climáticos',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'GR103',
                'name' => 'Implementación de acciones comunitarias de Adaptación al Cambio Climático',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'GR104',
                'name' => 'Diagnósticos y planes de acción comunitario',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'GR105',
                'name' => 'Planes de contingencia comunitarios',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'GR106',
                'name' => 'Campañas de sensibilización comunitaria e institucional',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'GR107',
                'name' => 'Planes Familiares de Emergencia',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'GR108',
                'name' => 'Herramientas y materiales didacticos de sensibilización y aprendizaje',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'GR109',
                'name' => 'Capacitación en Primeros Auxilios Básicos, Gestión de Riesgos, Evacuación, Planes de Emergencia ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'GR110',
                'name' => 'Conformación, equipamiento de brigadas comunitarias e institucionales',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'GR111',
                'name' => 'Planes de acciones anticipatorias',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'GR112',
                'name' => 'Asesoría técnica en la implementación de acciones mitigables, para reducir riesgos existentes.',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 1,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'GR201',
                'name' => 'Planes de contingencia y emergencia',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'GR202',
                'name' => 'Sistemas de alerta temprana',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'GR203',
                'name' => 'Atención Prehospitalaria',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'GR204',
                'name' => 'Acciones de apoyo en operativos',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'GR205',
                'name' => 'Diagnóstico en emergencias - Evaluación de daños y análisis de necesidades',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'GR206',
                'name' => 'Salvamento búsqueda y rescate',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'GR207',
                'name' => 'Apoyo a la evacuación',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'GR208',
                'name' => 'Asistencia humanitaria',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 2,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'GR301',
                'name' => 'Forlecimiento de capacidades a fin de identificar e implementar procedimientos de intervencion en comunidades.',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'GR302',
                'name' => 'Brindar información oportuna y accesible sobre las intervenciones ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'GR303',
                'name' => 'Encuestas de satisfacción de los servicios implementados',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 3,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'GR401',
                'name' => 'Realizar diagnósticos de medios de vida en emergencia',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'GR402',
                'name' => 'Evaluación de estudios de mercados ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 'GR403',
                'name' => 'Fortalecimiento de ideas de negocios',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 'GR404',
                'name' => 'Creación de emprendimientos',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 'GR405',
                'name' => 'Fortalecimiento de los medios de vida',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'code' => 'GR406',
                'name' => 'Restablecimiento de los medios de vida en emergencias',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 4,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'code' => 'GR501',
            'name' => 'Reportes estadísticos dinámicos (Información primaria y secundaria)',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 5,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'code' => 'GR502',
            'name' => 'Reportes estadísticos dinámicos (Líneas misionales-Proyectos)',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 5,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'code' => 'GR503',
                'name' => 'Fortalecimiento en manejo de herramientas digitales para el levantamiento de información',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 5,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'code' => 'GR504',
            'name' => 'Fortalecimiento en manejo de Equipos GPS Navegadores (Global Positioning System), Drones para el registro y levantamiento de información',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 5,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'code' => 'GR505',
            'name' => 'Fortalecimiento en manejo de los sistemas de información geográfica (SIG-Software)',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 5,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'code' => 'GR506',
                'name' => 'Desarrollo e implementación de formularios digitales para la recolección de datos en territorio',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 5,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'code' => 'GR507',
                'name' => 'Desarrollo de Analisis Espacial para escenarios Inductivos y Deductivos ante poisbles eventos producidos por fenómenos naturales',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 5,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'code' => 'GR508',
                'name' => 'Desarrollo de Analisis Espacial para escenarios Inductivos y Deductivos ante posibles eventos antrópicos',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 5,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'code' => 'GR601',
                'name' => 'Operatividad del sistema telecomunicaciones a nivel nacional',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 6,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'code' => 'GR602',
                'name' => 'Red de repetidoras en funcionamiento a nivel nacional',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 6,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'code' => 'GR603',
                'name' => 'Cobertura con telecomunicaciones en operativos y emergencias',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 6,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'code' => 'SC101',
                'name' => 'Educomunicación en salud sexual y reproductiva',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'code' => 'SC102',
                'name' => 'Educomunicación en prevención de la infección por VIH ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'code' => 'SC103',
                'name' => 'Educomunicación en enfermedades crónicas no transmisibles',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'code' => 'SC104',
                'name' => 'Educomunicación en envejecimiento saludable',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'code' => 'SC105',
                'name' => 'Educomunicación para la prevención del uso indebido de drogas',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'code' => 'SC106',
                'name' => 'Educomunicación en salud  materno infantil',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'code' => 'SC107',
                'name' => 'Acceso a agua segura',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'code' => 'SC108',
                'name' => 'Control de vectores y desinfección de superficies.',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'code' => 'SC109',
                'name' => 'Promoción de la higiene ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'code' => 'SC110',
                'name' => 'Prevención de enfermedades hídricas vectorales y endémicas.',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 7,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'code' => 'SC201',
                'name' => 'Apoyo a la contención y prevención de enfermedades emergentes y reemergentes',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 8,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'code' => 'SC202',
                'name' => 'Vigilancia Epidemiológica con enfoque comunitario',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 8,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'code' => 'SC203',
                'name' => 'Atención Primaria de Salud ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 8,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'code' => 'SC204',
                'name' => 'Fomento al manejo digno de cadáveres en situaciones de emergencia y desastres',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 8,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'code' => 'SC301',
                'name' => 'Prevención del suicidio',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 9,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'code' => 'SC302',
                'name' => 'Primeros Auxilios Psicológicos',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 9,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'code' => 'SC303',
                'name' => 'Psicoeducación',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 9,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'code' => 'SC304',
                'name' => 'Atención Psicoemocional',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 9,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'code' => 'SC305',
                'name' => 'Consultas Psicológicas',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 9,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 60,
                'code' => 'JU101',
                'name' => 'Brigadas juveniles / Conformación y Gestión Sistema de brigadas',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'code' => 'JU102',
                'name' => 'Brigadas juveniles / Formación Institucional',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'code' => 'JU103',
                'name' => 'Brigadas juveniles / Desarrollo de habilidades de liderazgo',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'code' => 'JU104',
                'name' => 'Brigadas juveniles / Vinculación Cumunitaria',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'code' => 'JU105',
                'name' => 'Brigadas juveniles / Desarrollo de Campañas',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'code' => 'JU106',
                'name' => 'Brigadas juveniles / Buen uso del tiempo libre',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'code' => 'JU107',
                'name' => 'Curso de liderazgo / Nivel 1: Desarrollo de habilidades Sociales ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 67,
                'code' => 'JU108',
                'name' => 'Curso de liderazgo / Nivel 2: Desarrollo de habilidades de Gestión',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 68,
                'code' => 'JU109',
                'name' => 'Curso de liderazgo / Nivel 3: Desarrollo de habilidades de Gobierno',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 69,
                'code' => 'JU110',
                'name' => 'Curso de liderazgo / Formación de mentores de Liderazgo',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 10,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 70,
                'code' => 'JU201',
                'name' => 'Formación en Cultura de Paz y no violencia',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 11,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 71,
                'code' => 'JU202',
                'name' => 'Campañas de Cultura de Paz y no violencia',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 11,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 72,
                'code' => 'JU203',
                'name' => 'Formación de jóvenes como agentes de cambio de comportamiento',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 11,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 73,
                'code' => 'JU204',
                'name' => 'Formación metodología entre risas y sonrisas',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 11,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 74,
                'code' => 'JU205',
                'name' => 'Formación metodología mis Izquierdos y mis Derechos  ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 11,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 75,
                'code' => 'JU301',
                'name' => 'SIFI / Catarsis Webinar',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 12,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 76,
                'code' => 'JU302',
                'name' => 'SIFI / Catarsis Postcas ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 12,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 77,
                'code' => 'JU303',
                'name' => 'SIFI / Catarsis Live',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 12,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 78,
                'code' => 'JU304',
            'name' => 'SIFI / HIT (Habla, Inspira,  Transforma)',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 12,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 79,
                'code' => 'JU305',
                'name' => 'SIFI / BOOT CRE',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 12,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 80,
                'code' => 'JU306',
            'name' => 'SIFI / MERAKI  (Coworking)',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 12,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 81,
                'code' => 'JU307',
            'name' => 'SIFI / MERAKI  (APP)',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 12,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 82,
                'code' => 'JU308',
            'name' => 'SIFI / JUVENTIA (Formación de Mentores)',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 12,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 83,
                'code' => 'JU309',
                'name' => 'Formación Basico en Innovación Social',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 12,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 84,
                'code' => 'PV101',
                'name' => 'Sensibilización y capacitacíon en DIH, difusión interna al personal humanitario y rentado; difusión exeterna a públicos priorizados como FF.AA, Policía Nacional, academia y organizaciones de la sociedad civil.',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 13,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 85,
                'code' => 'PV102',
                'name' => 'Elaboración de herramientas e insumos de Diplomacia Humanitaria a fin de orientar a líderes sobre el accionar de la CRE en tiempos de emergencia por disturbios, crísis carcelaria, movilizaciones sociales y otras situaciones de violencia.',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 13,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 86,
                'code' => 'PV103',
                'name' => 'Formación y sensibilización al personal humanitario, rentado y comunidad en temas de Doctrina Institucional:  difusión de la historia, estructura,  mandatos, los principios fundamentales y valores humanitarios del Movimiento. ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 13,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 87,
                'code' => 'PV104',
                'name' => 'Generación de  herramientas, productos comunicacionales y campañas de sensibilización hacia la comunidad a fin de potenciar el buen uso, protección y respeto al Emblema y a los Principios Fundamentales. ',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 13,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 88,
                'code' => 'PV201',
            'name' => 'Prevenir la separación o la pérdida del contacto entre familias, asegurando la transmisión de mensajes claves conforme a las necesidades de los diferentes contextos (conflicto armado, migración, desastres y otras crisis humanitarias)  y asegurar que las f',
                'description' => NULL,
                'prj_project_catalog_line_actions_id' => 14,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 89,
                'code' => 'PV202',
                'name' => 'Fortalecer la respuesta en materia de RCF conforme a las necesidades de los diferentes contextos, mediante la prestación de servicios (conectividad, noticias familiares, servicios para personas en condición de vulnerabilidad y menores de edad, solicitud d',
                    'description' => NULL,
                    'prj_project_catalog_line_actions_id' => 14,
                    'deleted_at' => NULL,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
                89 => 
                array (
                    'id' => 90,
                    'code' => 'PV203',
                    'name' => 'Aumentar las respuestas a los familiares, con énfasis en la calidad de los servicios de RCF y trabajar en el incremento de capacidad para ayudar a las familias a mantener o restablecer el contacto con sus seres queridos en situaciones de emergencia.',
                    'description' => NULL,
                    'prj_project_catalog_line_actions_id' => 14,
                    'deleted_at' => NULL,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
                90 => 
                array (
                    'id' => 91,
                    'code' => 'PV201',
                    'name' => 'Prestar apoyo personalizado a los familiares de las personas desaparecidas y a los familiares separados ',
                    'description' => NULL,
                    'prj_project_catalog_line_actions_id' => 14,
                    'deleted_at' => NULL,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
                91 => 
                array (
                    'id' => 92,
                    'code' => 'PV301',
                'name' => 'Sensibilización y capacitación a personal humanitario (rentado y/o voluntario) en temas y enfoques de movilidad humana y PGI. ',
                    'description' => NULL,
                    'prj_project_catalog_line_actions_id' => 15,
                    'deleted_at' => NULL,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
                92 => 
                array (
                    'id' => 93,
                    'code' => 'PV301',
                    'name' => 'Generación de herramientas institucionales técnicas, lúdicas, metodológicas y otras, para impulsar la sensibilización, conocimiento e implementación de enfoques en Movilidad Humana y PGI.',
                    'description' => NULL,
                    'prj_project_catalog_line_actions_id' => 15,
                    'deleted_at' => NULL,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
                93 => 
                array (
                    'id' => 94,
                    'code' => 'PV301',
                'name' => 'Sensibilización a comunidades (público en general) en temas de movilidad humana y PGI. (Actividades Comunitarias - Microproyectos - Actividades Artístico culturales - otros.)',
                    'description' => NULL,
                    'prj_project_catalog_line_actions_id' => 15,
                    'deleted_at' => NULL,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
                94 => 
                array (
                    'id' => 95,
                    'code' => 'PV301',
                    'name' => 'Generación de herramientas lúdicas, campañas y otros para la sensibilización a las comunidades sobre temas de MH-PGI.',
                    'description' => NULL,
                    'prj_project_catalog_line_actions_id' => 15,
                    'deleted_at' => NULL,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                ),
                95 => 
                array (
                    'id' => 96,
                    'code' => 'PV301',
                    'name' => 'Identificación, socialización y promoción de rutas de acceso para denuncia o atención en situaciones de vulneración de derechos a la comunidad (violencia basada en género, NNA solos o separados, necesidades personas con discapacidad, adultos mayores, pobl',
                        'description' => NULL,
                        'prj_project_catalog_line_actions_id' => 15,
                        'deleted_at' => NULL,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                ));
        
        
    }
}