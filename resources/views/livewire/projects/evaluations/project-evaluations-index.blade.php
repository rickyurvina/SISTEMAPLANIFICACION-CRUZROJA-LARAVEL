<div>
    <div class="p-2">
        <div class="d-flex flex-row-reverse">
            @can('manage-evaluations-project')
                <div>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#project-create-evaluation"
                       class="btn btn-success btn-sm mb-2 mr-2 ml-auto">
                        {{ trans('general.create') }} {{__('general.evaluation')}}
                    </a>
                </div>
            @endcan
            <div class="mr-auto">
                <button class="btn btn-primary btn-sm" wire:click="$set('viewGrid',1)"><i class="fas fa-list fa-lg"></i>
                </button>
                <button class="btn btn-primary btn-sm" wire:click="$set('viewGrid',0)"><i class="fas fa-th fa-lg"></i>
                </button>
            </div>
        </div>
        <div class="panel-1" style="display: contents">
            <h2 class="text-center text-info fs-2x fw-700 mt-2 mb-2">{{trans('general.evaluations')}}</h2>
            <hr>
            <div class="input-group bg-white shadow-inset-2 w-100 mr-2 mb-2">
                <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                       placeholder="{{ trans('general.filter') . ' ' . trans('general.evaluation') }} ..."
                       wire:model="search">
                <div class="input-group-append">
                <span class="input-group-text bg-transparent border-left-0">
                    <i class="fal fa-search"></i>
                </span>
                </div>
            </div>
            @if($evaluations->count()>0)
                @if($viewGrid===1)
                    <div class="table-responsive">
                        <table class="table table-light table-hover">
                            <thead>
                            <tr>
                                <th class="w-auto table-th text-center">@sortablelink('background', trans('general.name'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('cause', trans('general.variables'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('methodology', trans('general.methodology'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('phase', trans('general.phase'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('state', trans('general.state'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('systematization', trans('general.systematization'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('user', trans('general.user'))</th>
                                <th class="w-10 table-th text-center">{{ __('general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($evaluations as $item)
                                <tr class="tr-hover">
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail>{{$item->name}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <table class="table table-light table-hover">
                                                <tbody>
                                                @foreach($item->variables as $variable)
                                                    <tr class="text-center">
                                                        <td>{{$variable}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail> {{$item->methodology}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <span class="badge badge- {{ \App\Models\Projects\ProjectEvaluation::PHASES_BG[$item->phase] }} badge-pill">{{ $item->phase }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <span class="badge badge- {{ \App\Models\Projects\ProjectEvaluation::STATES_BG[$item->state] }} badge-pill">{{ $item->state }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail> {{$item->systematization}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="" @if($item->user) data-toggle="tooltip" data-placement="top"
                                                 title="{{ $item->user->getFullName() }}" data-original-title="{{ $item->user->getFullName() }}" @endif>
                                                <div class="dropdown-item">
                                                            <span class="mr-2">
                                                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                            </span>
                                                    <span class="pt-1">{{ $item->user->getFullName() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        @can('manage-evaluations-project')
                                            <a href="javascript:void(0)"
                                               data-toggle="modal"
                                               data-target="#project-edit-evaluation"
                                               data-item-id="{{$item->id}}">
                                                <i class="fas fa-edit mr-1 text-info"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Editar"></i>
                                            </a>
                                            <x-delete-link action="{{ route('projects.delete_evaluation', $item->id) }}" id="{{ $item->id }}"/>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <x-pagination :items="$evaluations"/>

                    </div>
                @else
                    <div class="row">
                        <div class="col-4 text-center"><h2 class="text-center text-success fs-2x fw-700 mt-2 mb-2">{{trans('general.initial')}}</h2></div>
                        <div class="col-4 text-center"><h2 class="text-center text-danger fs-2x fw-700 mt-2 mb-2">{{trans('general.intermediate')}}</h2></div>
                        <div class="col-4 text-center"><h2 class="text-center text-danger fs-2x fw-700 mt-2 mb-2">{{trans('general.final')}}</h2></div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            @foreach($evaluations->where('phase',\App\Models\Projects\ProjectEvaluation::INITIAL_CONST) as $item)
                                <div id="cp-2" class="card border border-fusion-50 mb-2">
                                    <div class="card-header bg-fusion-50">{{trans_choice('general.project',1)}} {{$item->project->name}}</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <x-label-section>{{__('general.name')}}</x-label-section>
                                                <p>
                                                    {{$item->name}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.variables')}}</x-label-section>
                                                <table class="table table-light table-hover">
                                                    <tbody>
                                                    @foreach($item->variables as $variable)
                                                        <tr class="text-center">
                                                            <td>{{$variable}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.methodology')}}</x-label-section>
                                                <p>
                                                    {{$item->methodology}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.systematization')}}</x-label-section>
                                                <p>
                                                    {{$item->systematization}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex flex-wrap">
                                                    <x-label-section>{{__('general.user')}}</x-label-section>
                                                    <div class="" @if($item->user) data-toggle="tooltip" data-placement="top"
                                                         title="{{ $item->user->getFullName() }}" data-original-title="{{ $item->user->getFullName() }}" @endif>
                                                        <div class="dropdown-item">
                                                                                    <span class="mr-2">
                                                                                        <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                                                    </span>
                                                            <span class="pt-1">{{ $item->user->getFullName() }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.phase')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\ProjectEvaluation::PHASES_BG[$item->phase] }} badge-pill">{{ $item->phase }}</span>

                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.state')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\ProjectEvaluation::STATES_BG[$item->state] }} badge-pill">{{ $item->state }}</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 bg-fusion-50">
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex flex-wrap">
                                                {{$item->created_at->diffForHumans()}}-
                                                {{$item->company->name}}
                                            </div>
                                            @can('manage-evaluations-project')
                                                <div class="ml-auto">
                                                    <a href="#project-edit-evaluation"
                                                       data-toggle="modal"
                                                       data-target="#project-edit-evaluation"
                                                       data-item-id="{{$item->id}}">
                                                        <i class="fas fa-edit mr-1 text-info"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="Editar"></i>
                                                    </a>
                                                    <x-delete-link action="{{ route('projects.delete_evaluation', $item->id) }}" id="{{ $item->id }}"/>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-4">
                            @foreach($evaluations->where('phase', \App\Models\Projects\ProjectEvaluation::INTERMEDIATE_CONST ) as $item)
                                <div id="cp-2" class="card border border-fusion-50 mb-2">
                                    <div class="card-header bg-fusion-50">{{trans_choice('general.project',1)}} {{$item->project->name}}</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <x-label-section>{{__('general.name')}}</x-label-section>
                                                <p>
                                                    {{$item->name}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.variables')}}</x-label-section>
                                                <table class="table table-light table-hover">
                                                    <tbody>
                                                    @foreach($item->variables as $variable)
                                                        <tr class="text-center">
                                                            <td>{{$variable}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.methodology')}}</x-label-section>
                                                <p>
                                                    {{$item->methodology}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.systematization')}}</x-label-section>
                                                <p>
                                                    {{$item->systematization}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex flex-wrap">
                                                    <x-label-section>{{__('general.user')}}</x-label-section>
                                                    <div class="" @if($item->user) data-toggle="tooltip" data-placement="top"
                                                         title="{{ $item->user->getFullName() }}" data-original-title="{{ $item->user->getFullName() }}" @endif>
                                                        <div class="dropdown-item">
                                                                                    <span class="mr-2">
                                                                                        <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                                                    </span>
                                                            <span class="pt-1">{{ $item->user->getFullName() }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.phase')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\ProjectEvaluation::PHASES_BG[$item->phase] }} badge-pill">{{ $item->phase }}</span>

                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.state')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\ProjectEvaluation::STATES_BG[$item->state] }} badge-pill">{{ $item->state }}</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 bg-fusion-50">
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex flex-wrap">
                                                {{$item->created_at->diffForHumans()}}-
                                                {{$item->company->name}}
                                            </div>
                                            <div class="ml-auto">
                                                @can('manage-evaluations-project')
                                                    <a href="#project-edit-evaluation"
                                                       data-toggle="modal"
                                                       data-target="#project-edit-evaluation"
                                                       data-item-id="{{$item->id}}">
                                                        <i class="fas fa-edit mr-1 text-info"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="Editar"></i>
                                                    </a>
                                                    <x-delete-link action="{{ route('projects.delete_evaluation', $item->id) }}" id="{{ $item->id }}"/>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-4">
                            @foreach($evaluations->where('phase', \App\Models\Projects\ProjectEvaluation::FINAL_CONST ) as $item)
                                <div id="cp-2" class="card border border-fusion-50 mb-2">
                                    <div class="card-header bg-fusion-50">{{trans_choice('general.project',1)}} {{$item->project->name}}</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <x-label-section>{{__('general.name')}}</x-label-section>
                                                <p>
                                                    {{$item->name}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.variables')}}</x-label-section>
                                                <table class="table table-light table-hover">
                                                    <tbody>
                                                    @foreach($item->variables as $variable)
                                                        <tr class="text-center">
                                                            <td>{{$variable}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.methodology')}}</x-label-section>
                                                <p>
                                                    {{$item->methodology}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.systematization')}}</x-label-section>
                                                <p>
                                                    {{$item->systematization}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex flex-wrap">
                                                    <x-label-section>{{__('general.user')}}</x-label-section>
                                                    <div class="" @if($item->user) data-toggle="tooltip" data-placement="top"
                                                         title="{{ $item->user->getFullName() }}" data-original-title="{{ $item->user->getFullName() }}" @endif>
                                                        <div class="dropdown-item">
                                                                                    <span class="mr-2">
                                                                                        <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                                                    </span>
                                                            <span class="pt-1">{{ $item->user->getFullName() }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.phase')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\ProjectEvaluation::PHASES_BG[$item->phase] }} badge-pill">{{ $item->phase }}</span>

                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.state')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\ProjectEvaluation::STATES_BG[$item->state] }} badge-pill">{{ $item->state }}</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 bg-fusion-50">
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex flex-wrap">
                                                {{$item->created_at->diffForHumans()}}-
                                                {{$item->company->name}}
                                            </div>
                                            <div class="ml-auto">
                                                @can('manage-evaluations-project')
                                                    <a href="#project-edit-evaluation"
                                                       data-toggle="modal"
                                                       data-target="#project-edit-evaluation"
                                                       data-item-id="{{$item->id}}">
                                                        <i class="fas fa-edit mr-1 text-info"
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="Editar"></i>
                                                    </a>
                                                    <x-delete-link action="{{ route('projects.delete_evaluation', $item->id) }}" id="{{ $item->id }}"/>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <x-empty-content>
                    <x-slot name="title">
                        {{trans('general.there_are_no_evaluations')}}
                    </x-slot>
                </x-empty-content>
            @endif
        </div>
    </div>
</div>
