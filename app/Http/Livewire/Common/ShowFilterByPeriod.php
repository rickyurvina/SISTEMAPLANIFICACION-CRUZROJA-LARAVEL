<?php

namespace App\Http\Livewire\Common;

use App\Models\Admin\Company;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;
use Lavary\Menu\Collection;
use Livewire\Component;

class ShowFilterByPeriod extends Component
{
    public $nameProvince = null, $idProgram = null;
    public Collection $companies;
    public array $data = [];
    protected $listeners = [
        'openModal' => 'openModal',
        'openModalPeopleReached' => 'openModalPeopleReached',
        'openModalPeopleCapacitado' => 'openModalPeopleCapacitado',
        'openModalService' => 'openModalService',
        'openModalDoc' => 'openModalDoc'
    ];

    public function openModal($payload)//TODO verificar el funcionamiento de esto
    {
        $this->nameProvince = $payload['name'];
        $companies = new Company;
        $companies = $companies->getCantones($this->nameProvince)->pluck('id', 'id');
        $poaActivityIndicator = new MeasureAdvances;
        $poaActivityIndicator = $poaActivityIndicator->withoutGlobalScope(\App\Scopes\Company::class)->whereIn('company_id', $companies)->get();
        $this->addData($poaActivityIndicator);
        $this->dispatchBrowserEvent('showChart', ['data' => $this->data]);
        $this->emit('toggleShowModal');
    }

    public function openModalPeopleReached($payload)
    {
        $indicatorUnit= new IndicatorUnits;
        $unitMeasure=$indicatorUnit->getUnits()[0];
        $this->executeModal($unitMeasure->id, $payload);
    }

    public function openModalPeopleCapacitado($payload)
    {
        $indicatorUnit= new IndicatorUnits;
        $unitMeasure=$indicatorUnit->getUnits()[1];
        $this->executeModal($unitMeasure->id, $payload);
    }

    public function openModalService($payload)
    {
        $indicatorUnit= new IndicatorUnits;
        $unitMeasure=$indicatorUnit->getUnits()[2];
        $this->executeModal($unitMeasure->id, $payload);
    }
    public function openModalDoc($payload)
    {
        $indicatorUnit= new IndicatorUnits;
        $unitMeasure=$indicatorUnit->getUnits()[3];
        $this->executeModal($unitMeasure->id, $payload);
    }


    public function executeModal($id, $payload){
        $this->idProgram = $payload['name'];
        $poaActivities = PoaActivity::withoutGlobalScope(\App\Scopes\Company::class)->where('plan_detail_id', $this->idProgram)
            ->where('indicator_unit_id',$id)->get()->pluck('id', 'id');
        $poaActivityIndicator= MeasureAdvances::where('measurable_type', PoaActivity::class)
            ->whereIn('measurable_id', $poaActivities)->get();
        $this->addData($poaActivityIndicator);
        $this->dispatchBrowserEvent('showChart', ['data' => $this->data]);
        $this->emit('toggleShowModal');
    }

    public function addData($poaActivityIndicator){
        $months = ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];
        $goal = 0;
        $progress = 0;
        $progressTotal = 0;
        $this->data = [];
        for ($i = 0; $i < 12; $i++) {
            $goal = $poaActivityIndicator->where('period', $i + 1)->sum('goal');
            $progress = $poaActivityIndicator->where('period', $i + 1)->sum('actual');
            if ($goal > 0) {
                $progressTotal = number_format($progress / $goal * 100, 1);
            } else {
                $progressTotal = 0;
            }
            $this->data[] = [
                'frequency' => $months[$i],
                'value' => $goal> 0 ? $goal : null,
                'actual' => $progress > 0 ? $progress : null,
                'year' => date("Y"),
                'progress' => $progressTotal,
            ];
        }
    }

    public function render()
    {
        return view('livewire.common.show-filter-by-period');
    }
}
