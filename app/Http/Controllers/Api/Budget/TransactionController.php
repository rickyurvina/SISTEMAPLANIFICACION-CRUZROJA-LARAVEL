<?php

namespace App\Http\Controllers\Api\Budget;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Api\Resources\TransactionResource;
use App\Models\Budget\Account;
use App\Models\Budget\Transaction;
use App\States\Transaction\Approved;
use Cknow\Money\Money;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $fields = $request->validate([
            'company_id' => 'required',
            'type' => 'required',
            'year' => 'required',
        ]);

        // Set company id
        session(['company_id' => $fields['company_id']]);

        $query = Transaction::where([
            ['type', '=', $fields['type']],
            ['year', '=', $fields['year']],
        ])->whereState('status', Approved::class);

        return $this->jsonResource(TransactionResource::collection($query->get()));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'company_id' => 'required',
            'type' => ['required', Rule::in([Transaction::TYPE_COMMITMENT, Transaction::TYPE_ACCRUED])],
            'year' => 'required',
            'description' => 'required',
            'items' => 'required',
            'items.*.account_id' => 'required',
            'items.*.amount' => 'required|numeric|gt:0',
            'items.*.description' => 'required',
            'user_id' => 'required'
        ]);

        try {
            DB::beginTransaction();
            // Set company id
            session(['company_id' => $fields['company_id']]);

            if (self::validateBudgetStatus($fields['year']) == 0) {
                return $this->response(['error' => 'Budget not found'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $errors = self::validateTransaction($fields['items']);
            if (count($errors) > 0) {
                return $this->response(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $number = Transaction::query()->where([
                    ['year', '=', $fields['year']],
                    ['type', '=', $fields['type']],
                ])->max('number') + 1;

            $transaction = Transaction::create([
                'year' => $fields['year'],
                'description' => $fields['description'],
                'type' => $fields['type'],
                'number' => $number,
                'created_by' => $fields['user_id']
            ]);
            foreach ($fields['items'] as $item) {
                $transaction->debit($item['amount'], $item['description'], $item['account_id']);
            }
            DB::commit();
            return $this->jsonResource(TransactionResource::make($transaction));
        } catch (Exception $exception) {
            DB::rollback();
            throw new Exception($exception->getMessage());
        }
    }

    private function validateTransaction(array $items): array
    {
        $accounts = Account::whereIn('id', collect($items)->pluck('account_id'))->with('transactionsDetails')->get();
        $errors = [];
        foreach ($items as $item) {
            $account = $accounts->firstWhere('id', $item['account_id']);
            if (!$account || $account->balance->lessThan(money_parse_by_decimal($item['amount'], Money::getDefaultCurrency()))) {
                $errors[] = [
                    'account_id' => $item['account_id'],
                    'balance' => $account ? $account->balance->formatByDecimal() : 0,
                ];
            }
        }

        return $errors;
    }

    private function validateBudgetStatus($year)
    {
        return Transaction::where([
            ['type', '=', Transaction::TYPE_PROFORMA],
            ['year', '=', $year],
        ])->whereState('status', Approved::class)->count();
    }

}
