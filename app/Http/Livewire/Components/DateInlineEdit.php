<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Livewire\Component;

class DateInlineEdit extends Component
{

    public $model;

    public $newValue;

    public $value;

    public $field;

    public $type;

    public $defaultValue;

    public $event;
    public $modelId;
    public $class;
    public $rules;
    public $fieldValidate;

    public function rules(){
        if ($this->rules){
            return [
                'fieldValidate' => $this->rules
            ];
        }
    }

    public function mount(string $class, string $field, int $modelId, string $type = 'date', string $event = null, $defaultValue = null,$rules = null)
    {
        $this->class = $class;
        $this->modelId = $modelId;
        $this->defaultValue = $defaultValue;
        $this->field = $field;
        $this->type = $type;
        $this->event = $event;
        $this->rules = $rules;
        $this->fieldValidate = $field;
        $this->init();
    }

    private function init()
    {
        if ($this->model) {
            $this->value = $this->model->{$this->field}->format('j F, Y');
            $this->newValue = $this->model->{$this->field};
        } else {
            $this->value = $this->defaultValue ?? "";
            $this->newValue = $this->defaultValue ?? "";
        }
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
            flash(__('general.update_success'))->success()->livewire($this);
            if ($this->event) {
                $this->emit($this->event);
            }
        }
    }

    public function render()
    {
        return view('livewire.components.date-inline-edit');
    }
}
