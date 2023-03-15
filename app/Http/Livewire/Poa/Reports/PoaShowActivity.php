<?php

namespace App\Http\Livewire\Poa\Reports;

use App\Models\Indicators\Indicator\Indicator;
use App\Models\Poa\PoaActivity;
use Livewire\Component;
use function view;

class PoaShowActivity extends Component
{
    public $poaActivity;
    public array $data = [];
    public array $dataScore = [];

    protected $listeners = ['open' => 'mount'];

    public function mount($id = null)
    {
        if ($id) {
            $this->poaActivity = PoaActivity::with(
                [
                    'measureAdvances',
                    'indicatorUnit',
                    'responsible',
                    'location',
                    'measure',
                    'program.poa',
                ])
                ->withoutGlobalScope(\App\Scopes\Company::class)->find($id);
            $this->data = [];
            $measureAdvances = $this->poaActivity->measureAdvances;
            $i = 1;
            foreach ($measureAdvances as $advance) {
                $goal = $advance->goal;
                $actual = $advance->actual;
                $progress = 0;
                if ($goal > 0) {
                    $progress = number_format($actual / $goal * 100, 2);
                }
                $this->data[] = [
                    'frequency' => Indicator::FREQUENCIES[12][$i],
                    'value' => (float)$goal ?? 0,
                    'actual' => (float)$actual ?? 0,
                    'year' => date("Y"),
                    'progress' => (float)($progress)
                ];
                $i++;
            }
            $this->dataScore = [
                'score' => floatval($this->poaActivity->totalProgress()),
                'max' => $this->poaActivity->program->poa->max,
                'min' => $this->poaActivity->program->poa->min,
            ];
            $this->dispatchBrowserEvent('updateChartDataActivity', ['data' => $this->data]);
            $this->dispatchBrowserEvent('updateChartDataActivity2', ['data' => $this->dataScore]);
            $this->emit('toggleShowModal');
        }
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(
            [
                'poaActivity',
                'data',
                'dataScore',
            ]);

    }

    public function render()
    {
        return view('livewire.poa.reports.poa-show-activity');
    }
}
