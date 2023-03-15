<?php

namespace App\Listeners\Menu;

use App\Events\Menu\RiskCreated;

class AddRiskItems
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param RiskCreated $event
     * @return void
     */
    public function handle(RiskCreated $event)
    {
        // Set Current Module
        session(['module' => trans('general.module_risk')]);

        $menu = $event->menu;
        $user = user();

        // Risk
        $menu->add(trans('general.module_risk'), ['route' => 'risk.home'])
            ->append('</span>')
            ->prepend('<i class="fas fa-list"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.module_risk'), 'data-filter-tags' => strtolower(trans('general.module_risk'))]);

        // Response Plan
        $menu->add(trans('general.response-plan'), ['route' => 'response-plans.index'])
            ->append('</span>')
            ->prepend('<i class="fas fa-play"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.response-plan'), 'data-filter-tags' => strtolower(trans('general.response-plan'))]);

    }
}