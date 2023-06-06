<?php

namespace App\Models\Projects;

use App\Abstracts\Model;
use App\Events\Projects\ProjectCreated;
use App\Events\Projects\ProjectUpdatedThresholds;
use App\Models\Admin\Department;
use App\Models\Auth\User;
use App\Models\Budget\Transaction;
use App\Models\Comment;
use App\Models\Common\CatalogGeographicClassifier;
use App\Models\Indicators\Indicator\Indicator;
use App\Models\Projects\Activities\Task;
use App\Models\Projects\Catalogs\ProjectAssistant;
use App\Models\Projects\Catalogs\ProjectFunder;
use App\Models\Projects\Configuration\ProjectThreshold;
use App\Models\Projects\Objectives\ProjectObjectives;
use App\Models\Projects\Stakeholders\ProjectStakeholder;
use App\Models\Risk\Risk;
use App\States\Project\Canceled;
use App\States\Project\Closed;
use App\States\Project\Closing;
use App\States\Project\Completed;
use App\States\Project\Discontinued;
use App\States\Project\Execution;
use App\States\Project\Extension;
use App\States\Project\Financed;
use App\States\Project\Formulated;
use App\States\Project\Implementation;
use App\States\Project\InProcess;
use App\States\Project\InReview;
use App\States\Project\Pending;
use App\States\Project\Planning;
use App\States\Project\ProjectPhase;
use App\States\Project\ProjectState;
use App\States\Project\StartUp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;
use Spatie\ModelStates\HasStates;

class Project extends Model
{
    use  Mediable, HasStates;

    protected bool $tenantable = false;

    const UPDATED = 'El Proyecto fue actualizado';
    const CREATED = 'El Proyecto fue creado';
    const DELETED = 'El Proyecto fue eliminado';
    const ACTIVE = 'active';
    const ACTIVITIES = 'activities';
    const TEAM = 'team';
    const LOGIC_FRAME = 'logic-frame';
    const RISKS = 'risks';
    const PROFILE = 'profile';
    const STAKEHOLDERS = 'stakeholders';
    const FILES = 'files';
    const ACQUISITIONS = 'acquisitions';
    const FEASIBILITY = 'feasibility';
    const SHOPPING_SETUP = 'shopping-setup';

    const STATE_DRAFT = 'Borrador';

    const PHASE_START_UP = 'Inicio';
    const PHASE_PLANNING = 'Planificación';
    const PHASE_IMPLEMENTATION = 'Implementación';
    const PHASE_CLOSING = 'Cierre';

    const TYPE_MISSIONARY_PROJECT = 'project_missionary';
    const TYPE_INVESTMENT = 'investment';
    const TYPE_EMERGENCY = 'emergency';
    const TYPE_INTERNAL_DEVELOPMENT = 'internal_development';

    //INICIO
    const STATE_IN_PROCESS = 'En proceso';
    const STATE_IN_REVIEW = 'En Revisión';
    const STATE_FORMULATED = 'Formulado';
    const STATE_FINANCED = 'Financiado';

    //PLANNING
    const STATE_PENDING = 'Pendiente';
    const STATE_GENERAL_COMPLETED = 'Completado';

    //implementation
    const STATE_GENERAL_EXECUTION = 'Ejecución';
    const STATE_GENERAL_CANCELLED = 'Cancelado';
    const STATE_GENERAL_DISCONTINUED = 'Suspendido';
    const STATE_GENERAL_EXTENSION = 'Extensión';

    //CIERRE
    const STATE_CLOSED = 'Cerrado';

    const OPERATIONAL_EXPENSES = 'Costos Generales de Operación';
    const INDIRECT_EXPENSES = 'Costos Indirectos';
    const TYPE_SUCCESS = 'Acierto';
    const TYPE_DANGER = 'Desafío';

    const OPENING_ACCOUNTS = 'accounts_opening';
    const SIGNATURE_OF_AGREEMENT = 'signature_of_agreement';

    const PHASES = [
        StartUp::class,
        Planning::class,
        Implementation::class,
        Closing::class,
    ];

    const PHASES_INTERNAL = [
        Planning::class,
        Implementation::class,
        Closing::class,
    ];

    const STATUSES = [
        InProcess::class,
        InReview::class,
        Formulated::class,
        Financed::class,
        Pending::class,
        Completed::class,
        Execution::class,
        Canceled::class,
        Discontinued::class,
        Extension::class,
        Closed::class,
    ];

    const VALIDATIONS_RELATIONS = [
        'members',
        'tasks',
        'subsidiaries',
        'risks',
        'stakeholders',
        'beneficiaries',
        'indicators',
        'objectives',
        'tasks',
        'locations',
        'funders',
        'cooperators'
    ];

