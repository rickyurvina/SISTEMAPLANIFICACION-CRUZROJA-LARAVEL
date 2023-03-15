<ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0 p-2">
    <li class="@if($project->phase->isActive(\App\States\Project\StartUp::class)) active @endif">
        <a href="#">
            <i class="fas fa-tasks"></i>
            <span class="hidden-md-down">{{ \App\States\Project\StartUp::label()}}</span>
        </a>
    </li>
    <li class="@if($project->phase->isActive(\App\States\Project\Planning::class)) active @endif">
        <a href="#">
            <i class="fas fa-pencil-alt"></i>
            <span class="hidden-md-down">{{ \App\States\Project\Planning::label() }}</span>
        </a>
    </li>
    <li class="@if($project->phase->isActive(\App\States\Project\Implementation::class)) active @endif">
        <a href="#">
            <i class="fas fa-play"></i>
            <span class="hidden-md-down">{{ \App\States\Project\Implementation::label() }}</span>
        </a>
    </li>
    <li class="@if($project->phase->isActive(\App\States\Project\Closing::class)) active @endif">
        <a href="#">
            <i class="fas fa-window-close"></i>
            <span class="hidden-md-down">{{ \App\States\Project\Closing::label() }}</span>
        </a>
    </li>
</ol>
@if($project->phase instanceof \App\States\Project\StartUp)
    <ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0 p-2">
        <li class="@if($project->status->isActive(\App\States\Project\InProcess::class)) active @endif">
            <a href="#"
               @can('project-change-status') x-on:click="show = true; transition='En proceso';" @endcan>
                <span class="badge border rounded-pill bg-white">1</span>
                <span class="hidden-md-down">{{ \App\States\Project\InProcess::label() }}</span>
            </a>
        </li>
        <li class="@if($project->status->isActive(\App\States\Project\InReview::class)) active @endif">
            <a href="#"
               @if($project->status->to() instanceof \App\States\Project\InReview) @can('project-change-status') x-on:click="show = true;" @endcan @endif >
                <span class="badge border rounded-pill bg-white">2</span>
                <span class="hidden-md-down">{{ \App\States\Project\InReview::label() }}</span>
            </a>
        </li>
        <li class="@if($project->status->isActive(\App\States\Project\Formulated::class)) active @endif">
            <a href="#"
               @if($project->status->to() instanceof \App\States\Project\Formulated) @can('project-change-status') x-on:click="show = true" @endcan @endif >
                <span class="badge border rounded-pill bg-white">3</span>
                <span class="hidden-md-down">{{ \App\States\Project\Formulated::label() }}</span>
            </a>
        </li>
        <li class="@if($project->status->isActive(\App\States\Project\Financed::class)) active @endif">
            <a href="#"
               @if($project->status->to() instanceof \App\States\Project\Pending) @can('project-change-status') x-on:click="show = true" @endcan @endif>
                <span class="badge border rounded-pill bg-white">4</span>
                <span class="hidden-md-down">{{ \App\States\Project\Financed::label() }}</span>
            </a>
        </li>
    </ol>
@endif
@if($project->phase instanceof \App\States\Project\Planning)
    <ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0 p-2">
        <li class="@if($project->status->isActive(\App\States\Project\Pending::class)) active @endif">
            <a href="#"
               @if($project->status->to() instanceof \App\States\Project\Pending) @can('project-change-status') x-on:click="show = true" @endcan @endif>
                <span class="badge border rounded-pill bg-white">1</span>
                <span class="hidden-md-down">{{ \App\States\Project\Pending::label() }}</span>
            </a>
        </li>
        <li class="@if($project->status->isActive(\App\States\Project\Completed::class)) active @endif">
            <a href="#"
               @if($project->status->to() instanceof \App\States\Project\Completed) @can('project-change-status') x-on:click="show = true" @endcan @endif>
                <span class="badge border rounded-pill bg-white">2</span>
                <span class="hidden-md-down">{{ \App\States\Project\Completed::label() }}</span>
            </a>
        </li>
    </ol>
@endif
@if($project->phase instanceof \App\States\Project\Implementation)
    <ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0 p-2">
        <li class="@if($project->status->isActive(\App\States\Project\Execution::class)) active @endif">
            <a href="#"
               @can('project-change-status') x-on:click="show = true; transition='Ejecución'" @endcan>
                <span class="badge border rounded-pill bg-white">1</span>
                <span class="hidden-md-down">{{ \App\States\Project\Execution::label() }}</span>
            </a>
        </li>
        <li class="@if($project->status->isActive(\App\States\Project\Canceled::class)) active @endif">
            <a href="#"
               @can('project-change-status') x-on:click="show = true; transition='Cancelado';" @endcan>
                <span class="badge border rounded-pill bg-white">2</span>
                <span class="hidden-md-down">{{ \App\States\Project\Canceled::label() }}</span>
            </a>
        </li>
        <li class="@if($project->status->isActive(\App\States\Project\Completed::class)) active @endif">
            <a href="#"
               @can('project-change-status') x-on:click="show = true; transition='Completado'" @endcan>
                <span class="badge border rounded-pill bg-white">3</span>
                <span class="hidden-md-down">{{ \App\States\Project\Completed::label() }}</span>
            </a>
        </li>
        <li class="@if($project->status->isActive(\App\States\Project\Discontinued::class)) active @endif">
            <a href="#"
               @can('project-change-status') x-on:click="show = true; transition='Suspendido'" @endcan>
                <span class="badge border rounded-pill bg-white">4</span>
                <span class="hidden-md-down">{{ \App\States\Project\Discontinued::label() }}</span>
            </a>
        </li>
        <li class="@if($project->status->isActive(\App\States\Project\Extension::class)) active @endif">
            <a href="#"
               @can('project-change-status') x-on:click="show = true; transition= 'Extensión'" @endcan>
                <span class="badge border rounded-pill bg-white">5</span>
                <span class="hidden-md-down">{{ \App\States\Project\Extension::label() }}</span>
            </a>
        </li>
    </ol>
@endif
@if($project->phase instanceof \App\States\Project\Closing)
    <ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0 p-2">

        <li class="@if($project->status->isActive(\App\States\Project\Pending::class)) active @endif">
            <a href="#"
               @can('project-change-status') x-on:click="show = true; transition='Pendiente'; " @endcan>
                <span class="badge border rounded-pill bg-white">1</span>
                <span class="hidden-md-down">{{ \App\States\Project\Pending::label() }}</span>
            </a>
        </li>
        <li class="@if($project->status->isActive(\App\States\Project\Closed::class)) active @endif">
            <a href="#"
               @can('project-change-status') x-on:click="show = true; transition='Cerrado';" @endcan>
                <span class="badge border rounded-pill bg-white">2</span>
                <span class="hidden-md-down">{{ \App\States\Project\Closed::label() }}</span>
            </a>
        </li>
    </ol>
@endif