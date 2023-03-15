<?php

namespace App\Http\Livewire\Poa\ChangeControl;

use App\Models\Auth\User;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Vendor\Spatie\Activity;
use Illuminate\Support\Collection;
use Livewire\Component;
use function view;

class PoaChangeControl extends Component
{

    public ?int $selectedUser = null;

    public ?Collection $poaActivities = null;

    public ?Collection $users = null;

    public ?string $startDate = null;

    public ?string $endDate = null;

    public array $filtersSelected = [];

    public $poa_id = null;

    public $search = '';


    public function mount($poaId = null)
    {
        $currentYear = date('Y');
        $currentPoa = Poa::enabled()->with(['programs.activities'])->where('year', $currentYear)->first();
        if ($currentPoa){
            $this->poaActivities = PoaActivity::withTrashed()->whereIn('poa_program_id', $currentPoa->programs->pluck('id', 'id'))->pluck('id');
        }
        $this->users = User::enabled()->get();
    }

    public function render()
    {
        $search = $this->search;
        $activitiesLog = null;
        if ($this->poaActivities) {
            $activitiesLog = Activity::where('subject_type', PoaActivity::class)
                ->whereIn('subject_id', $this->poaActivities)
                ->when($this->startDate, function ($q) {
                    $q->where('created_at', '>=', $this->startDate);
                })
                ->when($this->endDate, function ($q) {
                    $q->where('created_at', '<=', $this->endDate);
                })
                ->when($this->selectedUser, function ($q) {
                    $q->where('causer_id', $this->selectedUser);
                })
                ->when($search, function ($q) use($search) {
                    $q->where('description', 'iLIKE', '%' . $search . '%');
                })
                ->orderBy('created_at','DESC')
                ->paginate(10);
        }
        return view('livewire.poa.change-control.poa-change-control', compact('activitiesLog'));
    }

    public function cleanAllFilters()
    {
        $this->selectedUser = null;
        $this->startDate = null;
        $this->endDate = null;
        $this->mount();
    }

    public function filter()
    {
        $this->filtersSelected = [];
        if ($this->startDate || $this->endDate) {
            $this->filtersSelected[] =
                [
                    'name' => 'Fechas',
                    'type' => 'date'
                ];
        }
        if ($this->selectedUser) {
            $this->filtersSelected[] =
                [
                    'name' => User::where('id', $this->selectedUser)->first()->name,
                    'type' => 'user'
                ];
        }
        $this->emit('toggleDropDownFilter');
    }

    public function cleanFilter($type)
    {
        switch ($type) {
            case 'user':
                $this->selectedUser = null;
                break;
            case 'date':
                $this->startDate = null;
                $this->endDate = null;
                break;
        }
        $this->filter();
    }
}
