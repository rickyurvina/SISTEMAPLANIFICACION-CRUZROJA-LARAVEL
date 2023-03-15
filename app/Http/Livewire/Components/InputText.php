<?php

namespace App\Http\Livewire\Components;

use App;
use Illuminate\Support\Str;
use Livewire\Component;

class InputText extends Component
{
    public $model;

    public $newValue;

    public $value;

    public $field;

    public $event;

    public $defaultValue;

    public $class;

    public $modelId;

    public int $limit;

    public bool $title;
    public $eventLivewire;
    public $rules;
    public array $rulesArray = [];
    public $fieldValidate;

    public function rules()
    {
        if ($this->rules) {
            return [
                'fieldValidate' => $this->rules
            ];
        }
    }

    public function mount(string $class, string $field, int $modelId, $defaultValue = null, $limit = 30, $title = false, $event = null, $eventLivewire = null, $rules = null, $rulesArray = [])
    {
        $this->defaultValue = $defaultValue;
        $this->field = $field;
        $this->class = $class;
        $this->modelId = $modelId;
        $this->limit = $limit;
        $this->title = $title;
        $this->event = $event;
        $this->rules = $rules;
        $this->rulesArray = $rulesArray;
        $this->eventLivewire = $eventLivewire;
        $this->fieldValidate = $field;
        $this->init();
    }

    public function save()
    {
        $newValue = (string)Str::of($this->newValue)->trim();

        if ($newValue != $this->defaultValue) {
            if ($this->rules) {
                $this->fieldValidate = $newValue;
                $this->validate();
            }
            $this->model = App::make($this->class)::find($this->modelId);
            $this->model->{$this->field} = $newValue;
            $this->model->save();
            $this->init();
            if ($this->event) {
                event(new $this->event($this->model));
            }
            if ($this->eventLivewire) {
                $this->emit($this->eventLivewire);
            }
        } else {
            $this->resetErrorBag();
            $this->resetValidation();
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
        return view('livewire.components.input-text');
    }
}