<?php


use Cknow\Money\Money;
use App\Models\Admin\Company;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Traits\DateTime;
use App\Helpers\Date;

if (!function_exists('user')) {
    /**
     * Get the authenticated user.
     *
     * @return Authenticatable
     */
    function user(): Authenticatable
    {
        return Auth::user();
    }
}

if (!function_exists('loadSettings')) {
    /**
     * Reset and load settings
     *
     */
    function loadSettings()
    {
        // Overrides apply per company
        $company_id = session('company_id');
        if (empty($company_id)) {
            return;
        }

        // Set the active company settings
        setting()->setExtraColumns(['company_id' => $company_id]);
        setting()->forgetAll();
        setting()->load(true);

        // Timezone
        config(['app.timezone' => setting('localisation.timezone', 'UTC')]);
        date_default_timezone_set(config('app.timezone'));

        // Locale
        if (session('locale') == '') {
            app()->setLocale(setting('default.locale'));
        }

        // Set app url dynamically
        config(['app.url' => url('/')]);
    }
}

if (!function_exists('company_date')) {
    /**
     * Format the given date based on company settings.
     *
     * @param $date
     *
     * @return string
     */
    function company_date($date)
    {
        $date_time = new class() {
            use DateTime;
        };

        return Date::parse($date)->format($date_time->getCompanyDateFormat());
    }
}

if (!function_exists('auto_version')) {
    function auto_version($file = '')
    {
        if (!file_exists($file)) {
            return $file;
        }
        $version = filemtime($file);
        return $file . '?' . $version;
    }
}

if (!function_exists('company')) {
    /**
     * Get current company
     *
     *
     * @return string
     */
    function company(): string
    {
        $company = Company::query()->find(session('company_id'));
        return $company->name;
    }
}

if (!function_exists('company_name')) {
    /**
     * Get current company name
     *
     *
     * @return string
     */
    function company_name(): string
    {
        $company = Company::query()->find(session('company_id'));
        return $company->name;
    }
}

if (!function_exists('money_decimal_format')) {

    /**
     * @param Money $money
     *
     * @return string
     */
    function money_decimal_format(Money $money): string
    {
        return $money->format(null, null, \NumberFormatter::DECIMAL);
    }
}

if (!function_exists('weight')) {

    /**
     * @param $total
     * @param $weight
     *
     * @return string
     */
    function weight($total, $weight): string
    {
        return $total ? round((100 / $total) * $weight) : 0;
    }
}