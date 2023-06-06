<?php

namespace App\Http\Livewire\Poa;

use App\Jobs\Poa\CreatePoa;
use App\Models\Poa\Poa;
use App\States\Poa\InProgress;
use App\States\Poa\Planning;
use App\Traits\Jobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PoaCreate extends Component
{
    use Jobs;

    public $year;

    public $years = [];

    public function mount()
    {
        $yearsPoas = Poa::collect()->pluck('year');
        for ($i = 1; $i <= 5; $i++) {
            $year = 2020 + $i;
            if (!in_array($year, $yearsPoas->toArray()))
                array_push($this->years, $year);
        }
    }

    public function render()
    {
        return view('livewire.poa.poa-create');
    }

    public function resetModal()
    {
        $this->reset(['year']);
    }

    /**
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store()
    {
        try {
            if ($this->year == null) {
                $currentYear = date('Y');
            } else {
                $currentYear = $this->year;
            }
            $name = __('general.title.new', ['type' => __('general.poa')]);
            $userInCharge = user()->id;
            $data = [
                'year' => $currentYear,
                'name' => $name . ' ' . $currentYear,
                'user_id_in_charge' => $userInCharge,
                'status' => InProgress::label(),
                'phase' => Planning::label(),
                'company_id' => session('company_id'),
            ];
            DB::beginTransaction();
            $response = $this->ajaxDispatch(new CreatePoa($data));
            if ($response['success']) {
                flash(trans_choice('messages.success.added', 0, ['type' => __('general.poa')]))->success();
                DB::commit();
            } else {
                flash($response['message'])->error();
            }
            return redirect()->route('poa.poas');
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
            return redirect()->route('poa.poas');
        }
    }
}
