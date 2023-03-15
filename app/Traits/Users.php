<?php

namespace App\Traits;

trait Users
{

    /**
     * Check user company assignment
     *
     * @param  $id
     *
     * @return boolean
     */
    public function isUserCompany($id): bool
    {
        $user = user();

        if (empty($user)) {
            return false;
        }

        $company = $user->companies()->where('id', $id)->first();

        return !empty($company);
    }
}
