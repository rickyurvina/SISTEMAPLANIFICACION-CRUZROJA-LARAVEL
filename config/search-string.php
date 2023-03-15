<?php

use App\Models\Admin\Address;
use App\Models\Admin\Department;
use App\Models\Admin\SocialNetwork;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Models\Budget\Catalogs\BudgetClassifier;
use App\Models\Budget\Catalogs\FinancingSourceClassifier;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Common\CatalogGeographicClassifier;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Indicators\Sources\IndicatorSource;
use App\Models\Indicators\Threshold\Threshold;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Projects\Stakeholders\ProjectCommunicationMatrix;
use App\Models\Projects\Stakeholders\ProjectStakeholder;
use App\Models\Strategy\Plan;
use App\Models\Process\Process;

return [

    /*
    |--------------------------------------------------------------------------
    | Invalid search string handling
    |--------------------------------------------------------------------------
    |
    | - all-results: (Default) Silently fail with a query containing everything.
    | - no-results: Silently fail with a query containing nothing.
    | - exceptions: Throw an `InvalidSearchStringException`.
    |
    */

    'fail' => 'all-results',

    /*
    |--------------------------------------------------------------------------
    | Default options
    |--------------------------------------------------------------------------
    |
    | When options are missing from your models, this array will be used
    | to fill the gaps. You can also define a set of options specific
    | to a model, using its class name as a key, e.g. 'App\User'.
    |
    */

    'default' => [
        'keywords' => [
            'order_by' => 'sort',
            'select' => 'fields',
            'limit' => 'limit',
            'offset' => 'from',
        ],
        'columns' => [
            'created_at' => 'date',
        ],
    ],

    Role::class => [
        'columns' => [
            'name' => ['searchable' => true]
        ],
    ],

    User::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'email' => ['searchable' => true],
            'enabled' => ['boolean' => true],
            'last_logged_in_at' => ['date' => true],
        ],
    ],

    Address::class => [
        'columns' => [
            'country' => ['searchable' => true],
            'province' => ['searchable' => true],
            'city' => ['searchable' => true],
            'street_one' => ['searchable' => true],
            'street_two' => ['searchable' => true],
            'street_three' => ['searchable' => true],
            'enabled' => ['boolean' => true],
        ]
    ],


    Department::class => [
        'columns' => [
            'code' => ['searchable' => true],
            'name' => ['searchable' => true],
            'description' => ['searchable' => true],
            'responsible' => ['searchable' => true],
            'enabled' => ['boolean' => true],
        ]
    ],

    SocialNetwork::class => [
        'columns' => [
            'type' => ['searchable' => true],
            'enabled' => ['boolean' => true],
        ]
    ],

    Indicator::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'code' => ['searchable' => true],
            'frequency' => ['searchable' => true],
            'total_goal_value' => ['searchable' => true],
            'total_actual_value' => ['searchable' => true],
            'user_id' => ['searchable' => true],
            'status' => ['searchable' => true],
            'period_advance' => ['searchable' => true],
            'start_date' => ['key' => 'start', 'date' => true],
            'end_date' => ['key' => 'start', 'date' => true],
            'updated_at' => ['key' => 'start', 'date' => true],
        ]
    ],

    IndicatorSource::class => [
        'columns' => [
            'institution' => ['searchable' => true],
            'name' => ['searchable' => true],
            'description' => ['searchable' => true],
            'type' => ['searchable' => true],
        ]
    ],

    Threshold::class => [
        'columns' => [
            'name' => ['searchable' => true],
        ]
    ],

    IndicatorUnits::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'abbreviation' => ['searchable' => true],
        ]
    ],

    Plan::class => [
        'columns' => [
            'code' => ['searchable' => true],
            'name' => ['searchable' => true],
            'description' => ['searchable' => true],
            'vision' => ['searchable' => true],
            'mission' => ['searchable' => true],
        ]
    ],

    \App\Models\Strategy\PlanDetail::class => [
        'columns' => [
            'code' => ['searchable' => true],
            'name' => ['searchable' => true],
        ]
    ],


    Process::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'owner_id' => ['searchable' => true],
            'indicators'=> ['searchable' => true],
        ]
    ],

    BudgetClassifier::class => [
        'columns' => [
            'parent_id' => ['searchable' => true],
            'code' => ['searchable' => true],
            'full_code' => ['searchable' => true],
            'tittle' => ['searchable' => true],
        ]
    ],
    FinancingSourceClassifier::class => [
        'columns' => [
            'code' => ['searchable' => true],
            'description' => ['searchable' => true],
        ]
    ],
    CatalogGeographicClassifier::class => [
        'columns' => [
            'code' => ['searchable' => true],
            'description' => ['searchable' => true],
            'type' => ['searchable' => true],
        ]
    ],
    BudgetStructure::class => [
        'columns' => [
            'year' => ['searchable' => true],
            'type' => ['searchable' => true],
            'name' => ['searchable' => true],
            'length' => ['searchable' => true],
            'group' => ['searchable' => true],
            'level' => ['searchable' => true],
        ]
    ],
    ProjectStakeholder::class => [
        'columns' => [
            'priority' => ['searchable' => true],
            'strategy' => ['searchable' => true],
        ]
    ],
    ProjectCommunicationMatrix::class => [
        'columns' => [
            'start_date' => ['searchable' => true],
            'end_date' => ['searchable' => true],
            'frequency' => ['searchable' => true],
            'state' => ['searchable' => true],
            'color' => ['searchable' => true],
            'information_type' => ['searchable' => true],
            'format_information_presentation' => ['searchable' => true],
            'user_id' => ['searchable' => true],
            'prj_project_stakeholder_id' => ['searchable' => true],
        ]
    ],

    \App\Models\Projects\Catalogs\ProjectLineAction::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'code' => ['searchable' => true],
            'description' => ['searchable' => true],
            'plan¿detail_id' => ['searchable' => true]
        ]
    ],

    \App\Models\Projects\Catalogs\ProjectLineActionService::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'code' => ['searchable' => true],
            'description' => ['searchable' => true],
            'prj_project_catalog_line_actions_id' => ['searchable' => true]
        ]
    ],

    \App\Models\Projects\Catalogs\ProjectLineActionServiceActivity::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'code' => ['searchable' => true],
            'description' => ['searchable' => true],
            'service_id' => ['searchable' => true]
        ]
    ],

    \App\Models\Risk\Risk::class => [
        'columns' => [
            'name' => ['searchable' => true],
            'description' => ['searchable' => true],
            'incidence_date' => ['searchable' => true],
            'identification_date' => ['searchable' => true],
            'closing_date' => ['searchable' => true],
            'created_at' => ['searchable' => true],
            'enabled' => ['searchable' => true],
            'state_id' => ['searchable' => true],
            'classification' => ['searchable' => true],
        ]
    ],
    \App\Models\Projects\ProjectLearnedLessons::class =>
        [
            'background' => ['searchable' => true],
            'causes' => ['searchable' => true],
            'learned_lesson' => ['searchable' => true],
            'corrective_lesson' => ['searchable' => true],
            'evidences' => ['searchable' => true],
            'recommendations' => ['searchable' => true],
            'user_id' => ['searchable' => true],
            'phase' => ['searchable' => true],
            'state' => ['searchable' => true],
            'type' => ['searchable' => true],
            'knowledge' => ['searchable' => true],
            'prj_project_id' => ['searchable' => true],
        ]
//    BudgetItemIncome::class => [
//        'columns' => [
//            'year' => ['searchable' => true],
//            'code' => ['searchable' => true],
//            'budget_classifiers_id' => ['searchable' => true],
//            'budget_financing_source_classifiers_id' => ['searchable' => true],
//            'details' => ['searchable' => true],
//            'name' => ['searchable' => true],
//            'value' => ['searchable' => true],
//        ]
//    ],
];
