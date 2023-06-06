<?php

namespace App\Http\Livewire\Process;

use App\Models\Common\Catalog;
use App\Models\Process\Process;
use Livewire\Component;

class ProcessEvaluation extends Component
{

    public $process;
    public $importance;
    public $color;
    public $performance;
    public $evaluation_result;
    public $scale_of_performances;
    public $processId;
    public $data = [];
    public $scalesX;
    public $scalesY;

    protected $listeners = ['loadUpdateForm', 'updateStatus'];


    public function mount($processId)
    {
        $this->process = Process::find($processId);
        $this->processId = $processId;
        self::loadUpdateForm();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('updateChartDataEvaluation', ['data' => $this->data]);
        return view('livewire.process.process-evaluation');
    }

    public function loadUpdateForm()
    {
        $this->process = Process::find($this->processId);
        $this->performance = $this->process->performance == null ? 0 : $this->process->performance;
        $this->importance = $this->process->importance == null ? 0 : $this->process->importance;
        $this->evaluation_result = $this->performance * $this->importance;
        $this->scale_of_performances = Catalog::catalogName('process_evaluation_catalog')->first()->details;

        $this->data = [];
        $dataY = [];
        $dataX = [];
        if ($this->scale_of_performances->count()){
            foreach ($this->scale_of_performances[0]->properties as $item) {
                $dataY[] = $item['y'];
                $dataX[] = $item['x'];
                if ($this->performance == $item['performance'] && $this->importance == $item['importance']) {
                    $this->data[] = array_merge($item,
                        [
                            'radius' => 15,
                            'x' => $item['importance'],
                            'y' => $item['performance'],
                        ]);
                    $this->color=$item['color'];
                }
                else {
                    $this->data[] = array_merge($item,
                        [
                            'radius' => 0,
                            'x' => $item['importance'],
                            'y' => $item['performance'],
                        ]);
                }
            }
            $dataY = array_unique($dataY);
            $dataX = array_unique($dataX);
            $this->scalesY = array_reverse($dataY);
            $this->scalesX = array_reverse($dataX);
            $this->scalesX = array_reverse($this->scalesX);
        }

    }

    public function updateStatus($data)
    {
        foreach ($data as $row) {
            $this->performance = $row["performance"];
            $this->importance = $row["importance"];
            $this->evaluation_result = $row["evaluation_result"];
            $this->color=$row['color'];
        }
        $this->process->performance = $this->performance;
        $this->process->importance = $this->importance;
        $this->process->evaluation_result = $this->evaluation_result;
        $this->process->save();
        $this->loadUpdateForm();
        flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.process', 1)]))->success()->livewire($this);
    }
}
