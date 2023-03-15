<?php

namespace App\Http\Livewire\Poa\Requests;

use App\Jobs\Poa\CreatePoaIndicatorGoalChangeRequest;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaIndicatorGoalChangeRequest;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Livewire\Component;
use Livewire\WithFileUploads;
use function trans_choice;
use function user;
use function view;

class PoaActivityGoalChangeRequest extends Component
{
    use Jobs;

    use WithFileUploads, Uploads;

    public $activityIndicators = [];
    public $activityIndicatorCollection;
    public $goalMonth;
    public $goalCurrentValue;
    public $activityId;
    public $goalRequestJustificationForm;
    public $showAddRequest = false;
    public $goals = [];
    public $files;
    public $activity;

    protected $listeners = ['requestGoalChange'];

    public function mount($activityId)
    {
        $this->activityId = $activityId;
        $this->activityIndicatorCollection = MeasureAdvances::orderBy('id', 'asc')->where('measurable_id', $activityId)
            ->where('measurable_type', PoaActivity::class)->get();
        $count = 1;
        foreach ($this->activityIndicatorCollection as $item) {
            $element = [];
            $poaIndicatorGoalChangeRequest = PoaIndicatorGoalChangeRequest::where('measure_advance_id', $item->id)
                ->where('status', PoaIndicatorGoalChangeRequest::STATUS_OPEN)
                ->first();
            if (!$poaIndicatorGoalChangeRequest) {
                $element['id'] = $item->id;
                $element['month'] = Indicator::FREQUENCIES[12][$count];
                array_push($this->activityIndicators, $element);
                $count++;
            }
        }
        $this->goals = [];
        $activity = PoaActivity::with(['measureAdvances'])->find($activityId);
        $this->activity = $activity;
        $poaActivityDetails = $activity->measureAdvances;
        $count = 1;
        foreach ($poaActivityDetails as $poaActivityDetail) {
            $element = [];
            $element['id'] = $poaActivityDetail->id;
            $element['year'] = now()->format('Y');
            $element['monthName'] = Indicator::FREQUENCIES[12][$count];
            $element['goal'] = $poaActivityDetail->goal;
            $element['period'] = $count;
            $element['poa_activity_id'] = $this->activity->id;
            $element['request'] = '';
            array_push($this->goals, $element);
            $count++;
        }
    }

    public function render()
    {
        $listRequests = PoaIndicatorGoalChangeRequest::whereIn('measure_advance_id', $this->activityIndicatorCollection->pluck('id'))
            ->get()->groupBy('request_number');
        $data = [];
        $contApproved = 0;
        $contDeclined = 0;
        $contOpen = 0;
        foreach ($listRequests as $item) {
            switch ($item->first()->status) {
                case PoaIndicatorGoalChangeRequest::STATUS_APPROVED:
                    $contApproved++;
                    break;
                case PoaIndicatorGoalChangeRequest::STATUS_OPEN:
                    $contOpen++;
                    break;
                case PoaIndicatorGoalChangeRequest::STATUS_DENIED:
                    $contDeclined++;
                    break;
            }
        }
        $data[] = [
            'abiertas' => $contOpen,
            'aprobadas' => $contApproved,
            'rechazadas' => $contDeclined,
        ];
        return view('livewire.poa.requests.poa-activity-goal-change-request', compact('listRequests', 'data'));
    }

    public function submitRequest()
    {
        $this->validate([
            'goalRequestJustificationForm' => 'required',
        ]);
        $listRequests = PoaIndicatorGoalChangeRequest::where('poa_activity_id', $this->activity->id)->get();
        $maxNumberRequest = $listRequests->max('request_number');

        foreach ($this->goals as $item) {
            $data = [
                'old_value' => $item['goal'],
                'new_value' => $item['request'],
                'request_justification' => $this->goalRequestJustificationForm,
                'request_user' => user()->id,
                'request_number' => $maxNumberRequest + 1,
                'measure_advance_id' => $item['id'],
                'period' => $item['period'],
                'poa_activity_id' => $item['poa_activity_id'],
                'status' => PoaIndicatorGoalChangeRequest::STATUS_OPEN,
            ];
            if ($item['request'] > 0) {
                $response = $this->ajaxDispatch(new CreatePoaIndicatorGoalChangeRequest($data));
                if ($response['success']) {
                    if ($this->files) {
                        $media = $this->getMedia($this->files, 'poa')->id;
                        $response['data']->attachMedia($media, 'file');
                    }
                } else {
                    flash($response['message'])->error()->livewire($this);
                }
            }
        }
        $this->resetForm();
        $this->render();
        flash(trans_choice('messages.success.added', 1, ['type' => __('general.poa_request')]))->success()->livewire($this);
    }

    public function loadCurrentValue()
    {
        $item = $this->activityIndicatorCollection->find($this->goalMonth);
        $this->goalCurrentValue = $item->goal;
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetValidation();
        $this->reset(['goalRequestJustificationForm', 'showAddRequest']);
        $this->files = [];
    }

    public function updatedGoals()
    {
        foreach ($this->goals as $index => $item) {
            $number = (float)$item['request'];
            if ($number < 0) {
                $newItem = ['request' => ''];
                $item = array_replace($item, $newItem);
                $this->goals[$index] = $item;
                flash('Solo se aceptan valores positivos')->warning()->livewire($this);
            }
        }
    }
}
