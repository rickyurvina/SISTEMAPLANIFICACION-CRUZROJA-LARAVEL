<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Modal extends Component
{
    public bool $show = false;

    protected $listeners = [
        'show' => 'show'
    ];

    public function show(...$arg)
    {
        $this->show = true;
    }
}
