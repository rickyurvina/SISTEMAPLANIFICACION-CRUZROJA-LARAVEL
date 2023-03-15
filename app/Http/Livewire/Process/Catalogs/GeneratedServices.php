<?php

namespace App\Http\Livewire\Process\Catalogs;

use App\Jobs\Process\Catalogs\GeneratedServices\CreateGeneratedService;
use App\Jobs\Process\Catalogs\GeneratedServices\DeleteGeneratedService;
use App\Models\Process\Catalogs\GeneratedService;
use App\Traits\Jobs;
use Livewire\Component;

class GeneratedServices extends Component
{
    use  Jobs;
    protected $listeners = ['serviceCreated'=>'render'];

    public function render()
    {
        $generated_services = GeneratedService::get();
        return view('livewire.process.catalogs.generated-services', compact('generated_services'));
    }
    public function delete($id)
    {
        $service = GeneratedService::find($id);
        $response = $this->ajaxDispatch(new DeleteGeneratedService($service->id));
        if ($response['success']) {
            flash(trans_choice('messages.success.deleted', 0, ['type' => trans_choice('general.service', 1)]))->success()->livewire($this);;
        } else {
            flash($response['message'])->error()->livewire($this);;
        }
    }
}
