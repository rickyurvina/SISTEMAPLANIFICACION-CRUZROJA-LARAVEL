<?php

namespace App\Http\Livewire\Components;

use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Weights extends Component
{
    public $items;

    public $isValid = false;

    protected $rules = [
        'items.*.weight' => 'required|numeric|min:0'
    ];

    public function mount($items)
    {
        $this->items = $items;
        $this->validate();
        $this->isValid = true;
    }

    public function save()
    {
        try {
            $this->validate();
            foreach ($this->items as $item) {
                $item->save();
            }
            $this->emit('weightUpdated');
            flash(trans_choice('messages.success.updated', 0, ['type' => trans_choice('general.assign_weights', 0)]))->success()->livewire($this);
        } catch (Exception $e) {
            flash($e->getMessage())->error()->livewire($this);
        }
    }

    public function getTotalProperty()
    {
        return $this->items->reduce(function ($result, $item) {
            return $result + $this->getWeight($item->weight);
        }, 0);
    }

    public function weight($weight)
    {
        return $this->total ? round((100 / $this->total) * $this->getWeight($weight)) : 0;
    }

    private function getWeight($weight)
    {
        return is_numeric($weight) ? $weight : 0;
    }

    public function updated($name)
    {
        try {
            $this->validate();
            $this->isValid = true;
        } catch (ValidationException $e) {
            $this->isValid = false;
        }
        $this->validateOnly($name);
    }

    public function render()
    {
        return view('livewire.components.weights');
    }
}
