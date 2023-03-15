<?php

namespace App\Http\Livewire\Components;

use App;
use Livewire\Component;

class ColorPalette extends Component
{
    public $model;

    public $field;
    public $class;
    public $modelId;
    public $defaultValue;

    public $colorPalette;

    public function mount(string $class, string $field, int $modelId,$defaultColor='#0046AD')
    {
        $this->field = $field;
        $this->class = $class;
        $this->modelId = $modelId;
        $this->defaultValue = $defaultColor;
        $this->colorPalette = config('constants.catalog.COLOR_PALETTE');
    }

    public function save($color)
    {
        if ($this->defaultValue!=$color){

            $this->model = App::make($this->class)::find($this->modelId);
            $this->model->{$this->field} = $color;
            $this->model->save();
            flash(__('general.color_updated'))->success()->livewire($this);
            $this->emit('colorPaletteChanged');
        }
    }

    public function render()
    {
        return view('livewire.components.color-palette');
    }
}
