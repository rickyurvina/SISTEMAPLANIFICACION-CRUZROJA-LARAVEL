<?php

namespace App\Listeners\Menu;

use App\Events\Menu\CommonCreated;

class AddCommonItems
{
    /**
     * Handle the event.
     *
     * @param  $event
     *
     * @return void
     */
    public function handle(CommonCreated $event)
    {
        // Set Current Module
        session(['module' => '']);

        $menu = $event->menu;
        $user = user();

        // Home
        $menu->add(trans('general.start'), ['route' => 'common.home'])
            ->append('</span>')
            ->prepend('<i class="fal fa-globe"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.start'), 'data-filter-tags' => strtolower(trans('general.start'))]);
    }
}
