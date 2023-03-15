<?php

namespace App\Http\Livewire\Strategy\Navigation;

use App\Http\Controllers\Strategy\ItemsHelper;
use App\Models\Strategy\Plan;
use App\Models\Strategy\PlanDetail;
use Livewire\Component;

class Navigation extends Component
{
    public $plan = null;
    public $arrayTree = [];
    public $modelId;
    public $showPanel = true;

    public function mount(int $planId, int $modelId = 0)
    {
        $this->plan = Plan::with(['children.children', 'children.planRegistered'])->find($planId);
        $itemsHelper = new ItemsHelper($this->plan->children());
        $this->arrayTree = $itemsHelper->treeArray();
        $this->modelId = $modelId;
    }

    public function updatedShowPanel()
    {
        $this->dispatchBrowserEvent('updateNavigation');
    }

    public function render()
    {
        return view('livewire.strategy.navigation.navigation');
    }

    public function navigateToPlanDetail(int $id)
    {
        return redirect()->route('show.strategy.home', ['id' => $id, 'type' => 'objective']);
    }
}
