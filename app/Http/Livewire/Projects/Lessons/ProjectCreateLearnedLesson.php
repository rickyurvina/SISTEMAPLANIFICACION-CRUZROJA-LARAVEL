<?php

namespace App\Http\Livewire\Projects\Lessons;

use App\Models\Projects\Project;
use App\Models\Projects\ProjectLearnedLessons;
use App\Traits\Jobs;
use Livewire\Component;

class ProjectCreateLearnedLesson extends Component
{
    use Jobs;

    public $background;
    public $causes;
    public $learned_lesson;
    public $corrective_lesson;
    public $evidences;
    public $recommendations;
    public $type;
    public $knowledge;
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;

    }

    public function render()
    {
        return view('livewire.projects.lessons.project-create-learned-lesson');
    }

    public function closeModal()
    {
        $this->reset([
            'background',
            'causes',
            'learned_lesson',
            'corrective_lesson',
            'evidences',
            'recommendations',
            'type',
            'knowledge',
        ]);
        $this->emit('updateLessons');
        $this->emit('toggleCreateLesson');
    }

    public function create()
    {
        $data = $this->validate([
            'background' => 'required|max:255',
            'causes' => 'required|max:255',
            'learned_lesson' => 'required|max:255',
            'corrective_lesson' => 'required|max:255',
            'evidences' => 'required|max:255',
            'recommendations' => 'required|max:255',
            'type' => 'required',
            'knowledge' => 'required',
        ]);
        $data += [
            'user_id' => user()->id,
            'phase' => $this->project->phase,
            'state' => $this->project->status,
            'prj_project_id' => $this->project->id,
            'company_id' => session('company_id'),
        ];

        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectCreateLesson($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.added', 1, ['type' => trans_choice('general.learned_lesson', 0)]))->success()->livewire($this);
        } else {
            flash(trans_choice('messages.error', 1, $response['message']))->error();
        }

        flash('Lección Aprendida creada')->success()->livewire($this);
        $this->closeModal();
    }
}
