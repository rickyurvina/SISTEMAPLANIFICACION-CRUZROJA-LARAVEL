<?php

namespace App\Http\Livewire\Poa;

use App\Models\Poa\Poa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PoaApprove extends Component
{
    public $poa;
    public $terms = false;

    protected $listeners=['mount'];

    public function mount(int $id=null){
        if ($id){
            $this->poa=Poa::with(['approvedBy'])->find($id);
        }
    }

    public function render()
    {
        return view('livewire.poa.poa-approve');
    }
    public function submit()
    {
        $this->poa->loadMedia(['file']);
        $media = $this->poa->media;
        if (count($media) > 0) {
            if ($this->terms === true) {
                try {
                    DB::beginTransaction();
                    $this->poa->approved = true;
                    $this->poa->approved_by = user()->id;
                    $this->poa->approved_date = now();
                    $this->poa->save();
                    DB::commit();
                    flash(trans_choice('messages.success.approved', 0, ['type' => trans_choice('general.module_poa', 0)]))->success();
                    return redirect()->route('poa.poas');
                }catch (\Exception $exception){
                    DB::rollback();
                    flash(trans_choice('messages.error.approve_permission_denied', 0, ['type' => trans_choice('general.module_poa', 0)]))->success();
                }
            } else {
                flash('Es necesario leer y estar de acuerdo con los Téminos y Condiciones')->warning()->livewire($this);
            }
        } else {
            flash('Para aprobar el POA se debe subir al menos un archivo')->error()->livewire($this);
        }
    }

    public function resetForm(){
        $this->reset(['poa','terms']);
    }
}
