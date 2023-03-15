<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class BlankPage extends Component
{

    public $title;
    public $subTitle;
    public $content;

    public function mount($title=null, $subTitle=null, $content=null){
        $this->title=$title;
        $this->subTitle=$subTitle;
        $this->content=$content;
    }
    public function render()
    {
        return view('livewire.components.blank-page');
    }
}
