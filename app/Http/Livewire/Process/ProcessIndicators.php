<?php

namespace App\Http\Livewire\Process;

use App\Jobs\Indicators\Indicator\DeleteIndicator;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Process\Process;
use Livewire\Component;
use App\Traits\Jobs;
use function view;

class ProcessIndicators extends Component
{
    use Jobs;

    public $process;
    public $pageIndex;
    public $search = '';

    protected $listeners = [
        'indicatorCreated' => 'render',
        'loadIndicatorUpdated' => 'render',
    ];

    public function mount(int $processId, string $page = null)
    {
        $this->pageIndex = $page;
        $this->process = Process::find($processId);
    }

    public function render()
    {
        $search = $this->search;
        $indicators = Indicator::where('indicatorable_id', $this->process->id)
            ->where('indicatorable_type', Process::class)
            ->when($search, function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'iLIKE', '%' . $this->search . '%')
                        ->orWhere('total_goal_value', 'iLike', '%' . $this->search . '%')
                        ->orWhere('total_actual_value', 'iLike', '%' . $this->search . '%')
                        ->orWhere('type', 'iLike', '%' . $this->search . '%')
                        ->orWhere('results', 'iLike', '%' . $this->search . '%')
                        ->orWhere('category', 'iLike', '%' . $this->search . '%');
                });
            })->collect();
        return view('livewire.process.process-indicators', compact('indicators'));
    }

    public function deleteIndicator($id)
    {
        $response = $this->ajaxDispatch(new DeleteIndicator($id));
        if ($response['success']) {
            if ($response['data']) {
                $message = trans_choice('messages.error.indicator_with_progress', 1, ['type' => trans_choice('general.indicators', 1)]);
                flash($message)->error()->livewire($this);
            } else {
                $message = trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.indicators', 1)]);
                flash($message)->success()->livewire($this);
            }
        } else {
            $message = $response['message'];
            flash($message)->error()->livewire($this);
        }
    }
}
