<?php

namespace App\Http\Livewire\Piat;

use App\Jobs\Poa\CreatePoaActivityPiat;
use App\Jobs\Poa\CreatePoaActivityPiatPlan;
use App\Jobs\Poa\CreatePoaActivityPiatRequirements;
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
use function view;

class PoaCreatePiatModal extends Component
{
    use Jobs;

    //For PoaActivityPiat table
    public $class;
    public $idModel;
    public $name;
    public $place;
    public $date;
    public $endDate;
    public $initTime;
    public $endTime;
    public $province;
    public $canton;
    public $parish;
    public $poaActivity;
    public $numberMaleResp = 0;
    public $numberFeMaleResp = 0;
    public $maleBenef = 0;
    public $femaleBenef = 0;
    public $maleVol = 0;
    public $femaleVol = 0;
    public $numberRequestVol = 0;
    public $goal;
    public $createdBy;
    public $approvedBy;

    //For PoaActivityPiatPlan table
    public $task;
    public $responsable;
    public $planDate;
    public $planEndDate;
    public $planInitTime;
    public $planEndTime;

    //For PoaActivityPiatRequirements table
    public $description;
    public $quantity = 0;
    public $approxCost = 0.00;
    public $reqResponsable;

    public $provinces;
    public $cantons = [];
    public $parishes = [];
    public $users;
    public $newPoaActivityPiatId = null;
    public $newPoaActivityPiatName = null;
    public $flag = false;

    public $matrix = [];

    public $piat;


    public $piatPlan = [];
    public $piatReq = [];

    public $responseRequest;
    public $poaPiatRequestSivol;
    public $showAddRequestSivol = false;
    public $sourceUsers = true;
    public $poaPiatResponsibles;

    //select de usuarios responsables
    public $usersSelect = [];

    protected $listeners = [
        'loadForm' => 'render',
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
        'maleBenef' => 'numeric|min:0',
        'femaleBenef' => 'numeric|min:0',
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
        $this->users = User::where('enabled', true)->get();
        $this->matrix = PoaActivityPiat::where('piatable_type', $this->class)
            ->where('piatable_id', $this->idModel)->get();
    }

    public function render()
    {
        return view('livewire.piat.poa-create-piat-modal');
    }

    public function closeModal()
    {
        $this->resetMainForm();
        $this->resetPlanForm();
        $this->resetRequirementsForm();
        $this->emit('togglePiatAddModal');
        if ($this->piat) {
            $this->piat->is_terminated = true;
            $this->piat->save();
            flash('Matriz Terminada')->success()->livewire($this);

        }
    }

    public function updatedProvince($value)
    {
        if ($value) {
            $this->cantons = CatalogGeographicClassifier::where('parent_id', $value)->get();
        } else {
            $this->reset(['cantons', 'canton', 'parishes', 'parish']);
        }
    }

    public function updatedCanton($value)
    {
        if ($value) {
            $this->parishes = CatalogGeographicClassifier::where('parent_id', $value)->get();
        } else {
            $this->reset(['parishes', 'parish']);
        }
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
            'piatable_type' => $this->class,
            'piatable_id' => $this->idModel,
            'number_male_respo' => $this->numberMaleResp,
            'number_female_respo' => $this->numberFeMaleResp,
            'males_beneficiaries' => $this->maleBenef,
            'females_beneficiaries' => $this->femaleBenef,
            'males_volunteers' => $this->maleVol,
            'females_volunteers' => $this->femaleVol,
            'goals' => $this->goal,
            'created_by' => user()->id,
            'approved_by' => -1,
            'users_selected' => $this->usersSelect
        ];

        $response = $this->ajaxDispatch(new CreatePoaActivityPiat($data));

