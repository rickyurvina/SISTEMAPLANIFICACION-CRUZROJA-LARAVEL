<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class ListView extends Component
{
    public $componentId;
    public $title;

    public $event;

    public string $element = '';
    public $elements = [];

    protected $listeners = [
        'loadEditedData' => 'edit',
        'deleteElements'];

    public function mount($title, $event, $componentId = null)
    {
        $this->title = $title;
        $this->event = $event;
        $this->componentId = $componentId;
    }

    public function render()
    {
        return view('livewire.components.list-view');
    }

    public function deleteElements()
    {
        $this->elements=[];
    }

    public function addElement()
    {
        array_push($this->elements, $this->element);
        $this->element = '';
        $this->emit($this->event, $this->elements);
    }

    public function removeItem($item)
    {
        $removedElement = array_splice($this->elements, array_search($item, $this->elements), 1);
        $this->emit($this->event, $this->elements);
    }

    public function edit($id, $elements)
    {
        if ($id == $this->componentId) {
            $this->elements = $elements;
        }
    }
}
