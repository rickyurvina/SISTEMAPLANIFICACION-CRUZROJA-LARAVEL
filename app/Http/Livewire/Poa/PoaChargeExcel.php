<?php

namespace App\Http\Livewire\Poa;

use App\Imports\Poa\PoaActivitiesImport;
use App\Traits\Jobs;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Validators\ValidationException;

class PoaChargeExcel extends Component
{
    use Jobs, WithFileUploads;

    public $file = null;
    public $errorsListExcel = [];
    public $errorsExceptions = null;
    public $poaId = null;

    public function mount(int $idPoa)
    {
        $this->poaId = $idPoa;
    }

    public function render()
    {
        return view('livewire.poa.poa-charge-excel');
    }

    public function getCsvFile()
    {
        $this->reset(['errorsListExcel', 'errorsExceptions']);
        $this->validate([
            'file' => 'required|mimes:xlsx',
        ]);
        try {
            DB::beginTransaction();
            $poaActivitiesImport = new PoaActivitiesImport($this->poaId);
            $poaActivitiesImport->import($this->file);
            flash('POA Creado satisfactoriamente...')->success();
            DB::commit();
            return redirect()->route('poas.activities.index', ['poa' => $this->poaId]);
        } catch (ValidationException $e) {
            $array = array_merge([
                'failures' => collect($e->failures())
            ]);
            $this->errorsListExcel = $array['failures'];
        } catch (\Throwable $e) {
            $this->errorsExceptions = $e->getMessage();
            $this->reset(['file']);
            $this->dispatchBrowserEvent('fileReset');
        }
    }

    public function resetModal()
    {
        $this->reset(['file', 'errorsListExcel']);
        $this->resetValidation();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('fileReset');
    }
}