    const STATUSES_START_UP = [
        InProcess::class,
        InReview::class,
        Formulated::class,
        Financed::class,
    ];

    const STATUSES_PLANNING = [
        Pending::class,
        Completed::class,
    ];

    const STATUSES_IMPLEMENTATION = [
        Execution::class,
        Completed::class,
        Canceled::class,
        Discontinued::class,
        Extension::class,
    ];

    const STATUSES_CLOSE = [
        self::STATE_PENDING,
        self::STATE_CLOSED,
    ];

    const PROJECT_EXPENSES = [
        self::OPERATIONAL_EXPENSES,
        self::INDIRECT_EXPENSES
    ];

    const PHASE_BG = [
        self::PHASE_START_UP => 'badge-primary',
        self::PHASE_PLANNING => 'badge-secondary',
        self::PHASE_IMPLEMENTATION => 'badge-success',
        self::PHASE_CLOSING => 'badge-warning'
    ];

    const STATUS_BG = [
        self::STATE_IN_PROCESS => 'badge-warning',
        self::STATE_IN_REVIEW => 'badge-info',
        self::STATE_FORMULATED => 'badge-success',
        self::STATE_FINANCED => 'badge-dark',
        self::STATE_PENDING => 'badge-primary',
        self::STATE_GENERAL_COMPLETED => 'badge-primary',
        self::STATE_GENERAL_EXECUTION => 'badge-secondary',
        self::STATE_GENERAL_CANCELLED => 'badge-danger',
        self::STATE_GENERAL_DISCONTINUED => 'badge-light',
        self::STATE_GENERAL_EXTENSION => 'badge-warning',
        self::STATE_CLOSED => 'badge-dark',
    ];

    const TYPES_BG = [
        self::TYPE_SUCCESS => 'badge-success',
        self::TYPE_DANGER => 'badge-warning',
    ];

