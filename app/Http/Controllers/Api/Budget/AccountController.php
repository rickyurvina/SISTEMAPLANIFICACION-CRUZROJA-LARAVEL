<?php

namespace App\Http\Controllers\Api\Budget;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Api\Resources\AccountResource;
use App\Models\Budget\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function show($id)
    {
        $account = Account::withoutGlobalScopes()->with('transactions')->find($id);
        return $this->jsonResource(AccountResource::make($account));
    }

    public function index(Request $request)
    {
        $fields = $request->validate([
            'company_id' => 'required',
            'year' => 'required',
        ]);

        // Set company id
        session(['company_id' => $fields['company_id']]);

        $query = Account::where([
            ['year', '=', $fields['year']],
        ])->has('transactions')
            ->when(isset($fields['type']), function ($q) use ($fields) {
                $q->where('type', $fields['type']);
            })->when(isset($fields['code']), function ($q) use ($fields) {
                $q->where('code', $fields['code']);
            });

        return $this->jsonResource(AccountResource::collection($query->get()));
    }
}
