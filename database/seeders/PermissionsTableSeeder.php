<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */

    public function run()
    {

        \DB::table('role_has_permissions')->delete();
        \DB::table('permissions')->delete();
        \DB::table('permissions')->insert(array(
            0 =>
                array(
                    'name' => 'admin-manage-users',
                    'display_name' => 'Auth Users',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:36',
                    'updated_at' => '2022-04-21 18:02:36',
                    'spanish_label' => 'Administrar Usuarios',
                ),
            1 =>
                array(
                    'name' => 'admin-manage-companies',
                    'display_name' => 'Admin Companies',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:36',
                    'updated_at' => '2022-04-21 18:02:36',
                    'spanish_label' => 'Administrar Compañías',
                ),
            2 =>
                array(
                    'name' => 'admin-manage-departments',
                    'display_name' => 'Admin Departments',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:37',
                    'updated_at' => '2022-04-21 18:02:37',
                    'spanish_label' => 'Administrar Estructura Organizacional',
                ),
            3 =>
                array(
                    'name' => 'admin-manage-roles',
                    'display_name' => 'Auth Roles',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:36',
                    'updated_at' => '2022-04-21 18:02:36',
                    'spanish_label' => 'Administrar Roles',
                ),
            4 =>
                array(
                    'name' => 'poa-manage-changeControl',
                    'display_name' => 'Poa Manage Changecontrol',
                    'guard_name' => 'web',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'spanish_label' => 'Administrar Cambios de Control de POA',
                ),
            5 =>
                array(
                    'name' => 'poa-manage-changeGoal',
                    'display_name' => 'Poa Manage Changegoal',
                    'guard_name' => 'web',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'spanish_label' => 'Administrar Cambio de Metas de POA',
                ),
            6 =>
                array(
                    'name' => 'poa-manage-reschedulings',
                    'display_name' => 'Poa Manage Reschedulings',
                    'guard_name' => 'web',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'spanish_label' => 'Administrar Reprogramaciones de POA',
                ),
            7 =>
                array(
                    'name' => 'poa-approve-rescheduling',
                    'display_name' => 'Poa Approve Rescheduling',
                    'guard_name' => 'web',
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'spanish_label' => 'Aprobar Reprogramaciones de POA',
                ),
            8 =>
                array(
                    'name' => 'project-manage-team',
                    'display_name' => 'Project Manage Team',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:37',
                    'updated_at' => '2022-04-21 18:02:37',
                    'spanish_label' => 'Administrar Equipo de Proyecto',
                ),
            9 =>
                array(
                    'name' => 'project-view-team',
                    'display_name' => 'Project View Team',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:37',
                    'updated_at' => '2022-04-21 18:02:37',
                    'spanish_label' => 'Ver Equipo de Proyecto ',
                ),
            10 =>
                array(
                    'name' => 'poa-approve-poas',
                    'display_name' => 'Poa Approve Poas',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:37',
                    'updated_at' => '2022-04-21 18:02:37',
                    'spanish_label' => 'Aprobar POA',
                ),
            11 =>
                array(
                    'name' => 'admin-read-admin',
                    'display_name' => 'Admin Read Admin',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:37',
                    'updated_at' => '2022-04-21 18:02:37',
                    'spanish_label' => 'Ver Módulo Admin',
                ),
            12 =>
                array(
                    'name' => 'strategy-crud-strategy',
                    'display_name' => 'Strategy Crud Strategy',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:37',
                    'updated_at' => '2022-04-21 18:02:37',
                    'spanish_label' => 'Administrar Módulo Estrategia',
                ),
            13 =>
                array(
                    'name' => 'project-super-admin',
                    'display_name' => 'Project Super Admin Project',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:37',
                    'updated_at' => '2022-04-21 18:02:37',
                    'spanish_label' => 'Super Administrador de Proyectos',
                ),
            14 =>
                array(
                    'name' => 'project-view-reports',
                    'display_name' => 'Project View Reports',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Reportes de Proyecto',
                ),
            15 =>
                array(
                    'name' => 'project-manage-referentialBudget',
                    'display_name' => 'Project Manage Referentialbudget',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Presupuesto Referencial',
                ),
            16 =>
                array(
                    'name' => 'project-view-files',
                    'display_name' => 'Project View Files',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Archivos de Proyecto',
                ),
            17 =>
                array(
                    'name' => 'process-manage-process',
                    'display_name' => 'Process Manage Process',
                    'guard_name' => 'web',
                    'created_at' => '2022-06-22 11:56:25',
                    'updated_at' => '2022-06-22 11:56:25',
                    'spanish_label' => 'Administrar Proceso',
                ),
            18 =>
                array(
                    'name' => 'process-manage-activities-process',
                    'display_name' => 'Process Manage Activities Process',
                    'guard_name' => 'web',
                    'created_at' => '2022-06-22 11:56:26',
                    'updated_at' => '2022-06-22 11:56:26',
                    'spanish_label' => 'Administrar Actividades de Proceso',
                ),
            19 =>
                array(
                    'name' => 'project-view-logicFrame',
                    'display_name' => 'Project View Logicframe',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:37',
                    'updated_at' => '2022-04-21 18:02:37',
                    'spanish_label' => 'Ver Marco Lógico',
                ),
            20 =>
                array(
                    'name' => 'project-view-acquisitions',
                    'display_name' => 'Project View Acquisitions',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Adquisiciones de Proyecto',
                ),
            21 =>
                array(
                    'name' => 'project-view-governance',
                    'display_name' => 'Project View Governance',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Gobernancia de Proyecto',
                ),
            22 =>
                array(
                    'name' => 'process-manage-risks-process',
                    'display_name' => 'Process Manage Risks Process',
                    'guard_name' => 'web',
                    'created_at' => '2022-06-22 11:56:26',
                    'updated_at' => '2022-06-22 11:56:26',
                    'spanish_label' => 'Administrar Riesgo de Proceso',
                ),
            23 =>
                array(
                    'name' => 'project-view-timetable',
                    'display_name' => 'Project View Timetable',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Cronograma de Proyecto',
                ),
            24 =>
                array(
                    'name' => 'project-manage-formulatedDocument',
                    'display_name' => 'Project Manage Formulateddocument',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Documento Formulado',
                ),
            25 =>
                array(
                    'name' => 'project-view-summary',
                    'display_name' => 'Project View Summary',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Resumen de Proyecto',
                ),
            26 =>
                array(
                    'name' => 'project-view-learnedLessons',
                    'display_name' => 'Project View Learnedlessons',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Lecciones Aprendidas',
                ),
            27 =>
                array(
                    'name' => 'project-view-events',
                    'display_name' => 'Project View Events',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Eventos de Proyecto',
                ),
            28 =>
                array(
                    'name' => 'process-view-files-process',
                    'display_name' => 'Process View Files Process',
                    'guard_name' => 'web',
                    'created_at' => '2022-06-22 11:56:26',
                    'updated_at' => '2022-06-22 11:56:26',
                    'spanish_label' => 'Ver Archivos de Proceso',
                ),
            29 =>
                array(
                    'name' => 'process-manage-changes',
                    'display_name' => 'Process Manage Changes',
                    'guard_name' => 'web',
                    'created_at' => '2022-06-22 11:56:26',
                    'updated_at' => '2022-06-22 11:56:26',
                    'spanish_label' => 'Administrar Plan de Cambios',
                ),
            30 =>
                array(
                    'name' => 'project-manage-administrativeTasks',
                    'display_name' => 'Project Manage Administrativetasks',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Actividades Administrativas',
                ),
            31 =>
                array(
                    'name' => 'project-view-reschedulings',
                    'display_name' => 'Project View Reschedulings',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Reprogramaciones de Proyecto',
                ),
            32 =>
                array(
                    'name' => 'process-view-changes',
                    'display_name' => 'Process View Changes',
                    'guard_name' => 'web',
                    'created_at' => '2022-06-22 11:56:26',
                    'updated_at' => '2022-06-22 11:56:26',
                    'spanish_label' => 'Ver Plan de Cambios ',
                ),
            33 =>
                array(
                    'name' => 'process-view-indicators',
                    'display_name' => 'Process View Indicators',
                    'guard_name' => 'web',
                    'created_at' => '2022-06-22 11:56:26',
                    'updated_at' => '2022-06-22 11:56:26',
                    'spanish_label' => 'Ver Indicadores de Proceso',
                ),
            34 =>
                array(
                    'name' => 'project-view-evaluations',
                    'display_name' => 'Project View Evaluations',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Validaciones de Proyecto',
                ),
            35 =>
                array(
                    'name' => 'poa-approve-piat-report',
                    'display_name' => 'Poa Approve Piat Report',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Aprobar Reporte PIAT',
                ),
            36 =>
                array(
                    'name' => 'project-view-risks',
                    'display_name' => 'Project View Risks',
                    'guard_name' => 'web',
                    'created_at' => '2022-04-21 18:02:37',
                    'updated_at' => '2022-04-21 18:02:37',
                    'spanish_label' => 'Ver Riesgos de Proyecto',
                ),
            37 =>
                array(
                    'name' => 'process-manage-indicators',
                    'display_name' => 'Process Manage Indicators',
                    'guard_name' => 'web',
                    'created_at' => '2022-06-22 11:56:26',
                    'updated_at' => '2022-06-22 11:56:26',
                    'spanish_label' => 'Administrar Indicadores de Proceso',
                ),
            38 =>
                array(
                    'name' => 'project-manage-validations',
                    'display_name' => 'Project Manage Validations',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Validaciones de Proyecto',
                ),
            39 =>
                array(
                    'name' => 'project-view-activities',
                    'display_name' => 'Project View Activities',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Administrar Actividades de Proyecto',
                ),
            40 =>
                array(
                    'name' => 'project-manage-risks',
                    'display_name' => 'Project Manage Risks',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Riesgos de Proyecto',
                ),
            41 =>
                array(
                    'name' => 'process-view-process-information',
                    'display_name' => 'Process View Process Information',
                    'guard_name' => 'web',
                    'created_at' => '2022-06-22 11:56:26',
                    'updated_at' => '2022-06-22 11:56:26',
                    'spanish_label' => 'Ver Información de Proceso',
                ),
            42 =>
                array(
                    'name' => 'project-view-administrativeTasks',
                    'display_name' => 'Project View Administrativetasks',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Actividades Administrativas',
                ),
            43 =>
                array(
                    'name' => 'project-view-validations',
                    'display_name' => 'Project View Validations',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Validaciones de Proyecto',
                ),
            44 =>
                array(
                    'name' => 'project-manage-acquisitions',
                    'display_name' => 'Project Manage Acquisitions',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Adquisiciones de Proyecto',
                ),
            45 =>
                array(
                    'name' => 'process-view-activities-process',
                    'display_name' => 'Process View Activities Process',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Actividades de Proceso',
                ),
            46 =>
                array(
                    'name' => 'project-view-communication',
                    'display_name' => 'Project View Communication',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Comunicaciones de Proyecto',
                ),
            47 =>
                array(
                    'name' => 'process-manage-conformities',
                    'display_name' => 'Process Manage Conformities',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar No Conformidades',
                ),
            48 =>
                array(
                    'name' => 'project-manage-timetable',
                    'display_name' => 'Project Manage Timetable',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Cronograma de Proyecto',
                ),
            49 =>
                array(
                    'name' => 'process-view-process',
                    'display_name' => 'Process View Process',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Proceso',
                ),
            50 =>
                array(
                    'name' => 'project-manage-learnedLessons',
                    'display_name' => 'Project Manage Learnedlessons',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Lecciones Aprendidas',
                ),
            51 =>
                array(
                    'name' => 'project-manage-calendar',
                    'display_name' => 'Project Manage Calendar',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Calendario de Proyecto',
                ),
            52 =>
                array(
                    'name' => 'project-manage-reschedulings',
                    'display_name' => 'Project Manage Reschedulings',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Reprogramaciones de Proyecto',
                ),
            53 =>
                array(
                    'name' => 'project-approve-rescheduling',
                    'display_name' => 'Project Approve Rescheduling',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Aprobar Reprogramación de Proyecto',
                ),
            54 =>
                array(
                    'name' => 'project-view-stakeholders',
                    'display_name' => 'Project View Stakeholders',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Personas Interesadas',
                ),
            55 =>
                array(
                    'name' => 'process-manage-files-process',
                    'display_name' => 'Process Manage Files Process',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Archivos de Proceso',
                ),
            56 =>
                array(
                    'name' => 'project-view-calendar',
                    'display_name' => 'Project View Calendar',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Calendario de Proyecto',
                ),
            57 =>
                array(
                    'name' => 'project-manage-evaluations',
                    'display_name' => 'Project Manage Evaluations',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Evaluaciones',
                ),
            58 =>
                array(
                    'name' => 'project-view-referentialBudget',
                    'display_name' => 'Project View Referentialbudget',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Presupuesto Referencial',
                ),
            59 =>
                array(
                    'name' => 'project-manage-stakeholders',
                    'display_name' => 'Project Manage Stakeholders',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Personas Interesadas ',
                ),
            60 =>
                array(
                    'name' => 'process-close-conformities',
                    'display_name' => 'Process Close Conformities',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Cerrar No Conformidades',
                ),
            61 =>
                array(
                    'name' => 'project-manage-files',
                    'display_name' => 'Project Manage Files',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Archivos de Proyecto',
                ),
            62 =>
                array(
                    'name' => 'project-manage-activities',
                    'display_name' => 'Project Manage Activities',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Actividades de Proyecto',
                ),
            63 =>
                array(
                    'name' => 'project-view-formulatedDocument',
                    'display_name' => 'Project View Formulateddocument',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Documento Formulado',
                ),
            64 =>
                array(
                    'name' => 'project-manage-governance',
                    'display_name' => 'Project Manage Governance',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Gobernancia de Proyecto',
                ),
            65 =>
                array(
                    'name' => 'project-manage-logicFrame',
                    'display_name' => 'Project Manage Logicframe',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Marco Lógico',
                ),
            66 =>
                array(
                    'name' => 'process-view-conformities',
                    'display_name' => 'Process View Conformities',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver No Conformidades',
                ),
            67 =>
                array(
                    'name' => 'project-manage-communication',
                    'display_name' => 'Project Manage Communication',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Comunicaciones de Proyecto',
                ),
            68 =>
                array(
                    'name' => 'process-view-risks-process',
                    'display_name' => 'Process View Risks Process',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Riesgos de Proceso',
                ),
            69 =>
                array(
                    'name' => 'poa-approve-piat-matrix',
                    'display_name' => 'Poa Approve Piat Matrix',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Aprobar Matriz PIAT',
                ),
            70 =>
                array(
                    'name' => 'strategy-read-strategy',
                    'display_name' => 'Strategy Read Strategy',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Módulo Estrategia',
                ),
            71 =>
                array(
                    'name' => 'budget-read-budget',
                    'display_name' => 'Budget Read Budget',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Módulo Presupuesto',
                ),
            72 =>
                array(
                    'name' => 'project-change-status',
                    'display_name' => 'Project Change Status',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Cambiar Estado de Proyecto',
                ),
            73 =>
                array(
                    'name' => 'poa-review-poas',
                    'display_name' => 'Poa Review Poas',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Revisar POA',
                ),
            74 =>
                array(
                    'name' => 'project-read',
                    'display_name' => 'Project Read Project',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Módulo Proyecto',
                ),
            75 =>
                array(
                    'name' => 'poa-read-poa',
                    'display_name' => 'Poa Read Poa',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver POA',
                ),
            76 =>
                array(
                    'name' => 'admin-crud-admin',
                    'display_name' => 'Admin Crud Admin',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Módulo Admin',
                ),
            77 =>
                array(
                    'name' => 'poa-crud-poa',
                    'display_name' => 'Poa Crud Poa',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar POA',
                ),
            78 =>
                array(
                    'name' => 'project-view-indexCard',
                    'display_name' => 'Project View Indexcard',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Ver Ficha de Proyecto',
                ),
            79 =>
                array(
                    'name' => 'strategy-plan-crud-strategy',
                    'display_name' => 'Strategy Plan Crud Strategy',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Plan de Estrategia',
                ),
            80 =>
                array(
                    'name' => 'strategy-template-crud-strategy',
                    'display_name' => 'Strategy Template Crud Strategy',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Plantilla de Estrategia',
                ),
            81 =>
                array(
                    'name' => 'budget-crud-budget',
                    'display_name' => 'Budget Crud Budget',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Módulo Presupuesto',
                ),
            82 =>
                array(
                    'name' => 'project-manage-indexCard',
                    'display_name' => 'Project Manage Indexcard',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Ficha del Proyecto',
                ),
            83 =>
                array(
                    'name' => 'project-crud',
                    'display_name' => 'Project Crud Project',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'spanish_label' => 'Administrar Módulo Proyecto',
                ),
            84 =>
                array(
                    'name' => 'poa-view-all-poas',
                    'display_name' => 'Poa View All Poas',
                    'spanish_label' => 'Ver Todos los Poas',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),

        ));
    }
}