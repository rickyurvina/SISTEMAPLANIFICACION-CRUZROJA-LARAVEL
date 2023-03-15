<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Api\Resources\CompanyResource;
use App\Models\Admin\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        $fields = $request->validate([
            'identification' => 'required',
        ]);

        $company = Company::join('settings', 'companies.id', '=', 'settings.company_id')
            ->where([
                ['key', '=', 'company.identification'],
                ['value', '=', $fields['identification']]
            ])->select('companies.*')->firstOrFail();

        return $this->jsonResource(CompanyResource::make($company));
    }
}
