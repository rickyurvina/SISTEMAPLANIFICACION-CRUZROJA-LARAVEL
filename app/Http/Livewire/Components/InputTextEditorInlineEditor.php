<?php

namespace App\Http\Livewire\Components;

use App;
use Illuminate\Support\Str;
use Livewire\Component;

class InputTextEditorInlineEditor extends Component
{
    public $model;

    public $newValue;

    public $value;

    public $field;

    public $rows;

    public $event;

    public $defaultValue;

    public $class;

    public $modelId;

    public $showEditor = false;

    public $text;

    public $key;

    public $placeholder;

    public function mount(string $class, string $field, int $modelId, $key = null, string $event = null, $defaultValue = null, $placeholder = null)
    {
        $this->field = $field;
        $this->event = $event;
        $this->class = $class;
        $this->modelId = $modelId;
        $this->value = $defaultValue;
        $this->text = $defaultValue;
        $this->key = $key;
        $this->placeholder = $placeholder;
        $this->init();
    }

    public function store()
    {

        if ($this->text != $this->defaultValue) {
            $this->model = App::make($this->class)::find($this->modelId);
            $this->model->{$this->field} = $this->text;
            $this->model->save();
            $this->value = $this->text;
            if ($this->event) {
                $this->emit($this->event);
            }
            $this->text = '';
            $this->showEditor = false;
            flash(__('general.update_success'))->success()->livewire($this);
            $this->init();
        }
    }

    private function init()
    {

        if ($this->model) {
            $this->value = $this->model->{$this->field};
            $this->newValue = $this->model->{$this->field};
        } else {
            $this->value = $this->defaultValue ?? "";
            $this->newValue = $this->defaultValue ?? "";
        }
    }

    public function render()
    {
        return view('livewire.components.input-text-editor-inline-editor');
    }
}
