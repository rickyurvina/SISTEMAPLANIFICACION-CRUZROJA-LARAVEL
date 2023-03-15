<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use function view;

class ListViewEdit extends Component
{

    public $componentId;
    public $title;

    public $event;

    public string $element = '';
    public string $elementEdited = '';
    public $elements = [];

    protected $listeners = ['loadEditedData' => 'edit', 'deleteElements'];

    public function mount($title, $event, $componentId = null)
    {
        $this->title = $title;
        $this->event = $event;
        $this->componentId = $componentId;
    }

    public function render()
    {
        return view('livewire.components.list-view-edit');
    }

    public function deleteElements()
    {
        $this->elements = [];
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

    public function edit($id)
    {
        if (($this->elements[$id] != $this->elementEdited) && (strlen($this->elementEdited) > 0)) {
            $this->elementEdited=mb_strtoupper($this->elementEdited);
            $replace = array($id => $this->elementEdited);
            $this->elements = array_replace($this->elements, $replace);
            $this->emit($this->event, $this->elements);
            $this->elementEdited = '';
        }
    }
}
