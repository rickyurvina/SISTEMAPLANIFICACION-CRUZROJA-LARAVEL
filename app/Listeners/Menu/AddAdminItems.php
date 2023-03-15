<?php

namespace App\Listeners\Menu;

use App\Events\Menu\AdminCreated;

class AddAdminItems
{
    /**
     * Handle the event.
     *
     * @param  $event
     *
     * @return void
     */
    public function handle(AdminCreated $event)
    {
        // Set Current Module
        session(['module' => trans('general.module_admin')]);

        $menu = $event->menu;
        $user = user();

        // Companies
        $menu->add(trans_choice('general.companies', 2), ['route' => 'companies.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-landmark"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.companies', 2), 'data-filter-tags' => strtolower(trans_choice('general.companies', 2))]);

        // Users
        $menu->add(trans_choice('general.users', 2), ['route' => 'users.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-user"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.users', 2), 'data-filter-tags' => strtolower(trans_choice('general.users', 2))]);

        //Roles
        $menu->add(trans_choice('general.roles', 2), ['route' => 'roles.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-key"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.roles', 2), 'data-filter-tags' => strtolower(trans_choice('general.roles', 2))]);

        // Organizational Structure
        $menu->add(trans_choice('general.organizational_structure', 2), ['route' => 'departments.index'])
            ->append('</span>')
            ->prepend('<i class="fal fa-balance-scale-right"></i> <span class="nav-link-text">')
            ->link->attr(['title' => trans_choice('general.organizational_structure', 2), 'data-filter-tags' => strtolower(trans_choice('general.organizational_structure', 2))]);

        // Catalogs
        $menu->add(trans_choice('general.configuration', 1))
            ->prepend('<i class="fas fa-cogs"></i>')
            ->nickname('general.configuration')
            ->link->href('#');
        $menu->item('general.configuration')->add(trans_choice('general.catalog', 2), ['route' => 'admin.catalogs']);

    }
}
