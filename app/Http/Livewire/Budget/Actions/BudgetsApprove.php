<?php

namespace App\Http\Livewire\Budget\Actions;

use App\Models\Budget\Transaction;
use Livewire\Component;

class BudgetsApprove extends Component
{
    public $budget;
    public $terms = false;

    protected $listeners = ['openApproveBudget'];

    public function openApproveBudget(int $id)
    {
        $this->budget = Transaction::find($id);
    }

    public function render()
    {
        return view('livewire.budget.actions.budgets-approve');
    }

    public function submit()
    {
        $this->budget->loadMedia(['file']);
        $media = $this->budget->media;
        if (count($media) > 0) {
            if ($this->terms === true) {
                $this->budget->status->transitionTo($this->budget->status->to());
                $this->budget->approved_by = user()->id;
                $this->budget->approved_date = now();
                $this->budget->save();
                flash(trans_choice('messages.success.approved', 0, ['type' => trans_choice('general.module_budget', 0)]))->success();
                return redirect()->route('budgets.index');
            } else {
                flash('Es necesario leer y estar de acuerdo con los Téminos y Condiciones')->warning()->livewire($this);
            }
        } else {
            flash('Para aprobar el presupuesto se debe subir al menos un archivo')->error()->livewire($this);
        }
    }

    public function resetForm()
    {
        $this->reset(['budget']);
    }

    public function refuse()
    {

    }
}
