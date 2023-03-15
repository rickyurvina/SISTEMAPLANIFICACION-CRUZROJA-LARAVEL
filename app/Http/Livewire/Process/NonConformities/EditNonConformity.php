<?php

namespace App\Http\Livewire\Process\NonConformities;

use App\Models\Process\NonConformities;
use Livewire\Component;
use function view;

class EditNonConformity extends Component
{
    public $nonConformity;
    public $subMenu;
    public $page;
    public $causesItems = [];

    protected $listeners=['causesEdited'];

    public function mount(int $idNonConformity, string $subMenu, string $page)
    {
        $this->nonConformity = NonConformities::with(['process'])->find($idNonConformity);
        $this->subMenu=$subMenu;
        $this->page=$page;
        $this->causesItems=$this->nonConformity->causes;
        $this->emit('loadEditedData', 'causes', $this->causesItems);

    }

    public function render()
    {
        return view('livewire.process.non-conformities.edit-non-conformity');
    }

    public function causesEdited($elements)
    {
        $data=[];
        foreach ($elements as $element) {
            $item = mb_strtoupper($element);
            array_push($data, $item);
        }
        $this->nonConformity->causes=$data;
        $this->nonConformity->save();
    }
}
