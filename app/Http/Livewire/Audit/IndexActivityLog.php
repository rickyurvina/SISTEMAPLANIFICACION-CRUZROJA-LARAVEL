<?php

namespace App\Http\Livewire\Audit;

use App\Models\Auth\User;
use App\Models\Poa\Poa;
use App\Models\Poa\PoaActivity;
use App\Models\Vendor\Spatie\Activity;
use Barryvdh\Snappy\Facades\SnappyPdf as PDFSnappy;
use Illuminate\Support\Collection;
use Livewire\Component;

class IndexActivityLog extends Component
{
    public ?int $selectedUser = null;

    public ?Collection $poaActivities = null;

    public ?Collection $users = null;

    public ?string $startDate = null;

    public ?string $endDate = null;

    public array $filtersSelected = [];

    public $poa_id = null;

    public $search = '';


    public ?Collection $acitivitesLogReport;


    public function mount()
    {
        $this->users = User::get();
    }

    public function render()
    {
        $search = $this->search;
        $activitiesLog = Activity::whereHas('causer', function ($query) use ($search) {
            $query->when($search, function ($q) use ($search) {
                $q->where('name', 'iLIKE', '%' . $search . '%');
            });
        })->when($this->startDate, function ($q) {
            $q->where('created_at', '>=', $this->startDate);
        })
            ->when($this->endDate, function ($q) {
                $q->where('created_at', '<=', $this->endDate);
            })
            ->when($this->selectedUser, function ($q) {
                $q->where('causer_id', $this->selectedUser);
            })
            ->when($search, function ($q) use ($search) {
                $q->orWhere('description', 'iLIKE', '%' . $search . '%');
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(50);

        return view('livewire.audit.index-activity-log', compact('activitiesLog'));
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
        $this->search = '';
        $this->filter();
    }

    public function download()
    {
        $search = $this->search;

        $activitiesLog = Activity::whereHas('causer', function ($query) use ($search) {
            $query->when($search, function ($q) use ($search) {
                $q->where('name', 'iLIKE', '%' . $search . '%');
            });
        })->when($this->startDate, function ($q) {
            $q->where('created_at', '>=', $this->startDate);
        })
            ->when($this->endDate, function ($q) {
                $q->where('created_at', '<=', $this->endDate);
            })
            ->when($this->selectedUser, function ($q) {
                $q->where('causer_id', $this->selectedUser);
            })
            ->when($search, function ($q) use ($search) {
                $q->orWhere('description', 'iLIKE', '%' . $search . '%');
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(50);

        setlocale(LC_TIME, 'es_ES.utf8');
        $date = ucfirst(strftime('%B %Y'));
//        return view('modules.project.reports.profile', ['project'=>$project, 'time' => $time ?? 0, 'plans' => $plans]);
        $pdf = PDFSnappy::loadView('livewire.audit.reports.audit_report', ['activitiesLog' => $activitiesLog]);
        $pdf->setOption('margin-left', 10);
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-bottom', 10);
        $pdf->setOption('margin-right', 10);
        $pdf->setOption('dpi', 300);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'LogsCre.pdf');
    }
}
