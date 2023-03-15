<?php

namespace App\Http\Livewire\Poa\Requests;

use App\Jobs\Poa\UpdatePoaIndicatorGoalChangeRequest;
use App\Models\Measure\MeasureAdvances;
use App\Models\Poa\PoaActivity;
use App\Models\Poa\PoaIndicatorGoalChangeRequest;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Livewire\Component;
use Livewire\WithFileUploads;
use Plank\Mediable\Media;
use function flash;
use function redirect;
use function response;
use function user;
use function view;

class PoaGoalChangeRequest extends Component
{
    use Jobs;

    use WithFileUploads, Uploads;

    public $request;
    public $requestId;
    public $poaId;
    public $activityIndicators = [];
    public $activityIndicatorCollection;

    public $goalMonth;
    public $goalCurrentValue;
    public $goalNewValue;
    public $goalRequestJustification;
    public $goalRequestUser;
    public $goalAnswerUser;
    public $goalRequestAnswer;
    public $goalAnswer;
    public $goalStatus;
    public $itemsRequests;
    public $readOnly;

    public $files;

    protected $listeners = ['requestGoalChangeEdit'];

    public function render()
    {
        return view('livewire.poa.requests.poa-goal-change-request');
    }

    public function requestGoalChangeEdit($id, $readOnly = null)
    {
        $this->readOnly = $readOnly;
        $this->requestId = $id;
        $this->request = PoaIndicatorGoalChangeRequest::find($id);
        $this->itemsRequests = PoaIndicatorGoalChangeRequest::orderBy('id', 'asc')
            ->where('request_number', $this->request->request_number)
            ->where('poa_activity_id', $this->request->poa_activity_id)
            ->get();
        $this->goalCurrentValue = $this->request->old_value;
        $this->goalNewValue = $this->request->new_value;
        $this->goalRequestJustification = $this->request->request_justification;
        $this->goalRequestAnswer = $this->request->answer_justification;
        $this->goalRequestUser = $this->request->requestUser->name;
        if ($this->request->answerUser) {
            $this->goalAnswerUser = $this->request->answerUser->name;
        }
        $this->goalStatus = $this->request->status;
    }

    /**
     * Reset Form on Cancel
     *
     */
    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();
        $this->files = [];
    }

    public function submitRequest()
    {
        $this->validate([
            'goalRequestAnswer' => 'required',
            'goalAnswer' => 'required',
        ]);

        if ($this->goalAnswer == 'APPROVED') {
            $goalAnswer = PoaIndicatorGoalChangeRequest::STATUS_APPROVED;
        } else {
            $goalAnswer = PoaIndicatorGoalChangeRequest::STATUS_DENIED;
        }

        foreach ($this->itemsRequests as $itemsRequest) {
            $data = [
                'answer_user' => user()->id,
                'answer_justification' => $this->goalRequestAnswer,
                'status' => $goalAnswer,
            ];
            $response = $this->ajaxDispatch(new UpdatePoaIndicatorGoalChangeRequest($itemsRequest->id, $data));
            if ($response['success']) {
                if ($this->files) {
                    $media = $this->getMedia($this->files, 'poa')->id;
                    $this->request->attachMedia($media, 'file');
                }
            } else {
                flash($response['message'])->error()->livewire($this);
            }
        }
        $measureAdvances = MeasureAdvances::where('measurable_type', PoaActivity::class)
            ->where('measurable_id', $itemsRequest->poa_activity_id)
            ->get();
        $poaActivity = PoaActivity::find($this->itemsRequests->first()->poa_activity_id);
        $poaActivity->goal = $measureAdvances->sum('goal');
        $poaActivity->save();
        flash(trans_choice('messages.success.updated', 1, ['type' => __('general.poa_request')]))->success();
        return redirect()->route('poa.goal_change_request');

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
