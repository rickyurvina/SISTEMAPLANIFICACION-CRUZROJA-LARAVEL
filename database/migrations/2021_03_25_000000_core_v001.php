<?php

use App\Models\Poa\PoaActivity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CoreV001 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up()
    {
        // Companies
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->integer('level');
            $table->string('domain')->nullable();
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('last_logged_in_at')->nullable();
            $table->string('locale')->default(config('app.locale'));
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['email', 'deleted_at']);
        });

        Schema::create('user_companies', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('user_type');

            $table->primary(['user_id', 'company_id']);
        });

        // Jobs
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue');
            $table->longText('payload');
            $table->tinyInteger('attempts')->unsigned();
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');

            $table->index(['queue', 'reserved_at']);
        });

        // Catalogs
        Schema::create('catalogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        // CatalogSeeder Details
        Schema::create('catalog_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('catalog_id');
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Settings
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('key');
            $table->text('value')->nullable();

            $table->index('company_id');
            $table->unique(['company_id', 'key']);
        });

        // Social Networks
        Schema::create('social_networks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->nullable();
            $table->string('type')->nullable();
            $table->boolean('enabled')->default(1);
            $table->integer('company_id')->nullable();
            $table->index('company_id');
            $table->softDeletes();
            $table->timestamps();
        });


        // Addresses
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('street_one')->nullable();
            $table->string('street_two')->nullable();
            $table->string('street_three')->nullable();
            $table->string('number')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('enabled')->default(1);
            $table->integer('company_id')->nullable();
            $table->index('company_id');
            $table->softDeletes();
            $table->timestamps();
        });

        // Departments
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('responsible');
            $table->integer('parent_id')->nullable();
            $table->boolean('enabled')->nullable()->default(1);
            $table->integer('company_id')->nullable();
            $table->index('company_id');
            $table->foreign('responsible')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });


        // Roles and Permissions
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (empty($tableNames)) {
            throw new Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('display_name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                'model_has_roles_role_model_type_primary');
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        //Thresholds for indicators
        Schema::create('thresholds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->json('properties')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        //Sources for indicators
        Schema::create('indicator_sources', function (Blueprint $table) {
            $table->id();
            $table->string('institution');
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('type', ['Survey', 'Administrative_record', 'transactional'])->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        //Units of indicators
        Schema::create('indicator_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->char('abbreviation')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        //Indicators Table
        Schema::create('indicators', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('parent_id')->nullable()->unsigned();
            $table->foreign('parent_id')->references('id')->on('indicators');
            $table->string('name');
            $table->string('code');
            $table->float('total_goal_value')->nullable();
            $table->float('total_actual_value')->nullable();
            $table->integer('user_id')->unsigned();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('f_start_date')->nullable();
            $table->date('f_end_date')->nullable();
            $table->float('base_line')->nullable();
            $table->enum('type', ['Manual', 'Homologated', 'Grouped'])->nullable();
            $table->foreignId('indicator_units_id')->nullable()->constrained();
            $table->foreignId('indicator_sources_id')->nullable()->constrained();
            $table->foreignId('thresholds_id')->nullable()->constrained();
            $table->enum('threshold_type', ['Ascending', 'Tolerance', 'Descending'])->nullable();
            $table->integer('baseline_year')->nullable();
            $table->string('results')->nullable();
            $table->unsignedBigInteger('indicatorable_id')->nullable();
            $table->string('indicatorable_type')->nullable();
            $table->index(['indicatorable_id', 'indicatorable_type']);
            $table->enum('frequency', ['52', '12', '4', '3', '2', '1'])->nullable();
            $table->json('documents')->nullable();
            $table->enum('goals_closed', ['closed', 'open'])->nullable();
            $table->integer('company_id')->unsigned();
            $table->index('company_id');
            $table->json('threshold_properties')->nullable();
            $table->enum('type_of_aggregation', ['sum', 'weighted', 'weighted_sum'])->nullable();
            $table->string('category')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('indicator_parent_child', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('parent_indicator');
            $table->unsignedBigInteger('child_indicator');
            $table->foreign('parent_indicator')->references('id')->on('indicators');
            $table->foreign('child_indicator')->references('id')->on('indicators');
            $table->softDeletes();
            $table->timestamps();
        });


        //Indicator Goals
        Schema::create('goal_indicators', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('indicators_id')->constrained();
            $table->float('goal_value')->nullable();
            $table->float('min')->nullable();
            $table->float('max')->nullable();
            $table->float('period')->nullable();
            $table->float('actual_value')->nullable();
            $table->integer('user_updated')->unsigned();
            $table->string('state')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('year')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));

        // Plans
        Schema::create('plan_templates', function (Blueprint $table) {
            $table->id();
            $table->string('plan_type', 150);
            $table->string('description', 255);
            $table->boolean('vision')->default(0);
            $table->boolean('mission')->default(0);
            $table->boolean('temporality')->default(0);
            $table->boolean('status')->default(1);
            $table->integer('company_id');
            $table->softDeletes();
            $table->timestamps();

            $table->index('company_id');
        });

        Schema::create('plan_template_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plan_template_id');
            $table->integer('parent_id')->nullable();
            $table->smallInteger('level');
            $table->smallInteger('order');
            $table->string('name', 255);
            $table->boolean('indicators')->default(0);
            $table->boolean('cre_objective')->default(0);
            $table->integer('company_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('plan_template_id')->references('id')->on('plan_templates');
            $table->foreign('parent_id')->references('id')->on('plan_template_details');
            $table->index('company_id');
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plan_template_id');
            $table->string('code', 5);
            $table->string('name', 255);
            $table->text('description');
            $table->boolean('showVision')->default(0);
            $table->text('vision')->nullable();
            $table->boolean('showMission')->default(0);
            $table->text('mission')->nullable();
            $table->boolean('showTemporality')->default(0);
            $table->smallInteger('temporality_start')->nullable();
            $table->smallInteger('temporality_end')->nullable();
            $table->string('responsable', 255);
            $table->boolean('status')->default(1);
            $table->integer('company_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('plan_template_id')->references('id')->on('plan_templates');

            $table->index('company_id');
        });

        Schema::create('plan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('plan_registered_template_detail_id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('code', 10);
            $table->string('name', 255);
            $table->smallInteger('level');
            $table->boolean('mission_objective')->default(0);
            $table->boolean('organizational_development')->default(0);
            $table->string('perspective', 150)->nullable();
            $table->integer('company_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('parent_id')->references('id')->on('plan_details');

            $table->index('company_id');
        });

        Schema::create('plan_registered_template_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('plan_template_detail_id');
            $table->integer('parent_id')->nullable();
            $table->smallInteger('level');
            $table->smallInteger('order');
            $table->string('name', 255);
            $table->boolean('indicators')->default(0);
            $table->boolean('cre_objective')->default(0);
            $table->integer('company_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('plan_id')->references('id')->on('plans');

            $table->index('company_id');
        });

        // Process
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('owner', 255)->nullable();
            $table->integer('company_id');
            $table->index('company_id');
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('result')->nullable();
            $table->string('product')->nullable();
            $table->string('specs')->nullable();
            $table->string('cares')->nullable();
            $table->string('procedures')->nullable();
            $table->string('equipment')->nullable();
            $table->string('supplies')->nullable();
            $table->integer('process_id');
            $table->integer('company_id');
            $table->index('company_id');
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        // POA
        Schema::create('poa_poas', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year');
            $table->string('name', 255);
            $table->integer('user_id_in_charge');
            $table->string('status', 50);
            $table->float('progress')->default(0);
            $table->integer('company_id');
            $table->index('company_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('poa_departments', function (Blueprint $table) {
            $table->integer('poa_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->primary(['poa_id', 'department_id']);
        });

        Schema::create('poa_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('poa_id')->constrained();
            $table->foreign('poa_id')->references('id')->on('poa_poas');
            $table->foreignId('plan_detail_id')->constrained();
            $table->float('progress')->default(0);
            $table->float('weight')->default(0);
            $table->integer('company_id');
            $table->string('color', 15)->nullable();
            $table->index('company_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('poa_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poa_program_id')->constrained();
            $table->foreignId('indicator_unit_id')->nullable()->constrained();
            $table->foreignId('indicator_id')->constrained();
            $table->foreignId('plan_detail_id')->constrained();
            $table->string('name');
            $table->string('community')->nullable();
            $table->integer('user_id_in_charge');
            $table->string('status')->default(PoaActivity::STATUS_SCHEDULED);
            $table->float('goal')->default(0);
            $table->float('progress')->default(0);
            $table->float('cost')->default(0);
            $table->float('impact')->default(0);
            $table->float('complexity')->default(0);
            $table->float('poa_weight')->default(0);
            $table->integer('company_id');
            $table->index('company_id');
            $table->timestamps();
            $table->softDeletes();
        });

        //catalog purchases
        Schema::create('catalog_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->longText('name')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        //PROJECTS
        Schema::create('prj_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('type', 50);
            $table->string('code', 10);
            $table->string('phase', 30);
            $table->string('status', 30);
            $table->text('problem_identified')->nullable();
            $table->text('general_objective')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('estimated_time')->nullable();
            $table->integer('duration')->nullable();
            $table->string('estimated_amount')->nullable();
            $table->boolean('project_profile')->nullable()->default(false);
            $table->text('description_beneficiaries')->nullable();
            $table->text('description_enabling_documents')->nullable();
            $table->unsignedInteger('responsible_id')->nullable();
            $table->integer('company_id');
            $table->index('company_id');
            $table->integer('location_id')->nullable();
            $table->foreign('responsible_id')->references('id')->on('users');
            $table->boolean('accounts_opening')->default(false);
            $table->boolean('signature_of_agreement')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('prj_project_catalog_line_actions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('plan_detail_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('prj_project_catalog_line_action_services', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('prj_project_catalog_line_actions_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('prj_project_catalog_line_action_service_activities', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')
                ->on('prj_project_catalog_line_action_services');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('prj_project_catalog_funders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('type')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('prj_project_catalog_assistants', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('prj_project_cooperators', function (Blueprint $table) {
            $table->integer('project_id')->unsigned();
            $table->integer('prj_project_catalog_assistants_id')->unsigned();
            $table->primary(['project_id', 'prj_project_catalog_assistants_id']);
        });

        //project founders
        Schema::create('prj_project_financiers', function (Blueprint $table) {
            $table->integer('project_id')->unsigned();
            $table->foreignId('prj_project_catalog_funders_id')->unsigned();
            $table->primary(['project_id', 'prj_project_catalog_funders_id']);
        });

        //projects members
        Schema::create('prj_project_members', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id');
            $table->text('responsibilities')->nullable();
            $table->double('contribution')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('place_id')->nullable();
            $table->foreign('project_id')->references('id')->on('prj_projects');
        });

        //project members subsidiaries
        Schema::create('prj_project_members_subsidiaries', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('company_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('project_id')->references('id')->on('prj_projects');
        });

        Schema::create('prj_project_objectives', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color', 200)->nullable();
            $table->foreignId('prj_project_id')->nullable()->constrained('prj_projects');
            $table->softDeletes();
            $table->timestamps();
        });

        //projects tasks
        Schema::create('prj_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('text');
            $table->text('description')->nullable();
            $table->integer('duration');
            $table->integer('goal')->nullable();
            $table->integer('advance')->nullable();
            $table->float('progress')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('parent');
            $table->string('type')->nullable();
            $table->boolean('readonly')->nullable();
            $table->boolean('editable')->nullable();
            $table->integer('sortorder')->default(0);
            $table->boolean('open')->default(1);
            $table->string('color')->nullable();
            $table->string('status')->nullable();
            $table->float('impact')->nullable()->default(1);
            $table->float('complexity')->nullable()->default(1);
            $table->float('amount', 2)->nullable();
            $table->float('weight', 2)->nullable();
            $table->unsignedInteger('project_id');
            $table->foreign('project_id')->references('id')->on('prj_projects');
            $table->integer('company_id');
            $table->index('company_id');
            $table->foreignId('owner_id')->nullable()->constrained('users');
            $table->json('owner')->nullable();
            $table->unsignedBigInteger('indicator_id')->nullable();
            $table->unsignedBigInteger('taskable_id')->nullable();
            $table->string('taskable_type')->nullable();
            $table->text('assumptions')->nullable();
            $table->json('planning')->nullable();
            $table->unsignedInteger('objective_id')->nullable();
            $table->foreign('objective_id')->references('id')->on('prj_project_objectives');
            $table->timestamps();
            $table->softDeletes();
        });

        //projects tasks
        Schema::create('prj_task_activities', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();;
            $table->string('name')->nullable();;
            $table->foreignId('user_id')->nullable();
            $table->foreignId('prj_task_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('prj_task_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prj_task_id')->constrained();
            $table->float('goal')->nullable();
            $table->float('progress')->nullable();
            $table->string('period')->nullable();
            $table->integer('company_id')->nullable();
            $table->index('company_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('prj_tasks_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->references('id')->on('prj_tasks');
            $table->foreignId('service_id')->references('id')->on('prj_project_catalog_line_action_services');
//            $table->primary(['task_id', 'service_id']);
        });

        //projects links
        Schema::create('prj_links', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('source');
            $table->integer('target');
            $table->boolean('readonly')->nullable();
            $table->boolean('editable')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //project articulations
        Schema::create('prj_project_articulations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prj_project_id')->nullable()->unsigned();
            $table->foreign('prj_project_id')->references('id')->on('prj_projects');
            $table->unsignedBigInteger('plan_target_detail_id')->nullable()->unsigned();
            $table->foreign('plan_target_detail_id')->references('id')->on('plan_details');
            $table->unsignedBigInteger('plan_target_registered_template_id')->nullable()->unsigned();
            $table->foreign('plan_target_registered_template_id')->references('id')->on('plan_registered_template_details');
            $table->unsignedBigInteger('plan_target_id')->nullable()->unsigned();
            $table->foreign('plan_target_id')->references('id')->on('plans');
            $table->timestamps();
        });


        //priority zones
        Schema::create('prj_project_priority_zones', function (Blueprint $table) {
            $table->integer('project_id')->unsigned();
            $table->integer('priority_zone_id')->unsigned();
            $table->primary(['project_id', 'priority_zone_id']);
        });

        //members areas
        Schema::create('prj_project_members_areas', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('department_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('project_id')->references('id')->on('prj_projects');
            $table->foreign('department_id')->references('id')->on('departments');
        });
        //project beneficiaires
        Schema::create('prj_project_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->integer('beneficiary_id')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('company_id')->nullable();
            $table->index('company_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('prj_project_acquisitions', function (Blueprint $table) {
            $table->id();
            $table->integer('prj_project_id');
            $table->integer('product_id');
            $table->string('description', 255);
            $table->integer('unit_id');
            $table->float('quantity');
            $table->float('price');
            $table->float('total_price');
            $table->integer('type_id');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('prj_project_id')->references('id')->on('prj_projects');
            $table->foreign('product_id')->references('id')->on('catalog_purchases');
            $table->foreign('unit_id')->references('id')->on('catalog_details')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('catalog_details')->onDelete('cascade');
        });

        Schema::create('prj_project_locations', function (Blueprint $table) {
            $table->integer('project_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->primary(['project_id', 'location_id']);
        });

        //project stakegholders
        Schema::create('prj_project_stakeholders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('prj_project_id')->nullable()->constrained();
            $table->string('priority')->nullable();//prioridad
            $table->text('description')->nullable();//descriptccion
            $table->string('interest_level')->nullable();//select de alto o bajo
            $table->string('influence_level')->nullable();//select de alto o bajo
            $table->text('positive_impact')->nullable();;//texto con bullets
            $table->text('negative_impact')->nullable();;//texto con bullets
            $table->string('strategy')->nullable();//calculo de estrategia dependiendo el nivel de intenres e influencia
            $table->softDeletes();
            $table->timestamps();
        });
        //stakehodlers actions
        Schema::create('prj_project_stakeholder_actions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('start_date')->nullable();//fecha de inicio
            $table->date('end_date')->nullable();//fecha de fin
            $table->string('frequency')->nullable();
            $table->string('state')->nullable();//estado
            $table->string('color')->nullable();//estado
            $table->foreignId('user_id');
            $table->foreignId('prj_project_stakeholder_id')->nullable()->constrained();
            $table->unsignedInteger('task_id')->nullable();
            $table->foreign('task_id')->references('id')->on('prj_tasks');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('prj_project_communication_matrix', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();//fecha de inicio
            $table->date('end_date')->nullable();//fecha de fin
            $table->string('frequency')->nullable();
            $table->string('state')->nullable();//estado
            $table->string('color')->nullable();//estado
            $table->string('information_type')->nullable();//tipo de inofrmacion requerida
            $table->string('format_information_presentation')->nullable();//formato de presentacion de la informacion
            $table->foreignId('user_id')->nullable();
            $table->foreignId('prj_project_stakeholder_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('prj_project_referential_budget', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->json('funders_amount')->nullable();
            $table->double('amount')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('prj_projects');
            $table->unsignedInteger('task_id')->nullable();
            $table->foreign('task_id')->references('id')->on('prj_tasks');
            $table->timestamps();
        });
        // Risks
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('cause')->nullable();
            $table->date('identification_date')->nullable();
            $table->date('closing_date')->nullable();
            $table->date('incidence_date')->nullable();
            $table->string('cost')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('probability')->nullable();
            $table->integer('impact')->nullable();
            $table->string('classification')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->index('company_id');
            $table->boolean('enabled')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        //stakehodlers actions
        Schema::create('risk_actions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('start_date')->nullable();//fecha de inicio
            $table->date('end_date')->nullable();//fecha de fin
            $table->string('state')->nullable();//estado
            $table->string('color')->nullable();//estado
            $table->foreignId('user_id');
            $table->foreignId('risk_id')->nullable()->constrained();
            $table->unsignedInteger('task_id')->nullable();
            $table->foreign('task_id')->references('id')->on('prj_tasks');
            $table->timestamps();
            $table->softDeletes();
        });


        //END PROJECTS
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {

        Schema::drop('notifications');
        Schema::drop('jobs');
        Schema::drop('failed_jobs');

        // Cascade table first
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
        Schema::drop('prj_project_acquisitions');
        Schema::drop('prj_project_stakeholder_actions');
        Schema::drop('prj_project_communication_matrix');
        Schema::drop('prj_project_stakeholders');
        Schema::drop('prj_project_beneficiaries');
        Schema::drop('prj_project_members_areas');
        Schema::drop('prj_project_budgets');
        Schema::drop('prj_project_priority_zones');
        Schema::drop('prj_tasks_services');
        Schema::drop('prj_project_catalog_line_action_service_activities');
        Schema::drop('prj_project_catalog_line_action_services');
        Schema::drop('prj_project_catalog_line_actions');
        Schema::drop('prj_project_articulations');
        Schema::drop('prj_links');
        Schema::drop('prj_project_members_subsidiaries');
        Schema::drop('prj_project_members');
        Schema::dropIfExists('prj_project_financiers');
        Schema::drop('prj_project_cooperators');
        Schema::drop('prj_project_catalog_assistants');
        Schema::drop('prj_project_catalog_funders');


        Schema::drop('catalog_details');
        Schema::drop('catalogs');
        Schema::drop('catalog_purchases');


        Schema::drop('settings');
        Schema::drop('user_companies');
        Schema::drop('companies');


        Schema::drop('indicator_parent_child');
        Schema::drop('poa_activities');


        // POA
        Schema::dropIfExists('poas');
        Schema::dropIfExists('poa_programs');
        Schema::dropIfExists('poa_program_indicators');
        Schema::dropIfExists('poa_program_indicator_activities');
        Schema::drop('poa_poas');

        // Plans
        Schema::dropIfExists('plan_template_details');
        Schema::dropIfExists('plan_details');
        Schema::dropIfExists('plan_registered_template_details');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('plan_templates');

        Schema::drop('social_networks');

        Schema::drop('risk_actions');
        Schema::drop('risks');
        Schema::drop('addresses');
        Schema::drop('departments');
        Schema::drop('prj_project_referential_budget');
        Schema::drop('prj_tasks');
        Schema::dropIfExists('prj_task_details');
        Schema::drop('prj_project_objectives');
        Schema::drop('prj_projects');
        Schema::drop('users');
        Schema::drop('goal_indicators');
        Schema::drop('indicators');
        Schema::drop('indicator_sources');
        Schema::drop('indicator_units');
        Schema::drop('thresholds');

        // Processes
        Schema::drop('processes');
        Schema::drop('activities');

        //projects
        Schema::dropIfExists('prj_project_locations');

    }
}
