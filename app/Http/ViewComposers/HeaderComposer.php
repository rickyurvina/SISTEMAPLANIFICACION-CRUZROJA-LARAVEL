<?php

namespace App\Http\ViewComposers;

use App\Models\Admin\Company;
use Illuminate\View\View;

class HeaderComposer
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = user();
        $companies = [];

        if (!empty($user)) {
            // Get user companies
            $companies = Company::whereIn('level', ['1', '2'])->get()->groupBy('level');
            $userCompanies = $user->companies->pluck('id')->toArray();
        }

        $view->with([
            'user' => $user,
            'companies' => $companies,
            'userCompanies' => $userCompanies ?? [],
        ]);
    }
}
