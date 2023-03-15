<?php

namespace App\Http\Livewire\Risks;

use App\Http\Livewire\Components\Modal;
use App\Jobs\Risk\UpdateRisk;
use App\Models\Common\Catalog;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Catalogs\ProjectRiskClassification;
use App\Models\Projects\Project;
use App\Models\Risk\Risk;
use App\Traits\Jobs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class UpdatedRisk extends Modal
{
    use Jobs;

    public int $riskId = 0;
    public string $name = '';
    public string $description = '';
    public $identification_date;
    public $incidence_date;
    public $closing_date;
    public $state;
    public string $cost = '';
    public string $cause = '';
    public string $classification = '';
    public int $probability = 0;
    public int $impact = 0;
    public int $urgency = 0;
    public Collection $classifications;
    public $scale_of_impacts = [];
    public $scalesY = [];
    public $scalesX = [];
    public $states;
    public $risk;
    public $results;
    public $task_id;
    public $model;
    public $modelId;
    public $class;

    protected $listeners = ['loadUpdateForm', 'updateUrgency'];

    protected array $rules = [
        'name' => 'required',
        'description' => 'required',
        'classification' => 'required',
        'cost' => 'numeric',
    ];

    public function mount($modelId, $class, $messages = null)
    {
        $this->modelId = $modelId;
        $this->class = $class;
        $this->model = App::make($this->class)::withoutGlobalScope(\App\Scopes\Company::class)->find($this->modelId);
        $this->classifications = ProjectRiskClassification::get();
    }

    public function loadUpdateForm($riskId)
    {
        $this->risk = Risk::with([
            'actions'
        ])->findOrFail($riskId);

        $this->riskId = $riskId;
        $this->name = $this->risk->name;
        $this->description = $this->risk->description;
        $this->identification_date = $this->risk->identification_date;
        $this->incidence_date = $this->risk->incidence_date;
        $this->closing_date = $this->risk->closing_date;
        $this->state = $this->risk->state;
        $this->cost = $this->risk->cost;
        $this->cause = $this->risk->cause;
        $this->classification = $this->risk->classification;
        $this->impact = $this->risk->impact == null ? 0 : $this->risk->impact;
        $this->probability = $this->risk->probability == null ? 0 : $this->risk->probability;
        $this->urgency = $this->impact * $this->probability;
        $this->task_id = $this->risk->task_id;
        $this->scale_of_impacts = Catalog::catalogName('risk_impact_probability_catalog')->first()->details;

        $data = [];
        $dataY = [];
        $dataX = [];
        foreach ($this->scale_of_impacts[0]->properties as $item) {
            $dataY[] = $item['y'];
            $dataX[] = $item['x'];
            if ($this->impact == $item['impact'] && $this->probability == $item['probability'])
                $data[] = array_merge($item,
                    [
                        'radius' => 10,
                        'x' => $item['probability'],
                        'y' => $item['impact'],
                    ]);
            else
                $data[] = array_merge($item,
                    [
                        'radius' => 0,
                        'x' => $item['probability'],
                        'y' => $item['impact'],
                    ]);

        }
        $dataY = array_unique($dataY);
        $dataX = array_unique($dataX);
        $this->scalesY = array_reverse($dataY);
        $this->scalesX = array_reverse($dataX);
        $this->scalesX = array_reverse($this->scalesX);
        $this->dispatchBrowserEvent('updateChartDataRisk', ['data' => $data]);
    }

    public function render()
    {
        if ($this->risk && $this->class == Project::class) {
            $this->results = Task::when($this->model->objectives->count() > 0, function (Builder $query) {
                return $query->whereIn('objective_id', $this->model->objectives->pluck('id'));
            })->get();
        }
        return view('livewire.risks.updated-risk');
    }

    public function submit()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'identification_date' => $this->identification_date,
            'incidence_date' => $this->incidence_date,
            'closing_date' => $this->closing_date,
            'state' => $this->state,
            'cost' => $this->cost,
            'cause' => $this->cause,
            'classification' => $this->classification,
            'task_id' => $this->task_id,
        ];
        $response = $this->ajaxDispatch(new UpdateRisk($data, $this->riskId));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.risks', 1)]))->success()->livewire($this);
            $this->loadUpdateForm($this->riskId);
            $this->emit('riskUpdated');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function updateUrgency($data)
    {
        foreach ($data as $row) {
            $this->impact = $row["impact"];
            $this->probability = $row["probability"];
            $this->urgency = $row["value"];
        }
        $this->risk->impact = $this->impact;
        $this->risk->probability = $this->probability;
        $this->risk->urgency = $this->urgency;
        $this->risk->save();
        $this->loadUpdateForm($this->risk->id);
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.risks', 1)]))->success()->livewire($this);
    }

    public function closeModal()
    {
        if ($this->class == Project::class) {
            return redirect()->to(url()->previous());
        }
    }
}
