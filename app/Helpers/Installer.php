<?php

namespace App\Helpers;

use App\Jobs\Auth\CreateUser;
use App\Jobs\Admin\CreateCompany;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Class Installer
 *
 * @package App\Helpers
 */
class Installer
{

    public static function createCompany($name, $locale, $domain, $parentId)
    {
        dispatch_now(new CreateCompany([
            'name' => $name,
            'domain' => $domain,
            'parent_id' => $parentId,
            'currency' => 'USD',
            'locale' => $locale,
            'enabled' => '1',
            'identification' => '1760008130001',
            'phone' => '',
            'fax' => '',
            'level' => 1,
            'web_site' => 'www.cruzroja.org.ec',
            'description' => 'Sede central - Cruz Roja Ecuatoriana',
        ]));
    }

    public static function createUser($name, $email, $password, $locale)
    {
        dispatch_now(new CreateUser([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'locale' => $locale,
            'companies' => ['1'],
            'roles' => ['1'],
            'enabled' => '1',
        ]));
    }
}
