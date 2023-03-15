<?php

namespace App\Listeners\Menu;

use App\Events\Menu\ProjectCreated;

class AddProjectItems
{
    /**
     * Handle the event.
     *
     * @param ProjectCreated $event
     *
     * @return void
     */
    public function handle(ProjectCreated $event)
    {
        // Set Current Module
        session(['module' => trans('general.module_projects')]);

        $menu = $event->menu;

        $menu->add(trans_choice('general.project', 2), ['route' => 'projects.index'])
            ->append('</span>')
            ->prepend('<i class="fas fa-project-diagram"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.project', 2)]);


        $menu->add(trans_choice('general.configuration', 1))
            ->prepend('<i class="fas fa-cogs"></i>')
            ->nickname('general.configuration')
            ->link->href('#');

        $menu->item('general.configuration')->add(__('general.public_purchases'), ['route' => 'projects.purchases']);
        $menu->item('general.configuration')->add(trans_choice('general.catalog', 2), ['route' => 'projects.catalogs']);
        $menu->item('general.configuration')->add(trans('general.activity') . ' ' . trans_choice('general.thresholds', 2), ['route' => 'projects.thresholds']);

        $menu->add(trans('general.learned_lessons'), ['route' => 'projects.indexLessons'])
            ->append('</span>')
            ->prepend('<i class="fas fa-book-open"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.project', 2)]);

        $menu->add(trans('general.reports'), ['route' => 'projects.reports'])
            ->append('</span>')
            ->prepend('<i class="fas fa-table"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.reports')]);

    }
}
