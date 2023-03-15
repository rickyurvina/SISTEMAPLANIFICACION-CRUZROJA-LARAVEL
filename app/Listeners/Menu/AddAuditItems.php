<?php

namespace App\Listeners\Menu;

use App\Events\Menu\AuditCreated;

class AddAuditItems
{
    /**
     * Handle the event.
     *
     * @param  $event
     *
     * @return void
     */
    public function handle(AuditCreated $event)
    {
        // Set Current Module
        session(['module' => trans('general.module_audit')]);

        $menu = $event->menu;
        $user = user();

        // Home
        $menu->add(trans('general.start'), ['route' => 'audit.home'])
            ->append('</span>')
            ->prepend('<i class="fal fa-globe"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans('general.start'), 'data-filter-tags' => strtolower(trans('general.start'))]);
    }
}
