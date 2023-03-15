<?php

namespace App\Http\Livewire\Components;

use App;
use Livewire\Component;

class DropdownSimple extends Component
{

    public $model;

    public $modelClass;

    public $modelId;

    public $field;

    public $defaultValue;

    public $newValue;

    public $items = [];

    public $event;

    public $selfEventEmited;

    public function mount(string $modelClass, int $modelId, string $field, $values, $defaultValue = null, $event = null, $selfEventEmited=null)
    {
        $this->defaultValue = $defaultValue;
        $this->field = $field;
        $this->modelClass = $modelClass;
        $this->modelId = $modelId;
        $this->items = $values;
        $this->event = $event;
        $this->selfEventEmited = $selfEventEmited;
    }

    public function updatedNewValue()
    {
        if ($this->newValue != $this->defaultValue) {
            $this->model = App::make($this->modelClass)::find($this->modelId);

            $this->model->{$this->field} = $this->newValue;
            $this->model->save();
            $this->newValue = $this->model->{$this->field};
            foreach ($this->items as $key => $item) {
                if($this->newValue == $key){
                    $this->defaultValue = $item;
                }
            }
            if ($this->event) {
                event(new $this->event($this->model));
            }
            if ($this->selfEventEmited) {
                $this->emit($this->selfEventEmited);
            }
        }
    }

    public function render()
    {
        return view('livewire.components.dropdown-simple');
    }
}
