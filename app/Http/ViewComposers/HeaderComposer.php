<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class HeaderComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = user();
        $companies = [];

        if (!empty($user)) {
            // Get user companies
            $companies = $user->companies()->enabled()->limit(25)->get()->sortBy('name');
        }

        $view->with([
            'user' => $user,
            'companies' => $companies,
        ]);
    }
}
