<?php

namespace App\Http\Livewire\Risks;

use App\Abstracts\TableComponent;
use App\Models\Common\Catalog;
use App\Models\Projects\Catalogs\ProjectRiskClassification;
use App\Models\Risk\Risk;
use App\Traits\Jobs;
use Illuminate\Support\Facades\App;
use function view;

class IndexRisks extends TableComponent
{
    use Jobs;

    public string $search = '';

    public $messages;
    public $model;
    public $modelId;
    public $class;
    public $scale_of_impacts = [];
    public $dataIndex = [];
    public $scalesY = [];
    public $scalesX = [];

    protected $listeners =
        [
            'riskCreated' => 'render',
            'riskUpdated' => 'render',
            'updateChartDataRiskIndexFunction',
        ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => '']
    ];

    public function updateChartDataRiskIndexFunction()
    {
        $risks = Risk::where('riskable_id', $this->modelId)->where('riskable_type', $this->class)->get();
        $this->scale_of_impacts = Catalog::catalogName('risk_impact_probability_catalog')->first()->details;
        $dataY = [];
        $dataX = [];
        foreach ($this->scale_of_impacts[0]->properties as $item) {
            $dataY[] = $item['y'];
            $dataX[] = $item['x'];
            $countRisk = $risks->where('probability', $item['probability'])->where('impact', $item['impact'])->count();
            $this->dataIndex[] = array_merge($item, [
                'radius' => $countRisk > 0 ? $countRisk : '',
                'x' => $item['probability'],
                'y' => $item['impact'],
            ]);
        }
        $dataY = array_unique($dataY);
        $dataX = array_unique($dataX);
        $this->scalesY = array_reverse($dataY);
        $this->scalesX = array_reverse($dataX);
        $this->scalesX = array_reverse($this->scalesX);

    }

    public function mount($modelId, $class)
    {
        $this->modelId = $modelId;
        $this->class = $class;
        $this->model = App::make($this->class)::withoutGlobalScope(\App\Scopes\Company::class)->find($this->modelId);
        $this->messages = Catalog::CatalogName('help_messages')->first()->details;
    }

    public function render()
    {
        $search = $this->search;
        $risks = Risk::where('riskable_id', $this->modelId)->where('riskable_type', $this->class)
            ->when($this->sortField, function ($q) {
                $q->orderBy($this->sortField, $this->sortDirection);
            })->when($search, function ($q, $search) {
                $q->where('name', 'iLIKE', '%' . $search . '%');
            })->paginate(setting('default.list_limit', '25'));
        self::updateChartDataRiskIndexFunction();
        $this->dispatchBrowserEvent('updateChartDataRiskIndex', ['dataIndex' => $this->dataIndex]);

        return view('livewire.risks.index-risks', ['risks' => $risks]);
    }
}
