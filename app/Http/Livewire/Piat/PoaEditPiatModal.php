<?php

namespace App\Http\Livewire\Piat;

use App\Jobs\Poa\UpdatePoaActivityPiat;
use App\Jobs\Poa\UpdatePoaActivityPiatPlan;
use App\Jobs\Poa\UpdatePoaActivityPiatRequirements;
use App\Models\Auth\User;
use App\Models\Common\CatalogGeographicClassifier;
use App\Models\Poa\Piat\PoaActivityPiat;
use App\Models\Poa\Piat\PoaActivityPiatPlan;
use App\Models\Poa\Piat\PoaActivityPiatRequirements;
use App\Models\Poa\Piat\PoaPiatRequestSivol;
use App\Traits\Jobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use function flash;
use function user;

class PoaEditPiatModal extends Component
{
    use Jobs;

    //For PoaActivityPiat table
    public $activity;
    public $name;
    public $place;
    public $date;
    public $endDate;
    public $initTime;
    public $endTime;
    public $province;
    public $canton;
    public $parish;
    public $numberMaleResp = 0;
    public $numberFeMaleResp = 0;
    public $maleBenef = 0;
    public $femaleBenef = 0;
    public $maleVol = 0;
    public $femaleVol = 0;
    public $goal;
    public $createdBy;
    public $approvedBy;
    public $numberRequestVol = 0;

    public $planId;

    public $reqId;
    public $piatId;
    public $provinces;
    public $cantons = [];
    public $parishes = [];
    public $users;

    public $flag = false;

    public $piatPlan;
    public $piatReq;
    public $piat;

    public $taskPlan;
    public $datePlan;
    public $endDatePlan;
    public $responsablePlan;
    public $initTimePlan;
    public $endTimePlan;
    public $is_terminated;
    public $description;
    public $quantity;
    public $approximateCost;
    public $responsableReq;
    public $responsibles;

    public $responseRequest;
    public $poaPiatRequestSivol;
    public $showAddRequestSivol = false;

    protected $listeners = [
        'loadEditForm' => 'edit',
    ];

    protected $rules = [
        'name' => 'required',
        'date' => 'required|date|before:endDate',
        'endDate' => 'required|date|after:date',
        'initTime' => 'required',
        'endTime' => 'required|after:initTime',
        'province' => 'required',
        'canton' => 'required',
        'parish' => 'required',
    ];

    public function messages()
    {
        return [
            'endTime.after' => 'La hora final debe ser antes de la hora inicio.',
        ];
    }

    public function mount()
    {
        $this->provinces = CatalogGeographicClassifier::where('type', CatalogGeographicClassifier::TYPE_PROVINCE)->get();
        $this->cantons = CatalogGeographicClassifier::where('type', CatalogGeographicClassifier::TYPE_CANTON)->get();
        $this->parishes = CatalogGeographicClassifier::where('type', CatalogGeographicClassifier::TYPE_PARISH)->get();
        $this->users = User::where('enabled', true)->get();
    }

    public function edit($id = null)
    {
        $this->cleanThemeTask();
        $this->cleanRequirements();
        if ($id) {
            $this->piat = PoaActivityPiat::with(['poaPiatRequestsSivol','responsibles'])->find($id);
            $this->piatPlan = PoaActivityPiatPlan::where('id_poa_activity_piat', $id)->get();
            $this->piatReq = PoaActivityPiatRequirements::where('id_poa_activity_piat', $id)->get();
            $this->piatId = $this->piat->id;
            $this->name = $this->piat->name;
            $this->place = $this->piat->place;
            $this->date = $this->piat->date;
            $this->endDate = $this->piat->end_date;
            $this->initTime = $this->piat->initial_time;
            $this->endTime = $this->piat->end_time;
            $this->province = $this->piat->province;
            $this->canton = $this->piat->canton;
            $this->parish = $this->piat->parish;
            $this->numberMaleResp = $this->piat->number_male_respo;
            $this->numberFeMaleResp = $this->piat->number_female_respo;
            $this->maleBenef = $this->piat->males_beneficiaries;
            $this->femaleBenef = $this->piat->females_beneficiaries;
            $this->maleVol = $this->piat->males_volunteers;
            $this->femaleVol = $this->piat->females_volunteers;
            $this->goal = $this->piat->goals;
            $this->createdBy = $this->piat->created_by;
            $this->approvedBy = $this->piat->approved_by;
            $this->is_terminated = $this->piat->is_terminated;
            $this->poaPiatRequestSivol = $this->piat->poaPiatRequestsSivol;
            if ($this->poaPiatRequestSivol->count() > 0) {
                $this->showAddRequestSivol = false;
            } else {
                $this->showAddRequestSivol = true;
            }
            $this->responsibles=$this->piat->responsibles;

        }
    }

