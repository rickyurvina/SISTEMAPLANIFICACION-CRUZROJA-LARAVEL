<?php
return [
    'catalog' => [
        'PLAN_TYPES' => ['ODS', 'Plan Nacional de Desarrollo', 'Estrategia de Federación', 'Estrategia CRE', 'Plan Táctico'],
        'PERSPECTIVES' => ['Procesos', 'Cliente', 'Aprendizaje y crecimiento', 'Financiera'],
        'GENDERS' => ['Masculino', 'Femenino', 'Otro'],
        'LEVELS' => [2, 3],
        'SOCIAL_NETWORKS' => ['Facebook', 'Instagram', 'Linkedin', 'Youtube', 'Twitter'],
        'CATEGORIZATIONS' => ['Categoría Uno', 'Categoría Dos', 'Categoria Tres'],
        'PRODUCTS' => ['Catalogo Producto Uno', 'Catalogo Producto Dos', 'Catalogo Producto Tres', 'Catalogo Producto Cuatro', 'Catalogo Producto Cinco'],
        'PROJECT_TYPES' => [
            'project_missionary' => [
                'title' => 'Misional de Desarrollo',
                'description' => 'Misional de Desarrollo',
                'components' => [
                    ['key' => 'stakeholders', 'title' => 'Matriz de Interesados'],
                    ['key' => 'logic_frame', 'title' => 'Marco Lógico'],
                    ['key' => 'budget', 'title' => 'Presupuesto'],
                    ['key' => 'simple_schedule', 'title' => 'Cronograma Simple'],
                    ['key' => 'extended_schedule', 'title' => 'Cronograma Ampliado'],
                    ['key' => 'risk', 'title' => 'Riesgos'],
                    ['key' => 'purchases', 'title' => 'Matriz de Adquisición'],
                    ['key' => 'communication', 'title' => 'Matriz de Comunicación'],
                ]
            ],
            'internal_development' => [
                'title' => 'Fortalecimiento Interno',
                'description' => 'Fortalecimiento Interno',
                'components' => [
                    ['key' => 'team', 'title' => 'Equipo de Proyecto'],
                    ['key' => 'simple_schedule', 'title' => 'Cronograma Simple'],
                ]
            ],
            'investment' => [
                'title' => 'Inversión',
                'description' => 'Inversión',
                'components' => [
                    ['key' => 'team', 'title' => 'Equipo de Proyecto'],
                    ['key' => 'stakeholders', 'title' => 'Matriz de Interesados'],
                    ['key' => 'bcm', 'title' => 'Business Canvas Model'],
                    ['key' => 'budget', 'title' => 'Presupuesto'],
                    ['key' => 'budget_schedule', 'title' => 'Cronograma Presupuestario'],
                    ['key' => 'extended_schedule', 'title' => 'Cronograma Ampliado'],
                    ['key' => 'risk', 'title' => 'Riesgos'],
                    ['key' => 'purchases', 'title' => 'Matriz de Adquisición'],
                    ['key' => 'communication', 'title' => 'Matriz de Comunicación'],
                ]
            ],
            'emergency' => [
                'title' => 'Misional de Emergencia',
                'description' => 'Misional de Emergencia',
                'components' => [
                    ['key' => 'team', 'title' => 'Equipo de Proyecto'],
                    ['key' => 'stakeholders', 'title' => 'Matriz de Interesados'],
                    ['key' => 'logic_frame', 'title' => 'Marco Lógico'],
                    ['key' => 'budget', 'title' => 'Presupuesto'],
                    ['key' => 'budget_schedule', 'title' => 'Cronograma Presupuestario'],
                    ['key' => 'simple_schedule', 'title' => 'Cronograma Simple'],
                    ['key' => 'risk', 'title' => 'Riesgos'],
                    ['key' => 'purchases', 'title' => 'Matriz de Adquisición'],
                    ['key' => 'communication', 'title' => 'Matriz de Comunicación'],
                ]
            ]
        ],
        'COLOR_PALETTE' => [
            '#00c875',
            '#ff5ac4',
            '#ff158a',
            '#bb3354',
            '#7f5347',
            '#ff642e',
            '#ffcb00',
            '#cab641',
            '#9cd326',
            '#037f4c',
            '#0086c0',
            '#579bfc',
            '#66ccff',
            '#784bd1',
            '#ff7575',
            '#faa1f1',
            '#ffadad',
            '#7e3b8a',
            '#225091',
            '#4eccc6',
            '#401694',
            '#563e3e',
            '#bda8f9',
            '#2b76e5',
            '#a9bee8',
            '#d974b0'
        ],
        'TASK_INDICATOR' => ['No Cumplido', 'Cumplido'],
        'CARD_REPORTS' => [
            ['titulo' => 'Reporte General por Objetivos', 'descripcion' => 'Reporte General por Objetivos', 'ruta' => 'poa.reports.report_objectives'],
            ['titulo' => 'Reporte de Metas', 'descripcion' => 'Reporte General de Metas de Actividades', 'ruta' => 'poa.reports.goals'],
            ['titulo' => 'Reporte de Estado de Actividades', 'descripcion' => 'Reporte General de Estado de Actividades de POA', 'ruta' => 'poa.reports.activity_status'],
            ['titulo' => 'Reporte General de Actividades', 'descripcion' => 'Reporte General de Actividades de POA', 'ruta' => 'poa.reports.showActivitiesReport'],
            ['titulo' => 'Evaluación', 'descripcion' => 'Evaluación General CRE', 'ruta' => 'poa.reports.showEvaluationReport'],
        ],
        'PROJECT_CARD_REPORTS' => [
            ['titulo' => 'INFORME EJECUTIVO DE PROYECTO', 'descripcion' => 'Reporte ejecutivo del Proyecto', 'ruta' => 'projects.executiveReport'],
            ['titulo' => 'INFORME DE INDICADORES DEL PROYECTO', 'descripcion' => 'Reporte de Indicadores del Proyecto', 'ruta' => 'projects.indicatorsReport'],
            ['titulo' => 'INFORME DE EJECUCIÓN Y PRESUPUESTO DE ACTIVIDADES DEL PROYECTO', 'descripcion' => 'Reporte de Ejecución y Presupuesto de Actividades del Proyecto ', 'ruta' => 'projects.activities-exc-bud-Report'],
            ['titulo' => 'NECESIDAD PRESUPUESTARIA', 'descripcion' => 'Ref: plan de acción covid', 'ruta' => 'projects.budgetNeedReport'],
//            ['titulo' => 'PRESUPUESTO', 'descripcion' => 'Ref: plan de acción covid', 'ruta' => 'projects.budgetReport'],
            ['titulo' => 'INFORME DE INGRESOS Y EGRESOS', 'descripcion' => 'ReF: Informa plan covid Corte marzo', 'ruta' => 'projects.fundsOriginReport'],
            ['titulo' => 'INFORME DE ACTIVIDADES', 'descripcion' => 'Ref:PRY 539Echo MH Seguimiento, pestaña actividades', 'ruta' => 'projects.activitiesReport'],
            ['titulo' => 'INFORME DE PRESUPUESTO POR SECTOR ', 'descripcion' => 'Ref:infografia covid', 'ruta' => 'projects.reportReport'],
        ],
        'PROJECT_REPORTS' => [
            ['titulo' => 'INFORME SEGUIMIENTO DE CARTERA', 'descripcion' => 'Reporte Gerencial. Ref:Seguimiento Cartera de Proyectos 2019 y 2020', 'ruta' => 'projects.portfolioReport'],
        ],
        'PROJECT_INTERNAL_CARD_REPORTS' => [
            ['titulo' => 'INFORME EJECUTIVO DE PROYECTO', 'descripcion' => 'Reporte ejecutivo del Proyecto', 'ruta' => 'projects.executiveReportInternal'],
            ['titulo' => 'INFORME DE INDICADORES DEL PROYECTO', 'descripcion' => 'Reporte de Indicadores del Proyecto', 'ruta' => 'projects.indicatorsReportInternal'],
            ['titulo' => 'INFORME DE EJECUCIÓN Y PRESUPUESTO DE ACTIVIDADES DEL PROYECTO', 'descripcion' => 'Reporte de Ejecución y Presupuesto de Actividades del Proyecto ', 'ruta' => 'projects.activities-exc-bud-ReportInternal'],
//            ['titulo' => 'INFORME SEGUIMIENTO DE CARTERA', 'descripcion' => 'Reporte Gerencial. Ref:Seguimiento Cartera de Proyectos 2019 y 2020', 'ruta' => 'projects.portfolioReportInternal'],
            ['titulo' => 'NECESIDAD PRESUPUESTARIA', 'descripcion' => 'Ref: plan de acción covid', 'ruta' => 'projects.budgetNeedReportInternal'],
//            ['titulo' => 'PRESUPUESTO', 'descripcion' => 'Ref: plan de acción covid', 'ruta' => 'projects.budgetReportInternal'],
            ['titulo' => 'INFORME DE INGRESOS Y EGRESOS', 'descripcion' => 'ReF: Informa plan covid Corte marzo', 'ruta' => 'projects.fundsOriginReportInternal'],
            ['titulo' => 'INFORME DE ACTIVIDADES', 'descripcion' => 'Ref:PRY 539Echo MH Seguimiento, pestaña actividades', 'ruta' => 'projects.activitiesReportInternal'],
            ['titulo' => 'INFORME DE PRESUPUESTO POR SECTOR ', 'descripcion' => 'Ref:infografia covid', 'ruta' => 'projects.reportReportInternal'],
        ],
        'BUDGET_CARD_REPORTS' => [
            ['titulo' => 'Cédula Presupuestaria', 'descripcion' => '', 'ruta' => 'budget.budgetDocumentReport'],
        ],
        'MEASURE_CARD_UPDATES'=>[
            ['titulo' => 'Actualizar Indicadores Por Periodo', 'descripcion' => 'Actualizar Indicadores Por Periodo', 'ruta' => 'index.measure.strategy-period'],
            ['titulo' => 'Actualizar Indicadores Por Frecuencia', 'descripcion' => 'Actualizar Indicadores Por Frecuencia', 'ruta' => 'index.measure.strategy-frequency'],
        ]
    ]
];