    const IDENTIFIER_DOCUMENTS = "documents";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prj_projects';

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'status' => ProjectState::class,
        'phase' => ProjectPhase::class
    ];

    protected $dateFormat = 'Y-m-d';


    protected $fillable = [
        'name',
        'type',
        'code',
        'phase',
        'status',
        'problem_identified',
        'general_objective',
        'start_date',
        'end_date',
        'duration',
        'project_profile',
        'description_beneficiaries',
        'description_enabling_documents',
        'responsible_id',
        'company_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'location_id',
        'year',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->problem_identified = mb_strtoupper($model->problem_identified);
            $model->general_objective = mb_strtoupper($model->general_objective);
            $model->description_beneficiaries = mb_strtoupper($model->description_beneficiaries);
            $model->description_enabling_documents = mb_strtoupper($model->description_enabling_documents);
        });
        static::updating(function ($model) {
            $model->name = mb_strtoupper($model->name);
            $model->problem_identified = mb_strtoupper($model->problem_identified);
            $model->general_objective = mb_strtoupper($model->general_objective);
            $model->description_beneficiaries = mb_strtoupper($model->description_beneficiaries);
            $model->description_enabling_documents = mb_strtoupper($model->description_enabling_documents);
        });
    }

    protected static function booted()
    {
        static::updated(function ($model) {
            if ((isset($model->getChanges()['start_date'])) || (isset($model->getChanges()['end_date']))) {
                ProjectUpdatedthresholds::dispatch($model);
            }
        });
        static::deleting(function ($model) {
            $model->threshold->each->delete();
        });
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ProjectCreated::class
    ];

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(ProjectMember::class, 'project_id');
    }

    public function subsidiaries(): HasMany
    {
        return $this->hasMany(ProjectMemberSubsidiary::class, 'project_id');
    }

    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'prj_project_members_areas', 'project_id', 'department_id')->withoutGlobalScopes();

    }

    public function risks()
    {
        return $this->morphMany(Risk::class, 'riskable');
    }

    public function stakeholders(): HasMany
    {
        return $this->hasMany(ProjectStakeholder::class, 'prj_project_id');
    }

    public function acquisitions(): HasMany
    {
        return $this->hasMany(ProjectAcquisitions::class, 'prj_project_id');
    }

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(ProjectBeneficiaries::class, 'project_id');
    }

    public function indicators(): MorphMany
    {
        return $this->morphMany(Indicator::class, 'indicatorable');
    }

    public function articulations()
    {
        return $this->hasMany(ProjectArticulations::class, 'prj_project_id');
    }

    public function objectives()
    {
        return $this->hasMany(ProjectObjectives::class, 'prj_project_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(CatalogGeographicClassifier::class, 'prj_project_locations', 'project_id', 'location_id');
    }

    public function funders()
    {
        return $this->belongsToMany(ProjectFunder::class, 'prj_project_financiers', 'project_id', 'prj_project_catalog_funders_id');
    }

    public function cooperators()
    {
        return $this->belongsToMany(ProjectAssistant::class, 'prj_project_cooperators', 'project_id', 'prj_project_catalog_assistants_id');
    }

    public function referentialBudgets()
    {
        return $this->hasMany(ProjectReferentialBudget::class, 'project_id')->orderBy('id', 'asc');
    }

    /**
     * Location activity supports
     *
     * @return BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(CatalogGeographicClassifier::class, 'location_id');
    }

    /**
     * Location activity supports
     *
     * @return CatalogGeographicClassifier
     */
    public function locationProject()
    {
        return $this->locations->first();
    }


    public function lessonsLearned()
    {
        return $this->hasMany(ProjectLearnedLessons::class, 'prj_project_id');
    }

    public function stateValidations()
    {
        return $this->hasMany(ProjectStateValidations::class, 'prj_project_id')->orderBy('id', 'asc');
    }

    public function statusChanges(): \Illuminate\Support\Collection
    {
        $activities = $this->activities()
            ->where('description', '=', 'updated')
            ->orderBy('id')
            ->get();
        $activitiesCollection = new Collection();
        foreach ($activities as $activity) {
            $new = $activity->properties['attributes']['status'];
            $old = $activity->properties['old']['status'];
            if ($new != $old)
                $activitiesCollection->push($activity);
        }
        return collect($activitiesCollection);
    }

    public function phaseChanges(): \Illuminate\Support\Collection
    {
        $activities = $this->activities()
            ->where('description', '=', 'updated')
            ->orderBy('id')
            ->get();
        $activitiesCollection = new Collection();
        foreach ($activities as $activity) {
            $new = $activity->properties['attributes']['phase'];
            $old = $activity->properties['old']['phase'];
            if ($new != $old)
                $activitiesCollection->push($activity);
        }
        return collect($activitiesCollection);
    }

    public static function statusColor(string $status)
    {
        foreach (self::STATUSES as $st) {
            if ($st::$name == $status) {
                return $st::color();
            }
        }
        return '';
    }

    public static function phasesColor(string $status)
    {
        foreach (self::PHASES as $st) {
            if ($st::$name == $status) {
                return $st::color();
            }
        }
        return '';
    }

    public function reschedulings()
    {
        return $this->hasMany(ProjectRescheduling::class, 'prj_project_id');
    }

    public function getDifferenceStartEndDates()
    {
        $date1 = $this->start_date;
        $date2 = $this->end_date;
        $diff = $date1->diff($date2);
        $result = ($diff->days * 24) + ($diff->i);
        return $result;
    }

    public function getDifferenceStartEndDatesMonths()
    {
        if (isset($this->start_date) && isset($this->end_date)) {
            $date1 = $this->start_date;
            $date2 = $this->end_date;
            $diff = $date2->diff($date1);
            if ($diff->y > 0) {
                $monthsYear = $diff->y * 12;
                $result = $monthsYear + ($diff->m);
            } else {
                $result = $diff->m;
            }
        } else {
            $result = 0;
        }
        return $result;
    }

    public function getProgressTimeUpDate()
    {
        if (isset($this->start_date) && isset($this->end_date)) {
            if ($this->start_date < now()) {
                $date1 = $this->start_date;
                $date2 = now();
                $diff = $date1->diff($date2);
                $diff = ($diff->days * 24) + ($diff->i);
                $diffStartEndDates = $this->getDifferenceStartEndDates();
                if ($diffStartEndDates > 0) {
                    return intval($diff / $diffStartEndDates * 100) > 100 ? 100 : intval($diff / $diffStartEndDates * 100);
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function getProgressUpDate()
    {
        if ($this->tasks->where('end_date', '<', now())->count() > 0) {
            return $this->tasks->where('end_date', '<', now())->sum('progress') / $this->tasks->where('end_date', '<', now())->count();
        } else {
            return 0;
        }
    }

    public function physicProgress()
    {
        $objectives = $this->objectives;
        $progressProject = 0;
        foreach ($objectives as $objective) {
            $progressObjective = 0;
            foreach ($objective->results as $result) {
                $progressResult = 0;
                foreach ($result->childrenTasks()->get() as $activity) {
                    $progressResult += $activity->progress * $activity->weight;
                }
                $progressObjective += $progressResult * $result->weight;
            }
            $progressProject += $progressObjective * $objective->weight;
        }
        return number_format($progressProject, 0);
    }

    public function physicProgressUntilDate()
    {
        $objectives = $this->objectives;
        $progressProject = 0;
        foreach ($objectives as $objective) {
            $progressObjective = 0;
            foreach ($objective->results as $result) {
                $progressResult = 0;
                foreach ($result->childrenTasks()->get() as $activity) {
                    if ($activity->start_date <= now()) {
                        $progressResult += $activity->progress * $activity->weight;
                    }
                }
                $progressObjective += $progressResult * $result->weight;
            }
            $progressProject += $progressObjective * $objective->weight;
        }
        return number_format($progressProject, 0);
    }

    public function calcSemaphore()
    {
        $time = $this->getProgressTimeUpDate();
        $progressPhysic = $this->getProgressUpDate();
        if ($this->threshold->count() > 0) {
            $properties = $this->threshold->first()->properties;
            if ($progressPhysic >= $properties['progress']['min'] && $time >= $properties['time']['max']) {
                return 'color-success-700';
            } else if (($progressPhysic >= $properties['progress']['min'] && $progressPhysic < $properties['progress']['max']) && ($time >= $properties['time']['min'] && $time < $properties['time']['max'])) {
                return 'color-warning-700';
            } else if ($progressPhysic < $properties['progress']['min'] && $time > $properties['time']['max']) {
                return 'color-danger-700';
            } else if ($progressPhysic >= $properties['progress']['max']) {
                return 'color-success-700';
            } else {
                return 'color-info-700';
            }
        } else {
            return 'color-info-700';
        }
    }

    public function evaluations()
    {
        return $this->hasMany(ProjectEvaluation::class, 'prj_project_id');
    }

    public function getTotalBudgetProject()
    {
        $total = 0;
        foreach ($this->tasks as $task) {
            $accounts = $task->accounts;
            foreach ($accounts as $account) {
                $total += $account->balance->getAmount();
            }
        }
        return money($total);
    }

    public function getTotalBudgetReformsProject()
    {
        $total = 0;
        foreach ($this->tasks as $task) {
            $accounts = $task->accounts;
            foreach ($accounts as $account) {
                $total += $account->balanceRe->getAmount();
            }
        }
        return money($total);
    }

    public function getTotalBudgetCommitmentProject()
    {
        $total = 0;
        foreach ($this->tasks as $task) {
            $accounts = $task->accounts;
            foreach ($accounts as $account) {
                $total += $account->balanceCm->getAmount();
            }
        }
        return money($total);
    }

    public function getTotalBudgetAsProject()
    {
        $total = 0;
        foreach ($this->tasks as $task) {
            $accounts = $task->accounts;
            foreach ($accounts as $account) {
                $total += $account->balanceAs->getAmount();
            }
        }
        return money($total);
    }

    public function getPercentageBudget()
    {
        if ($this->getTotalBudgetEncodedProject()->getAmount() > 0)
            return intval($this->getTotalBudgetAsProject()->getAmount() / $this->getTotalBudgetEncodedProject()->getAmount() * 100);
        else
            return 0;
    }

    public function getTotalBudgetEncodedProject()
    {
        return money($this->getTotalBudgetProject()->getAmount() - $this->getTotalBudgetReformsProject()->getAmount());
    }

    public function getTotalBudgetWithOutExecutionProject()
    {
        return money($this->getTotalBudgetEncodedProject()->getAmount() - $this->getTotalBudgetAsProject()->getAmount());
    }

    public function getPhysicProgress()
    {
        return $this->tasks->where('parent', 'root')->first()->progress;
    }

    public function getTotalBeneficiaries()
    {
        return $this->tasks->where('type', 'task')->sum('advance');
    }

    public function getTotalGoalBeneficiaries()
    {
        return $this->tasks->where('type', 'task')->sum('goal');
    }

    public function getPercentageBeneficiaries()
    {
        if ($this->getTotalGoalBeneficiaries() > 0) {
            return intval($this->getTotalBeneficiaries() / $this->getTotalGoalBeneficiaries() * 100);
        } else {
            return 0;
        }
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function threshold()
    {
        return $this->morphMany(ProjectThreshold::class, 'thresholdable');
    }

    /**
     * @return bool
     */
    public function isMisional(): bool
    {
        if ($this->type==self::TYPE_MISSIONARY_PROJECT || $this->type==self::TYPE_EMERGENCY )
            return true;
        return false;
    }

    public  function hasTransaction(){
       return Transaction::where('year', $this->year)
            ->where('type', Transaction::TYPE_PROFORMA)->withoutGlobalScopes()->first();
    }

}