        if ($response['success']) {
            $aux = $response['data'];
            $this->piat = $aux;
            $this->poaPiatRequestSivol = $this->piat->poaPiatRequestsSivol;
            $this->poaPiatResponsibles = $this->piat->responsibles;
            if ($this->poaPiatRequestSivol->count() > 0) {
                $this->showAddRequestSivol = false;
            } else {
                $this->showAddRequestSivol = true;
            }
            $this->newPoaActivityPiatId = $aux->id;
            $this->newPoaActivityPiatName = $aux->name;
            $this->emit('updateIndexMatrix');
            flash(trans_choice('messages.success.added', 1, ['type' => __('general.poa_activity_piat')]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function submitPlan()
    {
        $dataPlan = $this->validate([
            'task' => 'required',
            'responsable' => 'required_if:sourceUsers,==,false',
            'planDate' => 'required|date|before:planEndDate',
            'planEndDate' => 'required|date|after:planDate',
            'planInitTime' => 'required',
            'planEndTime' => 'required',
        ]);
        $dataPlan += [
            'id_poa_activity_piat' => $this->newPoaActivityPiatId,
            'task' => $this->task,
            'responsable' => $this->responsable,
            'date' => $this->planDate,
            'end_date' => $this->planEndDate,
            'initial_time' => $this->planInitTime,
            'end_time' => $this->planEndTime,
        ];

        $response = $this->ajaxDispatch(new CreatePoaActivityPiatPlan($dataPlan));

        if ($response['success']) {
            $this->resetPlanForm();
            $this->piatPlan = PoaActivityPiatPlan::where('id_poa_activity_piat', $this->newPoaActivityPiatId)->get();
            flash(trans_choice('messages.success.added', 1, ['type' => __('general.poa_activity_piat_plan')]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function submitRequirements()
    {
        $dataRequirements = $this->validate([
            'description' => 'required',
            'quantity' => 'required',
            'approxCost' => 'required',
            'reqResponsable' => 'required_if:sourceUsers,==,false',

        ]);
        $dataRequirements += [
            'id_poa_activity_piat' => $this->newPoaActivityPiatId,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'approximate_cost' => $this->approxCost,
            'responsable' => $this->reqResponsable,
        ];

        $response = $this->ajaxDispatch(new CreatePoaActivityPiatRequirements($dataRequirements));

        if ($response['success']) {
            $this->resetRequirementsForm();
            $this->piatReq = PoaActivityPiatRequirements::where('id_poa_activity_piat', $this->newPoaActivityPiatId)->get();
            flash(trans_choice('messages.success.added', 1, ['type' => __('general.poa_activity_piat_requirement')]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }
    }

    public function resetMainForm()
    {
        $this->reset(
            [
                'piatReq',
                'name',
                'place',
                'date',
                'endDate',
                'initTime',
                'endTime',
                'province',
                'canton',
                'parish',
                'poaActivity',
                'numberMaleResp',
                'numberFeMaleResp',
                'maleBenef',
                'maleVol',
                'femaleVol',
                'goal',
                'createdBy',
                'approvedBy',
                'newPoaActivityPiatId',
                'piatPlan',
            ]);
    }

    public function resetPlanForm()
    {
        $this->reset(
            [
                'task',
                'planDate',
                'planEndDate',
                'responsable',
                'planEndTime',
                'planInitTime',
                'responseRequest',
            ]);
        $this->resetValidation();
    }

    public function resetRequirementsForm()
    {
        $this->reset(
            [
                'description',
                'quantity',
                'approxCost',
                'reqResponsable',
            ]);
        $this->resetValidation();
    }

    public function terminate()
    {
        $this->piat->is_terminated = true;
        $this->piat->save();
        $this->closeModal();
    }

    public function requestVol()
    {
        $this->validate(['numberRequestVol' => 'required|numeric|min:1|integer']);
        $x = 0;
        while ($x < 10000000) {
            $x++;
        }
        $response = Http::post('http://project-backend.test/api/projects', [
            'name' => 'Solicitud de activacion',
            'code' => $this->piat->id,
            'type' => $this->numberRequestVol,
            'status' => 'Network Administrator',
            'phase' => 'Network Administrator',
        ]);

        $data =
            [
                'poa_activity_piat_id' => $this->piat->id,
                'description' => 'respuesta solicitud mensaje',
                'number_request' => $this->numberRequestVol,
            ];

        if ($response->successful()) {
            try {
                DB::beginTransaction();
                PoaPiatRequestSivol::create($data);
                $this->responseRequest = 'Solicitud generada satisfactoriamente de ' . $this->numberRequestVol . ' voluntarios';
                $this->reset(['numberRequestVol', 'showAddRequestSivol']);
                $this->emitSelf('refresh');
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

    public function updatedSourceUsers($value)
    {
        if ($value == true) {
            $this->reset(['usersSelect']);
        }
    }
}
