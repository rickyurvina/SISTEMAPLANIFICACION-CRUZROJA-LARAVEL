<?php

use App\Helpers\Installer;
use App\Models\Admin\Company;
use Database\Seeders\BdgClassifiersTableSeeder;
use Database\Seeders\BdgFinancingSourceClassifiersTableSeeder;
use Database\Seeders\CatalogGeographicClassifiersTableSeeder;
use Database\Seeders\CatalogSeeder;
use Database\Seeders\CatalogSeederModify;
use Database\Seeders\CleanPoas;
use Database\Seeders\CleanScoresAndMeasureAdvances;
use Database\Seeders\CreatePermissionsAzure;
use Database\Seeders\CreateScoreOnPlanAndPlanDetails;
use Database\Seeders\DeletePoasScores;
use Database\Seeders\GeneratedServicesTableSeeder;
use Database\Seeders\IndicatorSourcesTableSeeder;
use Database\Seeders\IndicatorUnitSeeder;
use Database\Seeders\Measure\CalendarSeeder;
use Database\Seeders\Measure\PeriodSeeder;
use Database\Seeders\Measure\ScoringTypeSeeder;
use Database\Seeders\Permissions;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\PerspectivesTableSeeder;
use Database\Seeders\PrjProjectCatalogAssistantsTableSeeder;
use Database\Seeders\PrjProjectCatalogFundersTableSeeder;
use Database\Seeders\PrjProjectCatalogLineActionServicesTableSeeder;
use Database\Seeders\PrjProjectCatalogLineActionsTableSeeder;
use Database\Seeders\PrjProjectCatalogRiskClassificationTableSeeder;
use Database\Seeders\ProcessEvaluationCatalogTableSeeder;
use Database\Seeders\RoleHasPermissionsTableSeeder;
use Database\Seeders\UpdateFullCodeParrish;
use Database\Seeders\UpdateIndicatorUnitsForPeople;
use Database\Seeders\UpdatePrjTaskTypeOfAggregation;
use Database\Seeders\UpdateScoresStrategyWithJob;
use Database\Seeders\UpdateUnitIdOnMeasureAdvances;
use Database\Seeders\UpdateYearToProjects;
use Illuminate\Database\Seeder;
use Database\Seeders\PublicPurchasesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        Company::reguard();
//        Installer::createCompany('Sede Central', 'es_ES', '', null);
//        Installer::createUser('Administrador', 'admin@admin.com', 'password', 'es_ES');
//        $this->call(IndicatorSourcesTableSeeder::class);
//        $this->call(IndicatorUnitSeeder::class);
//        $this->call(CatalogSeederModify::class);
//        $this->call(BdgClassifiersTableSeeder::class);
//        $this->call(BdgFinancingSourceClassifiersTableSeeder::class);
//        $this->call(CatalogGeographicClassifiersTableSeeder::class);
//        $this->call(PublicPurchasesSeeder::class);
//        $this->call(PrjProjectCatalogFundersTableSeeder::class);
//        $this->call(PrjProjectCatalogAssistantsTableSeeder::class);
//        $this->call(CalendarSeeder::class);
//        $this->call(PeriodSeeder::class);
//        $this->call(ScoringTypeSeeder::class);
//        $this->call(PrjProjectCatalogRiskClassificationTableSeeder::class);
//        $this->call(GeneratedServicesTableSeeder::class);
//        $this->call(PerspectivesTableSeeder::class);
//        $this->call(CreatePermissionsAzure::class);
//        $this->call(Permissions::class);

//        $this->call(CreateScoreOnPlanAndPlanDetails::class);
        //        $this->call(PrjProjectCatalogLineActionsTableSeeder::class);
//        $this->call(PrjProjectCatalogLineActionServicesTableSeeder::class);
//        $this->call(DeletePoasScores::class);
//        $this->call(UpdateFullCodeParrish::class);
//        $this->call(UpdateYearToProjects::class);
//        $this->call(UpdatePrjTaskTypeOfAggregation::class);
        $this->call(CleanScoresAndMeasureAdvances::class);
//        $this->call(UpdateUnitIdOnMeasureAdvances::class);
//        $this->call(UpdateIndicatorUnitsForPeople::class);
//        $this->call(UpdateScoresStrategyWithJob::class);
//        $this->call(\Database\Seeders\DeleteActivityLog::class);
//        $this->call(ProcessEvaluationCatalogTableSeeder::class);
//        $this->call(\Database\Seeders\CleanProjects::class);
//        $this->call(CleanPoas::class);
    }
}