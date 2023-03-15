<div>
    <div class="d-flex mb-3">
        <div class="input-group bg-white shadow-inset-2 w-25 mr-2">
            <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                   placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.learned_lessons', 2) }} ..."
                   wire:model="search">
            <div class="input-group-append">
                <span class="input-group-text bg-transparent border-left-0">
                    <i class="fal fa-search"></i>
                </span>
            </div>
        </div>

        @if(count($projects) > 0)
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle @if(count($selectedProjects) > 0) filtered @endif"
                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ trans_choice('general.project',2)}}
                    @if(count($selectedProjects) > 0)
                        <span class="badge bg-white ml-2">{{ count($selectedProjects) }}</span>
                    @endif
                </button>
                <div class="dropdown-menu" style="min-width: 30rem !important;">
                    @foreach($projects as $project)
                        <div class="dropdown-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="i-program-{{ $project['id'] }}" wire:model="selectedProjects"
                                       value="{{ $project['id'] }}">
                                <label class="custom-control-label"
                                       for="i-program-{{ $project['id'] }}">{{ strlen($project['name'])>40? substr($project['name'], 0,40).'...': $project['name']  }}</label>
                            </div>
                        </div>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-item">
                        <span wire:click="$set('selectedProjects', [])">{{ trans('general.delete_selection') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if(count($selectedProjects) > 0 || $search != '')
            <a class="btn btn-outline-default ml-2" wire:click="clearFilters()">{{ trans('common.clean_filters') }}</a>
        @endif
    </div>
    <div class="d-flex flex-wrap align-items-start">
        <div class="w-100 pl-2">
            @if($lessons->count()>0)
                @if($viewGrid===1)
                    <div class="table-responsive">
                        <table class="table table-light table-hover">
                            <thead>
                            <tr>
                                <th class="w-auto table-th text-center">@sortablelink('project', trans_choice('general.project',1))</th>
                                <th class="w-auto table-th text-center">@sortablelink('background', trans('general.background'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('cause', trans('general.cause'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('learned_lesson', trans('general.learned_lesson'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('corrective_lesson', trans('general.corrective_lesson'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('evidences', trans('general.evidences'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('recommendations', trans('general.recommendations'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('responsable', trans('general.responsable'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('phase', trans('general.phase'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('state', trans('general.state'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('type', trans('general.type'))</th>
                                <th class="w-auto table-th text-center">@sortablelink('knowledge', trans('general.knowledge'))</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lessons as $item)
                                <tr class="tr-hover">
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail>{{$item->project->name}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail>{{$item->background}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail>{{$item->causes}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail> {{$item->learned_lesson}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center ">
                                            <x-label-detail>{{$item->corrective_lesson}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail> {{$item->evidences}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail> {{$item->recommendations}}</x-label-detail>
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
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <span class="badge badge- {{ \App\Models\Projects\Project::STATUS_BG[$item->state] }} badge-pill">{{ $item->state }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <span class="badge badge- {{ \App\Models\Projects\Project::PHASE_BG[$item->phase] }} badge-pill">{{ $item->phase }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <span class="badge badge- {{ \App\Models\Projects\Project::TYPES_BG[$item->type] }} badge-pill">{{ $item->type }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center ">
                                            <span class="badge {{ \App\Models\Projects\ProjectLearnedLessons::KNOWLEDGE_BG[$item->knowledge] }} badge-pill">{{ $item->knowledge }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <x-pagination :items="$lessons"/>
                    </div>
                @else
                    <div class="row">
                        <div class="col-6 text-center"><h2 class="text-center text-success fs-2x fw-700 mt-2 mb-2">{{trans('general.success_lessons')}}</h2></div>
                        <div class="col-6 text-center"><h2 class="text-center text-danger fs-2x fw-700 mt-2 mb-2">{{trans('general.danger_lessons')}}</h2></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            @foreach($lessons->where('type',\App\Models\Projects\Project::TYPE_SUCCESS) as $item)
                                <div id="cp-2" class="card border border-fusion-50 mb-2">
                                    <div class="card-header bg-fusion-50">{{trans_choice('general.project',1)}} {{$item->project->name}}</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <x-label-section>{{__('general.background')}}</x-label-section>
                                                <p>
                                                    {{$item->background}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.causes')}}</x-label-section>
                                                <p>
                                                    {{$item->causes}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.learned_lesson')}}</x-label-section>
                                                <p>
                                                    {{$item->learned_lesson}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.evidences')}}</x-label-section>
                                                <p>
                                                    {{$item->evidences}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.recommendations')}}</x-label-section>
                                                <p>
                                                    {{$item->recommendations}}
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
                                                <x-label-section>{{__('general.type')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\Project::TYPES_BG[$item->type] }} badge-pill w-100">{{ $item->type }}</span>
                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.state')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\Project::STATUS_BG[$item->state] }} badge-pill w-100">{{ $item->state }}</span>
                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.phase')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\Project::PHASE_BG[$item->phase] }} badge-pill w-100">{{ $item->phase }}</span>
                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.knowledge')}}</x-label-section>
                                                <span class="badge {{ \App\Models\Projects\ProjectLearnedLessons::KNOWLEDGE_BG[$item->knowledge] }} badge-pill  w-100">{{ $item->knowledge }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 bg-fusion-50">
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex flex-wrap">
                                                {{$item->created_at->diffForHumans()}}-
                                                {{$item->company->name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-6">
                            @foreach($lessons->where('type', \App\Models\Projects\Project::TYPE_DANGER ) as $item)
                                <div id="cp-2" class="card border border-fusion-50 mb-2">
                                    <div class="card-header bg-fusion-50">{{$item->project->name}}</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <x-label-section>{{__('general.background')}}</x-label-section>
                                                <p>
                                                    {{$item->background}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.causes')}}</x-label-section>
                                                <p>
                                                    {{$item->causes}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.learned_lesson')}}</x-label-section>
                                                <p>
                                                    {{$item->learned_lesson}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.evidences')}}</x-label-section>
                                                <p>
                                                    {{$item->evidences}}
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <x-label-section>{{__('general.recommendations')}}</x-label-section>
                                                <p>
                                                    {{$item->recommendations}}
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
                                                <x-label-section>{{__('general.type')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\Project::TYPES_BG[$item->type] }} badge-pill w-100">{{ $item->type }}</span>
                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.state')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\Project::STATUS_BG[$item->state] }} badge-pill w-100">{{ $item->state }}</span>
                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.phase')}}</x-label-section>
                                                <span class="badge badge- {{ \App\Models\Projects\Project::PHASE_BG[$item->phase] }} badge-pill w-100">{{ $item->phase }}</span>
                                            </div>
                                            <div class="col-3">
                                                <x-label-section>{{__('general.knowledge')}}</x-label-section>
                                                <span class="badge {{ \App\Models\Projects\ProjectLearnedLessons::KNOWLEDGE_BG[$item->knowledge] }} badge-pill  w-100">{{ $item->knowledge }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 bg-fusion-50">
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex flex-wrap">
                                                {{$item->created_at->diffForHumans()}}-
                                                {{$item->company->name}}
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
                        {{trans('general.there_are_no_lessons')}}
                    </x-slot>
                </x-empty-content>
            @endif
        </div>
    </div>

</div>
