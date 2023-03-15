<?php

namespace App\Listeners\Menu;

use App\Events\Menu\PoaCreated;

class AddPoaItems
{
    /**
     * Handle the event.
     *
     * @param  $event
     *
     * @return void
     */
    public function handle(PoaCreated $event)
    {
        // Set Current Module
        session(['module' => trans('general.module_poa')]);

        $menu = $event->menu;
        $user = user();

        // POAs
        $menu->add(trans('general.poa'), ['route' => 'poa.poas'])
            ->append('</span>')
            ->prepend('<i class="fal fa-tasks"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.poa'), 'data-filter-tags' => strtolower(trans('general.start'))]);

        // POAs CONTROL DE CAMBIOS
        $menu->add(trans('general.change_control'), ['route' => 'poa.change_control'])
            ->append('</span>')
            ->prepend('<i class="fal fa-exchange"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.change_control'), 'data-filter-tags' => strtolower(trans('general.change_control'))]);

        // POAs CARD REPORTS
        $menu->add(trans('general.card_report'), ['route' => 'poa.reports.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-table"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.card_report'), 'data-filter-tags' => strtolower(trans('general.card_report'))]);

        if (session('company_id') === 1) {
            $menu->add(trans('general.poa_requests'), ['route' => 'poa.goal_change_request'])
                ->append('</span>')
                ->prepend('<i class="fal fa-ballot"></i> <span class="nav-link-text">')
                ->link->attr(['title' => trans('general.poa_requests'), 'data-filter-tags' => strtolower(trans('general.poa_requests'))]);

            $menu->add(trans_choice('general.configuration', 1))
                ->prepend('<i class="fas fa-cogs"></i>')
                ->nickname('general.configuration')
                ->link->href('#');

            $menu->item('general.configuration')->add(trans_choice('general.thresholds', 1), ['route' => 'poa.config_threshold']);
        }

        //CATALOG ACTIVITIES
        $menu->add(trans('general.poa_activities_catalogs'), ['route' => 'poa.manage_catalog_activities'])
            ->append('</span>')
            ->prepend('<i class="fal fa-book"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.poa_activities_catalogs'), 'data-filter-tags' => strtolower(trans('general.poa_activities_catalogs'))]);

    }
}
