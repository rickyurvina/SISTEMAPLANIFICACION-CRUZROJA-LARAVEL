<?php

namespace App\Listeners\Menu;

use App\Events\Menu\BudgetCreated;
use Str;
use function Illuminate\Support\Str;

class AddBudgetItems
{
    /**
     * Handle the event.
     *
     * @param  $event
     *
     * @return void
     */
    public function handle(BudgetCreated $event)
    {

        // Set Current Module
        session(['module' => trans('general.module_budget')]);

        $menu = $event->menu;
        $user = user();

        // Home
        $menu->add(trans('general.start'), ['route' => 'budget.home'])
            ->append('</span>')
            ->prepend('<i class="fal fa-globe"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.start'), 'data-filter-tags' => strtolower(trans('general.start'))]);

        // Budget Incomes
        $menu->add(trans_choice('budget.budget', 2), ['route' => 'budgets.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-dollar-sign"></i><span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('budget.budget', 2)]);

        $menu->add(trans_choice('budget.reports', 2), ['route' => 'budget.reports'])
            ->append('</span>')
            ->prepend('<i class="fal fa-table"></i><span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('budget.reports', 2)]);

        // Configuration
        $config = $menu->add(trans_choice('general.configuration', 1));
        $config->append('</span>')
            ->prepend('<i class="fas fa-cogs"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.configuration', 1)])->href('#');

        // Budget Source structure
        $config->add(trans_choice('budget.structure', 1), ['route' => 'structure.index'])
            ->append('</span>')
            ->prepend('<span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('budget.structure', 1)]);

        // Budget Catalog
        $config->add(trans_choice('budget.classifier', 1), ['route' => 'budget_catalogs.index'])
            ->append('</span>')
            ->prepend('<span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('budget.classifier', 1)]);

        // Budget Source financing catalog
        $config->add(trans_choice('budget.classifier-financing-source', 1), ['route' => 'source-information.index'])
            ->append('</span>')
            ->prepend('<span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('budget.classifier-financing-source', 1)]);

        // Budget Source financing catalog
        $config->add(trans_choice('budget.classifier-geographic', 1), ['route' => 'geographic-classifier.index'])
            ->append('</span>')
            ->prepend('<span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('budget.classifier-geographic', 1)]);
    }
}
