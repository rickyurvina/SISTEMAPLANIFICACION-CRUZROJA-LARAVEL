<?php

namespace App\Listeners\Menu;

use App\Events\Menu\StrategyCreated;

class AddStrategyItems
{
    /**
     * Handle the event.
     *
     * @param  $event
     *
     * @return void
     */
    public function handle(StrategyCreated $event)
    {
        // Set Current Module
        session(['module' => trans('general.module_strategy')]);

        $menu = $event->menu;
        $user = user();

        // Home
        $menu->add(trans('general.start'), ['route' => 'strategy.home'])
            ->append('</span>')
            ->prepend('<i class="fal fa-globe"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.start'), 'data-filter-tags' => strtolower(trans('general.start'))]);

        // Plan
        $menu->add(trans_choice('general.plan', 1), ['route' => 'plans.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-align-left"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.plan', 1), 'data-filter-tags' => strtolower(trans_choice('general.plan', 1))]);

        // Measures Update
        $menu->add('Actualizar Indicadores', ['route' => 'index.measure.strategy'])
            ->append('</span>')
            ->prepend('<i class="fal fa-chart-line"></i> <span class="nav-link-text">')
            ->link->attr(['title' => 'Actualizar Indicadores', 'data-filter-tags' => strtolower('Actualizar Indicadores')]);

        // Configuration
        $menu->add(trans_choice('general.templates', 2), ['route' => 'templates.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-cog"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.configuration', 1), 'data-filter-tags' => strtolower(trans_choice('general.configuration', 1))]);


        // reporte de indicadores
        $menu->add(trans_choice('general.report_indicators', 2), ['route' => 'report.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-tachometer-slow"></i><span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.report_indicators', 1), 'data-filter-tags' => strtolower(trans_choice('general.report_indicators', 1))]);

        // reporte de indicadores
        $menu->add(trans_choice('general.report_articulations', 2), ['route' => 'report_articulations.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-border-all"></i><span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.report_articulations', 1), 'data-filter-tags' => strtolower(trans_choice('general.report_articulations', 1))]);

        // reporte de estrcutra POOA

        $menu->add(trans('general.structure_poa'), ['route' => 'report.structure_poa'])
            ->append('</span>')
            ->prepend('<i class="fal fa-border-all"></i><span class="nav-link-text">')
            ->link->attr(['title' => trans('general.structure_poa'), 'data-filter-tags' => strtolower(trans('general.structure_poa'))]);

    }
}
