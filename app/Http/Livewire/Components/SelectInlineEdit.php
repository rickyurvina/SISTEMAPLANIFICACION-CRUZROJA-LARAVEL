<?php

namespace App\Http\Livewire\Components;

use App;
use App\Models\Projects\Activities\Task;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class SelectInlineEdit extends Component
{
    public $model;
    public $modelId;

    public $newValue;

    public $newSelectedValue;

    public $value;

    public $selectedValue;

    public $field;

    public $selectClass;

    public $selectField;

    public $selectRelation;

    public $selectValues;

    public $selectValuesArray;

    public $selectArray;

    public $size;

    public $event;
    public $limit;

    public $selectModel;
    public $class;
    public $fieldId;
    public $canBeNull = false;

    public function mount(
        int    $modelId,
        string $class,
        string $field,
        string $value = null,
        string $selectField = null,
        string $selectRelation = null,
        int    $fieldId = null,
               $selectClass = null,
               $selectArray = null,
        string $size = '1x',
        string $event = null,
        int    $limit = null,
        bool   $canBeNull = false
    )
    {
        $this->modelId = $modelId;
        $this->fieldId = $fieldId;
        $this->newSelectedValue = $fieldId;
        $this->class = $class;
        $this->field = $field;
        $this->value = $value;
        $this->selectRelation = $selectRelation;
        $this->selectValues = $selectClass;
        $this->selectField = $selectField;
        $this->event = $event;
        $this->size = $size;
        $this->limit = $limit;
        $this->canBeNull = $canBeNull;
        if (is_null($selectClass)) {
            $this->selectValuesArray = $selectArray;
        }
    }

    private function init()
    {
        if ($this->model) {
            $this->model = $this->model->fresh();
            if (!is_null($this->selectClass)) {
                $this->newValue = $this->model->{$this->selectRelation} ? $this->model->{$this->selectRelation}->{$this->selectField} : null;
                $this->value = $this->model->{$this->selectRelation} ? $this->model->{$this->selectRelation}->{$this->selectField} : null;
                $this->newSelectedValue = $this->model->{$this->field};
                $this->selectedValue = $this->model->{$this->field};
                $this->fieldId = $this->selectedValue;
            } else {
                $this->newValue = $this->model->{$this->field};
                if ($this->model->{$this->field}) {
                    $this->value = $this->selectValuesArray[$this->model->{$this->field}];
                } else {
                    $this->value = $this->model->{$this->field};
                }
                $this->newSelectedValue = $this->model->{$this->field};
                $this->selectedValue = $this->model->{$this->field};
            }
        }
    }

    public function save()
    {
        $newSelectedValue = (string)Str::of($this->newSelectedValue)->trim();
        if ($newSelectedValue != $this->fieldId && $newSelectedValue != '' && $this->canBeNull == false) {
            $this->model = App::make($this->class)::find($this->modelId);
            $this->model->{$this->field} = $newSelectedValue;
            $this->model->save();
            flash(__('general.update_success'))->success()->livewire($this);
            if ($this->event) {
                $this->emit($this->event);
            }
        }
        if ($this->canBeNull == true) {
            if ($newSelectedValue != $this->fieldId) {
                $this->model = App::make($this->class)::find($this->modelId);
                $this->model->{$this->field} = $newSelectedValue == "" ? NULL : $newSelectedValue;
                $this->model->save();
                flash(__('general.update_success'))->success()->livewire($this);
                if ($this->event) {
                    $this->emit($this->event);
                }
            }
        }
        $this->init();
    }

    public function render()
    {
        return view('livewire.components.select-inline-edit');
    }

}
