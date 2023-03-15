<?php

namespace App\Http\Livewire\Process;

use App\Http\Livewire\Components\Modal;
use App\Models\Process\Process;
use function view;

class ProcessNavigation extends Modal
{
    public $process;
    public $page;
    public $subMenu;
    public $transition = null;
    public $phase = false;

    public function mount(Process $process, string $page = null, $subMenu=null)
    {
        $this->process = $process;
        $this->page = $page;
        $this->subMenu = $subMenu;
    }

    public function render()
    {
        return view('livewire.process.process-navigation');
    }

    public function closeModal()
    {
        $this->reset([
            'transition',
            'show',
        ]);
        $this->emit('closeModalValidations');
    }

    public function changePhase()
    {
        if (user()->cannot('process-change-status')) {
            abort(403);
        } else {
            $this->process->phase->transitionTo( $this->process->phase->to($this->transition));
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.project', 0)]))->success()->livewire($this);
        }
        $this->closeModal();
    }
}
