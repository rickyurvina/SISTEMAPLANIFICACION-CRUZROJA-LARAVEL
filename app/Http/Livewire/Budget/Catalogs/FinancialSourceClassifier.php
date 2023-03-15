<?php

namespace App\Http\Livewire\Budget\Catalogs;

use App\Models\Budget\Catalogs\FinancingSourceClassifier;
use Livewire\Component;

class FinancialSourceClassifier extends Component
{
    public function render()
    {
        $financialSource = FinancingSourceClassifier::collect();
        return view('livewire.budget.catalogs.budget-financial-source', compact('financialSource'));
    }
}
