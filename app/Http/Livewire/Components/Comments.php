<?php

namespace App\Http\Livewire\Components;

use App;
use Livewire\Component;
use App\Models\Comment;

class Comments extends Component
{
    public $model;

    public $showEditor = false;
    public $answer = null;

    public $text = '';
    public $identifier;

    public function mount(string $class, int $modelId, string $identifier = null)
    {
        $this->identifier = $identifier;
        $this->model = App::make($class)::withoutGlobalScope(\App\Scopes\Company::class)->find($modelId)->load('comments');
    }

    public function store()
    {
        $comment = new Comment;
        $resp = $this->answer;

        $comment->comment = $this->text;
        $comment->identifier = $this->identifier;

        $comment->user()->associate(user());

        $this->model->comments()->save($comment);
        if ($this->answer) {
            $comment->parent_id = $this->answer;
            $comment->save();
        }
        flash(__('general.update_success'))->success()->livewire($this);
        $this->answer = null;
        $this->showEditor = false;
        $this->text = '';
        $this->model->load('comments');
        $this->emit('commentAdded');
    }

    public function render()
    {
        $comments = $this->model->comments;
        if ($this->identifier) {
            $comments = $comments->where('identifier', $this->identifier);
        }
        return view('livewire.components.comments')->with('comments', $comments);
    }
}
