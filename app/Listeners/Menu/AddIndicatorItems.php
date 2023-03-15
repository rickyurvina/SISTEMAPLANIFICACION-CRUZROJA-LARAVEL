<?php

namespace App\Listeners\Menu;

use App\Events\Menu\IndicatorCreated;

class AddIndicatorItems
{
    /**
     * Handle the event.
     *
     * @param  $event
     *
     * @return void
     */
    public function handle(IndicatorCreated $event)
    {
        // Set Current Module
        session(['module' => trans('general.module_indicator')]);

        $menu = $event->menu;
        $user = user();

        // indicators
        $menu->add(trans_choice('general.indicators', 2), ['route' => 'indicator.home'])
            ->append('</span>')
            ->prepend('<i class="fal fa-analytics"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.indicators', 1), 'data-filter-tags' => strtolower(trans_choice('general.indicators', 1))]);

        // goals indicators
//        $menu->add(trans_choice('general.goals_indicator', 2), ['route' => 'goalIndicator.index'])
//            ->append('</span>')
//            ->prepend('<i class="fal fa-bullseye-arrow"></i> <span class="nav-link-text">')
//            ->link->attr(['title' => trans_choice('general.goals_indicator', 1), 'data-filter-tags' => strtolower(trans_choice('general.goals_indicator', 1))]);


//        // thresholds
//        $menu->add(trans('general.module_threshold'), ['route' => 'thresholds.index'])
//            ->append('</span>')
//            ->prepend('<i class="fal fa-ballot-check"></i> <span class="nav-link-text">')
//            ->link->attr(['title' => trans('general.module_threshold'), 'data-filter-tags' => strtolower(trans('general.module_threshold'))]);
//
//        // unidades de medida
//        $menu->add(trans('general.module_units'), ['route' => 'indicator_units.index'])
//            ->append('</span>')
//            ->prepend('<i class="fal fa-balance-scale"></i> <span class="nav-link-text">')
//            ->link->attr(['title' => trans('general.module_units'), 'data-filter-tags' => strtolower(trans('general.module_units'))]);
//
//        // FUENTES DE INFORMACION
//        $menu->add(trans('general.module_sources'), ['route' => 'indicator_sources.index'])
//            ->append('</span>')
//            ->prepend('<i class="fal fa-clipboard-check"></i> <span class="nav-link-text">')
//            ->link->attr(['title' => trans('general.module_sources'), 'data-filter-tags' => strtolower(trans('general.module_sources'))]);
    }
}
