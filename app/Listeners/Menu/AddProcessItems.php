<?php

namespace App\Listeners\Menu;

use App\Events\Menu\ProcessCreated;

class AddProcessItems
{
    /**
     * Handle the event.
     *
     * @param QualityCreated $event
     * @return void
     */
    public function handle(ProcessCreated $event)
    {
        // Set Current Module
        session(['module' => trans_choice('general.module_process', 2)]);

        $menu = $event->menu;
        $user = user();

        // Process List
        $menu->add(trans_choice('general.module_process', 0), ['route' => 'processes.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-pencil"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.module_process', 0), 'data-filter-tags' => strtolower(trans_choice('general.module_process', 0))]);

        $menu->add(trans_choice('general.configuration', 1))
            ->prepend('<i class="fas fa-cogs"></i>')
            ->nickname('general.configuration')
            ->link->href('#');

        $menu->item('general.configuration')->add(trans_choice('general.catalog', 2), ['route' => 'process.catalogs']);

        $menu->add(trans('general.reports'), ['route' => 'process.reports'])
            ->append('</span>')
            ->prepend('<i class="fas fa-table"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.reports')]);
    }
}
