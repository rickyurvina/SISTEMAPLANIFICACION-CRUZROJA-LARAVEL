<header class="page-header" role="banner">
    <a href="{{ route('common.home') }}" class="page-logo">
        <img src="{{ asset_cdn("/img/logo.png") }}" alt="{{ trans('footer.software') }}" aria-roledescription="logo">
        <span class="page-logo-text mr-1" style="font-size: 1.25rem">{{ trans('footer.software') }}</span>
        <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
    </a>
    <div class="hidden-md-down dropdown-icon-menu position-relative">
        <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden"
           title="{{ trans('header.hide_navigation') }}">
            <i class="ni ni-menu"></i>
        </a>
        <ul>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify"
                   title="{{ trans('header.minify_navigation') }}">
                    <i class="ni ni-minify-nav"></i>
                </a>
            </li>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed"
                   title="{{ trans('header.lock_navigation') }}">
                    <i class="ni ni-lock-nav"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="hidden-lg-up">
        <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
            <i class="ni ni-menu"></i>
        </a>
    </div>
    <div>
        @if($user->companies->count()==1)
            <a class="text-white fs-xl" href="#"
               role="button">
                {{ Str::limit(setting('company.name'), 70) }}
            </a>
        @else
            <a class="nav-link dropdown-toggle text-white fs-xl" href="#" id="navbarDropdownMenuLink"
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Str::limit(setting('company.name'), 70) }}
            </a>
            <div class="dropdown-menu" x-placement="bottom-start"
                 aria-labelledby="navbarDropdownMenuLink">
                @foreach($companies as $group)
                    @if($group->first()->level==1)
                        @foreach($group as $com)
                            @if(in_array($com->id,$userCompanies))
                                <a class="dropdown-item" href="{{ route('companies.switch', $com->id) }}">
                                    <i class="fas fa-building"></i>
                                    <span data-toggle="tooltip" data-placement="top" title="{{$com->name}}"
                                          data-original-title="{{$com->name}}">{{ Str::limit($com->name, 50) }}</span>
                                </a>
                            @endif
                        @endforeach
                    @else
                        @foreach($group as $com)
                            @if(array_intersect($userCompanies, $com->children()->get()->pluck('id')->toArray()))
                                <div class="dropdown-multilevel">
                                    <a class="dropdown-item" @if(in_array($com->id,$userCompanies))  href="{{ route('companies.switch', $com->id) }}" @else href="#" @endif>
                                        {{Str::limit($com->name, 50)}}
                                    </a>
                                    <div class="dropdown-menu">
                                        @foreach($com->children()->get() as $child)
                                            @if(in_array($child->id,$userCompanies))
                                                <a href="{{ route('companies.switch', $child->id) }}" class="dropdown-item">{{Str::limit($child->name, 50)}}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        @endif
    </div>
    <div>
        <span class="ml-2 text-white fs-xl">{{ session('module', '') }}</span>
    </div>
    <div class="ml-auto d-flex">
        <div>
            <a href="#" class="header-icon" data-toggle="dropdown" title="{{ trans('general.modules') }}">
                <i class="fas fa-th"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-animated w-auto h-auto">
                <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top">
                    <h4 class="m-0 text-center color-white">
                        {{ trans('general.modules') }}
                        <small class="mb-0 opacity-80">{{ trans('general.shortcut') }}</small>
                    </h4>
                </div>
                <div class="custom-scroll h-100">
                    <ul class="app-list">
                        @if(Gate::check('strategy-view') || Gate::check('strategy-manage') )
                            <li>
                                <a href="{{ route('strategy.home') }}" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-2 icon-stack-3x color-fusion-600"></i>
                                        <i class="base-3 icon-stack-2x color-fusion-700"></i>
                                        <i class="ni ni-settings icon-stack-1x text-white fs-lg"></i>
                                    </span>
                                    <span class="app-list-name">
                                        {{ trans('general.module_strategy') }}
                                    </span>
                                </a>
                            </li>
                        @endif
                        @if(Gate::check('project-view') || Gate::check('project-manage') )
                            <li>
                                <a href="{{ route('projects.index') }}" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-7 icon-stack-3x color-info-500"></i>
                                        <i class="base-7 icon-stack-2x color-info-700"></i>
                                        <i class="ni ni-graph icon-stack-1x text-white"></i>
                                    </span>
                                    <span class="app-list-name">
                                        {{ trans('general.module_projects') }}
                                    </span>
                                </a>
                            </li>
                        @endif
                        @if(Gate::check('budget-view') || Gate::check('budget-manage') )
                            <li>
                                <a href="{{ route('budget.home') }}" class="app-list-item hover-white">
                                    <span class="icon-stack">
                                        <i class="base-4 icon-stack-3x color-danger-500"></i>
                                        <i class="base-4 icon-stack-1x color-danger-400"></i>
                                        <i class="fas fa-dollar-sign icon-stack-1x text-white"></i>
                                    </span>
                                    <span class="app-list-name">
                                        {{ trans('general.module_budget') }}
                                    </span>
                                </a>
                            </li>
                        @endif
                        @if(Gate::check('poa-view') || Gate::check('poa-manage') )
                            <li>
                                <a href="{{ route('poa.poas') }}" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-14 icon-stack-3x color-info-500"></i>
                                    <i class="base-7 icon-stack-2x color-info-700"></i>
                                    <i class="fas fa-sliders-v icon-stack-1x text-white"></i>
                                </span>
                                    <span class="app-list-name">
                                    {{ trans('general.poa') }}
                                </span>
                                </a>
                            </li>
                        @endif
                        @if(Gate::check('administrative-view') || Gate::check('administrative-manage') )
                            <li>
                                <a href="{{ route('admin.administrativeTasks') }}" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="fas fa-address-card"></i>
                                </span>
                                    <span class="app-list-name">
                                    {{ trans('general.administrative_tasks') }}
                                </span>
                                </a>
                            </li>
                        @endif
                        @if(Gate::check('process-view') || Gate::check('process-manage') )
                            <li>
                                <a href="{{ route('processes.index') }}" class="app-list-item hover-white">
                                 <span class="icon-stack">
                                 <i class="fa fa-spinner color-warning-500"></i>
                                  </span>
                                    <span class="app-list-name">
                                    {{ trans_choice('general.module_process',2) }}
                                    </span>
                                </a>
                            </li>
                        @endif
                        @if(Gate::check('admin-view') || Gate::check('admin-manage') )
                            <li>
                                <a href="{{ route('companies.index') }}" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-9 icon-stack-3x color-success-400"></i>
                                    <i class="base-2 icon-stack-2x color-success-500"></i>
                                    <i class="ni ni-shield icon-stack-1x text-white"></i>
                                </span>
                                    <span class="app-list-name">
                                    {{ trans('general.module_admin') }}
                                </span>
                                </a>
                            </li>
                        @endcan
                        @if(Gate::check('audit-view') || Gate::check('audit-manage') )
                            <li>
                                <a href="{{ route('audit.home') }}" class="app-list-item hover-white">
                                                        <span class="icon-stack">
                                                            <i class="base-18 icon-stack-3x color-info-700"></i>
                                                            <span class="position-absolute pos-top pos-left pos-right color-white fs-md mt-2 fw-400">28</span>
                                                        </span>
                                    <span class="app-list-name">
                                                            {{ trans('general.module_audit') }}
                                                        </span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <livewire:common.header-notifications :user="$user"/>
        <div>
            <a href="#" data-toggle="dropdown" title="{{ $user->name }}"
               class="header-icon d-flex align-items-center justify-content-center ml-2">
                @if (is_object($user->picture))
                    <img src="{{ Storage::url($user->picture->id) }}" class="profile-image rounded-circle"
                         alt="{{ $user->name }}">
                @else
                    <img src="{{ asset_cdn("img/user.svg") }}" class="profile-image rounded-circle"
                         alt="{{ $user->name }}">
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                    <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                        <span class="mr-2">
                            @if (is_object($user->picture))
                                <img src="{{ Storage::url($user->picture->id) }}" class="rounded-circle profile-image" alt="{{ $user->name }}">
                            @else
                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle profile-image" alt="{{ $user->name }}">
                            @endif
                        </span>
                        <div class="info-card-text">
                            <div class="fs-lg text-truncate text-truncate-lg">{{ $user->name }}</div>
                            <span class="text-truncate text-truncate-md opacity-80">{{ $user->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider m-0"></div>
                <a href="{{ route('profile', \Illuminate\Support\Facades\Auth::user()->id) }}" class="dropdown-item">
                    <span>{{ trans('general.user_profile') }} <i class="fas fa-user float-right color-primary-500"></i></span>
                </a>
                <div class="dropdown-divider m-0"></div>
                <div class="dropdown-divider m-0"></div>
                <a class="dropdown-item fw-500 pt-3 pb-3" href="{{ route('azure.logout') }}">
                    <span>{{ trans('auth.logout') }} <i class="fas fa-sign-out float-right color-primary-500"></i></span>
                </a>
            </div>
        </div>
    </div>
</header>
