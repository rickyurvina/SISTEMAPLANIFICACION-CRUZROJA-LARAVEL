<?php

namespace App\Http\Livewire\Budget\Actions;

use App\Jobs\Budgets\Structure\BudgetCreateStructure;
use App\Models\Budget\Catalogs\BudgetClassifier;
use App\Models\Budget\Structure\BudgetStructure;
use App\Models\Budget\Transaction;
use App\Traits\Jobs;
use Illuminate\Validation\Rule;
use Livewire\Component;

class BudgetsCreate extends Component
{
    use Jobs;

    public string $year = '';

    public string $description = '';

    public array $years = [];

    protected function rules(): array
    {
        return [
            'year' => [
                'required',
                'digits:4',
                'integer',
                'gte:2021',
                'max:' . (date('Y') + 1),
                Rule::notIn($this->years)
            ],
            'description' => 'required'
        ];
    }

    public function mount()
    {
        $this->years = Transaction::query()->where('type', Transaction::TYPE_PROFORMA)->pluck('year')->toArray();
    }

    public function submit()
    {
        $this->validate();

        $number = Transaction::query()->where([
                ['year', '=', $this->year],
                ['type', '=', Transaction::TYPE_PROFORMA],
            ])->max('number') + 1;

        $transaction = Transaction::create([
            'year' => $this->year,
            'description' => $this->description,
            'type' => Transaction::TYPE_PROFORMA,
            'number' => $number,
            'created_by' => user()->id,
            'company_id' => session('company_id')
        ]);

        $response = $this->ajaxDispatch(new BudgetCreateStructure($transaction));

        if ($response['success']) {
            flash(trans_choice('messages.success.added', 0, ['type' => __('budget.budget')]))->success();
            return redirect()->route('budgets.index');
        } else {
            flash($response['message'])->error();
            return redirect()->route('budgets.index');
        }
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.budget.actions.budgets-create');
    }
}