    public function changeStatus()
    {
        if (user()->can('approve-piat-matrix-poa')) {
            $this->piat->status->transitionTo($this->piat->status->to());
            $this->piat->update(['approved_by' => user()->id]);
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('poa.piat_matrix_tag', 0)]))->success();
        }
    }

    public function closeModal()
    {
        $this->emit('togglePiatEditModal');
        $this->emit('refreshIndex');

    }

    public function updatedProvince($value)
    {
        $this->cantons = CatalogGeographicClassifier::where('parent_id', $value)->get();
    }

    public function updatedCanton($value)
    {
        $this->parishes = CatalogGeographicClassifier::where('parent_id', $value)->get();
    }

    public function submit()
    {

        $this->validate();
        $data = [
            'name' => $this->name,
            'place' => $this->place,
            'date' => $this->date,
            'end_date' => $this->endDate,
            'initial_time' => $this->initTime,
            'end_time' => $this->endTime,
            'province' => $this->province,
            'canton' => $this->canton,
            'parish' => $this->parish,
            'goals' => $this->goal,
            'created_by' => user()->id,
            'approved_by' => -1,
        ];

        $response = $this->ajaxDispatch(new UpdatePoaActivityPiat($this->piat->id, $data));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => __('general.poa_activity_piat')]))->success()->livewire($this);
            $this->emit('updateIndexMatrix');
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function submitPlan()
    {
        $this->validate([
            'taskPlan' => 'required',
            'initTimePlan' => 'required',
            'endTimePlan' => 'required|after:initTime',
            'datePlan' => 'required|date|before:endDatePlan',
            'endDatePlan' => 'required|date|after:datePlan',
        ]);
        $data = [
            'id_poa_activity_piat' => $this->piat->id,
            'task' => $this->taskPlan,
            'responsable' => $this->responsablePlan,
            'date' => $this->datePlan,
            'end_date' => $this->endDatePlan,
            'initial_time' => $this->initTimePlan,
            'end_time' => $this->endTimePlan,
        ];

        $response = $this->ajaxDispatch(new UpdatePoaActivityPiatPlan($data));

        if ($response['success']) {
            $this->cleanThemeTask();
            $this->piatPlan = PoaActivityPiatPlan::where('id_poa_activity_piat', $this->piat->id)->get();
            flash(trans_choice('messages.success.added', 1, ['type' => __('general.poa_activity_piat_plan')]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function submitRequirements()
    {
        $this->validate([
            'description' => 'required',
            'quantity' => 'required|numeric',
            'approximateCost' => 'required|numeric',
        ]);
        $data = [
            'id_poa_activity_piat' => $this->piat->id,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'approximate_cost' => $this->approximateCost,
            'responsable' => $this->responsableReq,
        ];

        $response = $this->ajaxDispatch(new UpdatePoaActivityPiatRequirements($data));

        if ($response['success']) {
            $this->cleanRequirements();
            $this->piatReq = PoaActivityPiatRequirements::where('id_poa_activity_piat', $this->piat->id)->get();
            flash(trans_choice('messages.success.added', 1, ['type' => __('general.poa_activity_piat_requirement')]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function deleteThemeTask($id)
    {
        $papp = PoaActivityPiatPlan::find($id);
        $papp->delete();
        $this->piatPlan = PoaActivityPiatPlan::where('id_poa_activity_piat', $this->piat->id)->get();
    }

    public function deleteRequirements($id)
    {
        $re = PoaActivityPiatRequirements::find($id);
        $re->delete();
        $this->piatReq = PoaActivityPiatRequirements::where('id_poa_activity_piat', $this->piat->id)->get();
    }

    public function cleanThemeTask()
    {
        $this->planId = null;
        $this->taskPlan = null;
        $this->datePlan = null;
        $this->endDatePlan = null;
        $this->responsablePlan = null;
        $this->initTimePlan = null;
        $this->endTimePlan = null;
        $this->resetValidation();
    }

    public function cleanRequirements()
    {
        $this->reqId = null;
        $this->description = null;
        $this->quantity = null;
        $this->approximateCost = null;
        $this->responsableReq = null;
        $this->resetValidation();
    }

    public function terminate()
    {
        $this->piat->is_terminated = true;
        $this->piat->save();
        $this->is_terminated = true;
        $this->emit('refreshIndex');
    }

    public function requestVol()
    {
        $this->validate(['numberRequestVol' => 'required|numeric|min:1|integer']);
        $x = 0;
        while ($x < 10000000) {
            $x++;
        }
        $response = Http::post('http://project-backend.test/api/projects', [
            'name' => $this->activity->id,
            'code' => $this->piat->id,
            'type' => $this->numberRequestVol,
            'status' => 'Network Administrator',
            'phase' => 'Network Administrator',
        ]);

        $data =
            [
                'poa_activity_piat_id' => $this->piat->id,
                'description' => 'respuesta solicitud mensaje',
                'number_request' => $this->piat->id
            ];

        if ($response->successful()) {
            try {
                DB::beginTransaction();
                PoaPiatRequestSivol::create($data);
                $this->responseRequest = 'Solicitud generada satisfactoriamente de '.$this->numberRequestVol.' voluntarios';
                $this->reset(['numberRequestVol', 'showAddRequestSivol']);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                flash($e->getMessage())->error()->livewire($this);
            }
        } else if ($response->serverError()) {
            flash('Error en el servidor 500')->error()->livewire($this);
        } else {
            flash('Error en la solicitud...')->error()->livewire($this);
        }
    }
}
