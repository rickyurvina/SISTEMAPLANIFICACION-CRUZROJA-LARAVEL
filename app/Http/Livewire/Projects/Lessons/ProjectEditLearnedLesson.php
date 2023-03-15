<?php

namespace App\Http\Livewire\Projects\Lessons;

use App\Models\Projects\ProjectLearnedLessons;
use App\Traits\Jobs;
use App\Traits\Uploads;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectEditLearnedLesson extends Component
{
    use WithFileUploads, Jobs, Uploads;

    public $background;
    public $causes;
    public $learned_lesson;
    public $corrective_lesson;
    public $evidences;
    public $recommendations;
    public $type;
    public $knowledge;
    public $project;
    public $lesson;

    protected $listeners = ['openEditModalLesson'];

    public function openEditModalLesson(int $id)
    {
        $this->lesson = ProjectLearnedLessons::find($id);
        $this->project = $this->lesson->project;
        $this->background = $this->lesson->background;
        $this->causes = $this->lesson->causes;
        $this->learned_lesson = $this->lesson->learned_lesson;
        $this->corrective_lesson = $this->lesson->corrective_lesson;
        $this->evidences = $this->lesson->evidences;
        $this->recommendations = $this->lesson->recommendations;
        $this->type = $this->lesson->type;
        $this->knowledge = $this->lesson->knowledge;
    }

    public function resetForm()
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
            'project',
            'lesson',
        ]);
    }

    public function render()
    {
        return view('livewire.projects.lessons.project-edit-learned-lesson');
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
            'project',
            'lesson',
        ]);
        $this->emit('updateLessons');
        $this->emit('toggleEditLesson');
    }

    public function edit()
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
            'id'=>$this->lesson->id,
            'user_id' => user()->id,
            'phase' => $this->project->phase,
            'state' => $this->project->status,
        ];
        $this->lesson->loadMedia(['file']);
        $media = $this->lesson->media;
        $response = $this->ajaxDispatch(new \App\Jobs\Projects\ProjectEditLesson($data));
        if ($response['success']) {
            flash(trans_choice('messages.success.updated', 1, ['type' => trans_choice('general.learned_lesson', 0)]))->success()->livewire($this);
        } else {
            flash($response['message'])->error()->livewire($this);
        }

        $this->closeModal();
    }
}
