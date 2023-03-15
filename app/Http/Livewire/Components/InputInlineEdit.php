<?php

namespace App\Http\Livewire\Components;

use App;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class InputInlineEdit extends Component
{
    public $model;
    public $newValue;
    public $value;
    public $field;
    public $type;
    public $size;
    public $rows;
    public $event;
    public $defaultValue;
    public $class;
    public $modelId;
    public $borders;
    public $rules;
    public array $rulesArray = [];
    public $fieldValidate;
    public $code;
    public $globalScopes = false;

    public function rules()
    {
        if ($this->rules) {
            if ($this->code) {
                return [
                    'code' => $this->rules
                ];
            } else {
                return [
                    'fieldValidate' => $this->rules
                ];
            }
        }
    }


    public function mount(string $class, string $field, int $modelId,
                          string $type = 'text', string $size = '1x', string $event = null,
                          int    $rows = 5, $defaultValue = null, $borders = null,
                                 $rules = null, $rulesArray = [], $code = false, $globalScopes = false)
    {
        $this->defaultValue = $defaultValue;
        $this->field = $field;
        $this->type = $type;
        $this->size = $size;
        $this->rows = $rows;
        $this->event = $event;
        $this->class = $class;
        $this->modelId = $modelId;
        $this->borders = $borders;
        $this->rules = $rules;
        $this->rulesArray = $rulesArray;
        $this->fieldValidate = $field;
        $this->code = $code;
        $this->globalScopes = $globalScopes;
        $this->init();
    }

    public function save()
    {

        $newValue = (string)Str::of($this->newValue)->trim();

        if ($newValue != $this->defaultValue) {
            if ($this->rules) {
                $this->fieldValidate = $newValue;
                if ($this->code == true) {
                    $this->code = $newValue;
                }
                $this->validate();
            }
            if ($this->globalScopes == true) {
                $this->model = App::make($this->class)::withOutGlobalScopes()->find($this->modelId);

            } else {
                $this->model = App::make($this->class)::find($this->modelId);
            }
            $this->model->{$this->field} = $newValue;
            $this->model->save();
            if ($this->event) {
                $this->emit($this->event);
            }
            flash(__('general.update_success'))->success()->livewire($this);
            $this->init();
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
        return view('livewire.components.input-inline-edit');
    }
}