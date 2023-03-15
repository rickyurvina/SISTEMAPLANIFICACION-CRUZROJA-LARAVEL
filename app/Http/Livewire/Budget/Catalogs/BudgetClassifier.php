<?php

namespace App\Http\Livewire\Budget\Catalogs;

use Livewire\Component;

class BudgetClassifier extends Component
{
    public function mount()
    {

    }

    public function render()
    {
        $budgetClassifiers = \App\Models\Budget\Catalogs\BudgetClassifier::collect();
        return view('livewire.budget.catalogs.budget-classifier', compact('budgetClassifiers'));
    }
}
