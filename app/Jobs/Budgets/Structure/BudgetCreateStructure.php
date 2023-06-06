<?php

namespace App\Jobs\Budgets\Structure;

use App\Abstracts\Job;
use App\Models\Budget\Catalogs\BudgetClassifier;
use App\Models\Budget\Catalogs\FinancingSourceClassifier;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Projects\Activities\Task;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanRegisteredTemplateDetails;
use Illuminate\Support\Facades\DB;


class BudgetCreateStructure extends Job
{


    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        //
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try {
            DB::beginTransaction();
            $budgetClassifier = new BudgetClassifier();
            $financingSource = new FinancingSourceClassifier();

            $plan = Plan::active()->type(Plan::TYPE_STRATEGY)->first();

            $budgetItemClassifier = [
                'name' => $budgetClassifier->getTable(),
                'label' => 'Item presupuestario',
                'value' => '',
                'id' => '',
                'format' => '#.##.##.##',
                'level' => 1
            ];
            $financingSourceClassifier = [
                'name' => $financingSource->getTable(),
                'label' => 'Fuente financiamiento',
                'value' => '',
                'id' => '',
                'format' => '###',
                'level' => 2
            ];
            $settingsIncomes =
                ['fields' =>
                    [
                        [
                            'name' => $budgetItemClassifier['name'],
                            'label' => $budgetItemClassifier['label'],
                            'value' => $budgetItemClassifier['value'],
                            'id' => '',
                            'format' => $budgetItemClassifier['format'],
                            'level' => $budgetItemClassifier['level'],
                            'meta' =>
                                [
                                    'content' => '',
                                    'readonly' => '',
                                    'type' => 'select',
                                    'source' => [
                                        'type' => 'model',
                                        'class' => BudgetClassifier::class,
                                        'field' => 'full_code',
                                        'field_display' => 'title',
                                        'conditions' =>
                                            [
                                                [
                                                    'field' => 'level',
                                                    'op' => '=',
                                                    'value' => '4'
                                                ]
                                            ]
                                    ],
                                ],
                        ],
                        [
                            'name' => $financingSourceClassifier['name'],
                            'label' => $financingSourceClassifier['label'],
                            'value' => $financingSourceClassifier['value'],
                            'id' => '',
                            'format' => $financingSourceClassifier['format'],
                            'level' => $financingSourceClassifier['level'],
                            'meta' =>
                                [
                                    'content' => '',
                                    'readonly' => '',
                                    'type' => 'select',
                                    'source' => [
                                        'type' => 'model',
                                        'class' => FinancingSourceClassifier::class,
                                        'field' => 'code',
                                        'field_display' => 'description',
                                        'conditions' => []
                                    ],
                                ],
                        ],
                    ]
                ];
            $tree = PlanRegisteredTemplateDetails::where('plan_id', $plan->id)->get();
            $settingsExpenses['fields'] =[];
            $count=1;
            foreach ($tree as $element) {
                $element = [
                    'name' => 'plan_details',
                    'label' => $element->name,
                    'value' => '',
                    'id' => $element['id'],
                    'format' => '',
                    'level' => $count,
                ];
                array_push( $settingsExpenses['fields'] , $element);
                $count++;
            }
            $elements=[
                [
                    'name' => 'indicators',
                    'label' => 'Indicadores',
                    'value' => '',
                    'id' => '',
                    'format' => '',
                    'level' => $count++,
                ],
                [
                    'name' => 'prj_projects',
                    'label' => 'Proyectos',
                    'value' => '',
                    'id' => '',
                    'format' => '',
                    'level' => $count++,

                ],
                [
                    'name' => 'catalog_geographic_classifiers',
                    'label' => 'Juntas Provinciales',
                    'value' => '',
                    'id' => '',
                    'format' => '',
                    'level' => $count++,

                ],
                [
                    'name' => 'prj_tasks',
                    'label' => 'Resultados Proyecto',
                    'value' => '',
                    'id' => '',
                    'format' => '',
                    'level' => $count++,

                    'source' => [
                        'type' => 'model',
                        'class' => Task::class,
                        'field' => 'code',
                        'field_display' => 'text',
                        'relation' => [
                            'parentOfTask'
                        ]
                    ]
                ],
                [
                    'name' => 'prj_tasks',
                    'label' => 'Actividad',
                    'value' => '',
                    'id' => '',
                    'format' => '',
                    'level' => $count++,

                    'source' => [
                        'type' => 'model',
                        'class' => Task::class,
                        'field' => 'code',
                        'field_display' => 'text',
                    ]
                ],
                [
                    'name' => 'catalog_geographic_classifiers',
                    'label' => 'Localidad',
                    'value' => '',
                    'id' => '',
                    'format' => '',
                    'level' => $count++,

                ],
                [
                    'name' => $budgetItemClassifier['name'],
                    'label' => $budgetItemClassifier['label'],
                    'value' => '',
                    'id' => '',
                    'format' => '',
                    'level' => $count++,
                    'meta' =>
                        [
                            'content' => '',
                            'readonly' => '',
                            'type' => 'select',
                            'source' => [
                                'type' => 'model',
                                'class' => BudgetClassifier::class,
                                'field' => 'full_code',
                                'field_display' => 'title',
                                'conditions' =>
                                    [
                                        [
                                            'field' => 'level',
                                            'op' => '=',
                                            'value' => '4'
                                        ]
                                    ]
                            ],
                        ],
                ],
                [
                    'name' => $financingSourceClassifier['name'],
                    'label' => $financingSourceClassifier['label'],
                    'value' => '',
                    'id' => '',
                    'format' => '',
                    'level' => $count++,
                    'meta' =>
                        [
                            'content' => '',
                            'readonly' => '',
                            'type' => 'select',
                            'source' => [
                                'type' => 'model',
                                'class' => FinancingSourceClassifier::class,
                                'field' => 'code',
                                'field_display' => 'description',
                                'conditions' => []
                            ],
                        ],
                ],
            ];
            foreach ($elements as $element) {
                array_push( $settingsExpenses['fields'] , $element);
            }

            $dataIncomes = [
                'year' => $this->request->year,
                'type' => 1,
                'level' => 1,
                'name' => BudgetStructure::INCOMES,
                'settings' => $settingsIncomes,
                'bdg_transaction_id' => $this->request->id,
            ];
            $dataExpenses = [
                'year' => $this->request->year,
                'type' => 2,
                'level' => 1,
                'name' => BudgetStructure::EXPENSES,
                'settings' => $settingsExpenses,
                'bdg_transaction_id' => $this->request->id,
            ];
            $budgetStructure = BudgetStructure::create($dataIncomes);
            BudgetStructure::create($dataExpenses);
            DB::commit();
            return $budgetStructure;

        } catch (\Exception $exception) {
            DB::rollback();
            throw new \Exception($exception->getMessage());
        }
    }
}
