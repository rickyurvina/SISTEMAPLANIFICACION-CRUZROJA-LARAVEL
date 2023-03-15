<?php

namespace App\Http\Livewire\Strategy;

use App\Jobs\Strategy\UpdatePlan;
use App\Models\Poa\Poa;
use App\Models\Strategy\Plan;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Plank\Mediable\Media;

class PlanStatusUpdate extends Component
{
    use WithFileUploads, Jobs, Uploads;

    public $file = null;
    public $files = [];
    public $filesEdit = [];
    public $observation = null;
    public $date = null;
    public $plan = null;
    public $planId = null;
    public $newStatus = null;
    public $status = null;
    public $oldStatus = null;
    public $existPlanActived = false;
    public $existsPoaConfigured = false;

    protected $listeners = ['refreshParentComponent' => '$refresh'];

    public function render()
    {
        if ($this->plan) {
            $this->filesEdit = [];
            foreach ($this->plan->media as $item) {
                $fileElement = [];
                $fileElement['id'] = $item->id;
                $fileElement['name'] = $item->filename;
                $fileElement['file'] = null;
                $fileElement['observation'] = $item->comments;
                $fileElement['delete'] = false;
                $fileElement['date'] = $item->created_at;
                $fileElement['identifier'] = $item->identifier;
                array_push($this->filesEdit, $fileElement);
            }
        }
        return view('livewire.strategy.plan-status-update');
    }

    public function mount(Plan $plan)
    {

        if ($plan) {
            $poas = Poa::with(['programs'])->get();
            $programs = $poas->pluck('programs')->collapse()->pluck('plan_detail_id')->toArray();
            foreach ($programs as $program) {
                if (in_array($program, $plan->planDetails->pluck('id')->toArray())) {
                    $this->existsPoaConfigured = true;
                    break;
                }
            }

            $this->plan = $plan;
            $this->planId = $plan->id;
            $this->status = $this->plan->status;
            $status = $this->plan->status;
            $this->oldStatus = $this->plan->status;
            if ($status == 'draft') {
                $activePlan = Plan::where('plan_type', $this->plan->plan_type)->where('status', Plan::ACTIVE)->first();
                if (!$activePlan) {
                    $this->newStatus = Plan::ACTIVE;
                } else {
                    $this->existPlanActived = true;
                }
            } else {
                $this->newStatus = Plan::ARCHIVED;
            }
        }
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset([
            'file',
            'files',
            'filesEdit',
            'observation',
            'plan',
            'planId',
            'newStatus',
            'status',
            'oldStatus',
            'existPlanActived',
            'existsPoaConfigured',
        ]);
    }

    public function updateStatus()
    {
        $this->validate([
            'file' => 'required|file',
            'observation' => 'required',
        ]);

        switch ($this->oldStatus) {
            case Plan::DRAFT:
                $this->status = Plan::ACTIVE;
                break;
            case Plan::ACTIVE:
                $this->status = Plan::ARCHIVED;
                break;
        }

        if ($this->file) {
            $fileElement = [];
            $fileElement['name'] = substr($this->file, 5);
            $fileElement['file'] = $this->file;
            $fileElement['observation'] = $this->observation;
            $fileElement['user_id'] = Auth::id();
            $fileElement['identifier'] = $this->status;
            array_push($this->files, $fileElement);
        }

        $data = [
            'status' => $this->status,
        ];

        $this->ajaxDispatch(new UpdatePlan($this->planId, $data));
        $plan = Plan::find($this->planId);
        if ($this->files) {
            foreach ($this->files as $item) {
                $media = $this->getMedia($item['file'], 'plan', null, $item['observation'], $item['user_id'], null, $item['identifier'])->id;
                $plan->attachMedia($media, 'file');
            }
        }
        $this->file = null;
        $this->files = [];
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.status', 1)]))->success()->livewire($this);

        $this->oldStatus = $this->status;
        $this->reset(['file', 'observation', 'files',
            'filesEdit',]);
        $this->dispatchBrowserEvent('fileReset');
        $this->render();
        $this->emit('loadForm', $this->planId);
    }

    public function download($id)
    {
        $media = Media::find($id);
        if ($media->fileExists()) {
            return response()->streamDownload(
                function () use ($media) {
                    $stream = $media->stream();
                    while ($bytes = $stream->read(1024)) {
                        echo $bytes;
                    }
                },
                $media->basename,
                [
                    'Content-Type' => $media->mime_type,
                    'Content-Length' => $media->size
                ]
            );
        } else {
            flash(trans('general.file_not_exist'))->error()->livewire($this);
        }
    }
}
