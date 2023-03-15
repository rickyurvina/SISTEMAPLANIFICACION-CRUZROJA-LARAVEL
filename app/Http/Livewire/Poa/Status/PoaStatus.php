<?php

namespace App\Http\Livewire\Poa\Status;

use App\Http\Livewire\Components\Modal;
use App\Models\Poa\Poa;
use function flash;
use function redirect;
use function user;
use function view;

class PoaStatus extends Modal
{
    public $poa;

    public $resume = [];

    public $phase = false;

    public function mount(Poa $poa)//TODO REVISAR EL HISTORIAL DE CAMBIOS EN PROD SE CAE POR EL UTF QUE SE GUARDA EN ACTIVITY LOG
    {
        $this->poa = $poa;
        $this->poa->load(['poaIndicatorConfigs.measure.poaActivities.measureAdvances', 'poaIndicatorConfigs.measure.unit', 'activities.causer']);

        $poaIndicatorConfigs = $this->poa->poaIndicatorConfigs->where('selected', true);
        foreach ($poaIndicatorConfigs as $indicatorConfig) {
            if ($indicatorConfig->measure->poaActivities->count() > 0) {
                $this->resume[] = [
                    'indicator' => $indicatorConfig->measure->name,
                    'activityCount' => $indicatorConfig->measure->poaActivities->count(),
                    'goal' => $indicatorConfig->measure->poaActivities->pluck('measureAdvances')->collapse()->sum('goal'),
                    'type' => $indicatorConfig->measure->unit->name,
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.poa.status.poa-status');
    }

    public function changeStatus()
    {
        if ($this->poa->status->to() instanceof \App\States\Poa\Reviewed) {
            if (user()->can('poa-review-poas')) {
                $this->poa->status->transitionTo($this->poa->status->to());
                flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.poa', 0)]))->success();
            } else {
                flash(trans_choice('messages.error.approve_permission_denied', 1, ['type' => trans_choice('general.poa', 0)]))->error();

            }
        } else if ($this->poa->status->to() instanceof \App\States\Poa\Approved) {
            if (user()->can('poa-approve-poas')) {
                $this->poa->status->transitionTo($this->poa->status->to());
                flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.poa', 0)]))->success();
            } else {
                flash(trans_choice('messages.error.approve_permission_denied', 1, ['type' => trans_choice('general.poa', 0)]))->error();

            }
        }

        return redirect()->route('poas.activities.index', ['poa' => $this->poa->id]);
    }

    public function changePhase()
    {
        $this->poa->phase->transitionTo($this->poa->phase->to());
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.poa', 0)]))->success();
        return redirect()->route('poas.activities.index', ['poa' => $this->poa->id]);
    }
}
