<?php

namespace App\Http\Livewire\Projects\LogicFrame;

use App\Models\Projects\Activities\Task;
use App\Models\Projects\Project;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectLogicFrameIndicatorsReport extends Component
{
    use  Jobs;

    public $projectId;
    public $project;

    public $project_results;
    public $data_project_results;
    public $data_information_project_result;

    public $indicators;


    protected $listeners = ['loadProjectResultsCharts' => 'mount'];

    public function mount($id)
    {
        $this->projectId = $id;
        $this->project = Project::find($id);
        $this->calculateDataChart();
    }

    public function calculateDataChart()
    {
        $data_names_indicators = [];
        $data_information_project_result = [];
        $results=Task::where('project_id',$this->project->id)->where('type','project')->where('parent','!=','root')->get();
        if ($results->count() != 0) {
            $this->project_results = $results;
            foreach ($this->project_results as $result) {
                $data_names_indicators = [];
                foreach ($result->indicators as $indicator) {
                    array_push($data_names_indicators, $indicator->name);
                }
                array_push($data_information_project_result, ['result' => $result->text, 'menor' => reset($data_names_indicators), 'mayor' => end($data_names_indicators), 'color' => $result->color]);
            }
        }

        $new_indicators_array = [];
        $new_results_data = [];
        foreach ($this->project_results as $result) {
            foreach ($result->indicators as $indicator) {
                $progress = $indicator->getStateIndicator();
                array_push($new_indicators_array, $indicator);
                array_push($new_results_data, ["result" => $result->text, "color" => $result->color, "indicator" => $indicator->name, "progress" => $progress[1], "id" => $indicator->id]);
            }
        }

        $this->data_project_results = json_encode($new_results_data);
        $this->indicators = $new_indicators_array;
        $this->data_information_project_result=$data_information_project_result;

    }

    public function render()
    {
        $this->dispatchBrowserEvent('updateChartDataProjectResults', [
            'data_project_results' => $this->data_project_results,
            'data_information_project_result' => $this->data_information_project_result
        ]);
        return view('livewire.projects.logic_frame.project-logic-frame-indicators-report', ['indicators' => $this->indicators]);
    }
}
