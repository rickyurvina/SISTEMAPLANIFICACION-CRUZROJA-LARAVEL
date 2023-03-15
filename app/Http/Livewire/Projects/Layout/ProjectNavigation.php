<?php

namespace App\Http\Livewire\Projects\Layout;

use App\Http\Livewire\Components\Modal;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectStateValidations;

class ProjectNavigation extends Modal
{

    public $project;
    public $page;
    public $viewOpening=false;
    public $viewSignature=false;
    public $accountsOpening = false;
    public $signatureAgreement = false;
    public $phase = false;
    public $transition = null;
    public $resume = [];
    public $departments = [];
    public $accept = [];
    public $decline = [];
    public $justification = [];
    public $settings;
    public $exists = false;
    public array $arrayIdsDepartments = [];

    protected $listeners = ['statusUpdated' => '$refresh'];

    public function mount(Project $project, string $page = null)
    {
        if ($project) {
            $this->project = $project;
            $this->page = $page;
            $this->departments = $this->project->stateValidations->where('state', $this->project->status->to($this->transition)->label())->first();
            $this->settings = $this->departments->settings;
            if ($this->settings) {
                foreach ($this->project->get($this->settings['fields'])->first()->toArray() as $index => $item) {
                    if ($index == Project::OPENING_ACCOUNTS) {
                        $this->accountsOpening = $this->project->{Project::OPENING_ACCOUNTS};
                        $this->viewOpening = true;
                        $this->exists = false;
                    }
                    if ($index == Project::SIGNATURE_OF_AGREEMENT) {
                        $this->signatureAgreement = $this->project->{Project::SIGNATURE_OF_AGREEMENT};
                        $this->viewSignature = true;
                        $this->exists = false;
                    }
                    if (!$project->{$index}) {
                        $this->exists = true;
                    }
                }
                foreach ($this->settings['relations'] as $item) {
                    if ($project->{$item}->count() == 0) {
                        $this->exists = true;
                    }
                }
            }
            if (isset($this->departments->validations)) {
                foreach ($this->departments->validations as $index => $dept) {
                    if ($dept['value'] == 1) {
                        $this->accept[$index] = 'on';
                        $this->justification[$index] = $dept['description'];

                    } else {
                        $this->decline[$index] = 'on';
                        $this->justification[$index] = $dept['description'];
                    }
                }
            }

        }
        if (user()->departments) {
            $this->arrayIdsDepartments = user()->departments->pluck('id')->toArray();
        }
    }

    public function render()
    {
        return view('livewire.projects.layout.project-navigation');
    }

    public function changeStatus()
    {
        if (user()->cannot('project-change-status')) {
            abort(403);
        } elseif ($this->departments->validations) {
            if (count($this->departments->validations) >= 1) {
                $data = $this->departments->validations;
                foreach ($this->accept as $index => $item) {
                    if ($this->accept[$index])
                        $data[$index]['value'] = 1;
                    $data[$index]['description'] = $this->justification[$index];
                    foreach ($this->departments->validations as $key => $deptVal) {
                        if ($index == $key) {
                            if (in_array($deptVal['id'], $this->arrayIdsDepartments)) {
                                $data[$index]['user_id'] = user()->id;
                            }
                        }
                    }
                }
                foreach ($this->decline as $index => $item) {
                    $data[$index]['value'] = 0;
                    $data[$index]['description'] = $this->justification[$index];
                    foreach ($this->departments->validations as $key => $deptVal) {
                        if ($index == $key) {
                            if (in_array($deptVal['id'], $this->arrayIdsDepartments)) {
                                $data[$index]['user_id'] = user()->id;

                            }
                        }

                    }
                }
                $sumValidation = collect($data)->sum('value');
                if ($sumValidation === count($data)) {
                    $this->departments->validations = $data;
                    $this->departments->status = ProjectStateValidations::STATUS_VALIDATED;
                    $this->departments->user_id = user()->id;
                    $this->departments->save();
                    $this->project->status->transitionTo($this->project->status->to($this->transition));
                    flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 0)]))->success()->livewire($this);
                } else {
                    $this->departments->validations = $data;
                    $this->departments->status = ProjectStateValidations::STATUS_VALIDATED;
                    $this->departments->user_id = user()->id;
                    $this->departments->save();
                    flash(trans_choice('messages.error.updated', 0, ['type' => trans_choice('general.project', 0)]))->error()->livewire($this);
                }
            } else {
                $this->project->status->transitionTo($this->project->status->to($this->transition));
                flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 0)]))->success()->livewire($this);
            }
        } else {
            $this->project->status->transitionTo($this->project->status->to($this->transition));
            $this->departments->status = ProjectStateValidations::STATUS_VALIDATED;
            $this->departments->user_id = user()->id;
            $this->departments->save();
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 0)]))->success()->livewire($this);
        }
        $this->mount($this->project);
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->reset([
            'transition',
            'resume',
            'accept',
            'decline',
            'justification',
            'show',
            'viewSignature',
            'signatureAgreement',
            'viewOpening',
            'accountsOpening',
            'accountsOpening',
        ]);
        $this->emit('closeModalValidations');
    }

    public function updatedTransition()
    {
        $this->departments = $this->project->stateValidations->where('state', $this->project->status->to($this->transition)->label())->first();

    }

    public function updatedAccept($name, $value)
    {

        unset($this->decline[$value]);

    }

    public function updatedDecline($name, $value)
    {
        unset($this->accept[$value]);
    }

    public function updatedAccountsOpening()
    {
        $this->project->{Project::OPENING_ACCOUNTS} = $this->accountsOpening;
        $this->project->save();
        $this->mount($this->project);
    }

    public function updatedSignatureAgreement()
    {
        $this->project->{Project::SIGNATURE_OF_AGREEMENT} = $this->signatureAgreement;
        $this->project->save();
        $this->mount($this->project);
    }
}
