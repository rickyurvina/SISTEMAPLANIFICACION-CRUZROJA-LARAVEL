<div class="panel-container show">
    <div class="card-header pr-2 d-flex flex-wrap w-100">
        <div class="d-flex position-relative mr-auto w-100">
            <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem" wire:target="search" wire:loading></i>
            <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem" wire:loading.remove></i>
            <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                   placeholder="Buscar...">
        </div>
    </div>
    @if($projects->count()>0)
        <div class="card">
            <div class="table-responsive">
                <table class="table  m-0">
                    <thead class="bg-primary-50">
                    <tr>
                        <th class="w-10">
                            <a wire:click.prevent="sortBy('code')" role="button" href="#">
                                {{trans('general.code')}}
                                <x-sort-icon sortDirection="{{$sortDirection}}" sortField="code"
                                             field="{{$sortField}}"></x-sort-icon>
                            </a>
                        </th>
                        <th class="w-20">
                            <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                {{trans('general.name')}}
                                <x-sort-icon sortDirection="{{$sortDirection}}" sortField="name"
                                             field="{{$sortField}}"></x-sort-icon>
                            </a>
                        </th>
                        <th class="w-10">
                            <a wire:click.prevent="sortBy('type')" role="button" href="#">
                                {{trans('general.type')}}
                                <x-sort-icon sortDirection="{{$sortDirection}}" sortField="type"
                                             field="{{$sortField}}"></x-sort-icon>
                            </a>
                        </th>
                        <th class="w-10">
                            <a wire:click.prevent="sortBy('responsible_id')" role="button" href="#">
                                {{__('general.responsible')}}
                                <x-sort-icon sortDirection="{{$sortDirection}}" sortField="responsible_id"
                                             field="{{$sortField}}"></x-sort-icon>
                            </a>
                        </th>
                        <th class="w-10">
                            <a wire:click.prevent="sortBy('location_id')" role="button" href="#">
                                {{ trans('general.location') }}
                                <x-sort-icon sortDirection="{{$sortDirection}}" sortField="location_id"
                                             field="{{$sortField}}"></x-sort-icon>
                            </a>
                        </th>
                        <th class="w-15">
                            <a wire:click.prevent="sortBy('start_date')" role="button" href="#">
                                {{ trans('general.start_date') }}
                                <x-sort-icon sortDirection="{{$sortDirection}}" sortField="start_date"
                                             field="{{$sortField}}"></x-sort-icon>
                            </a>
                        </th>
                        <th class="w-15">
                            <a wire:click.prevent="sortBy('end_date')" role="button" href="#">
                                {{ trans('general.end_date') }}
                                <x-sort-icon sortDirection="{{$sortDirection}}" sortField="end_date"
                                             field="{{$sortField}}"></x-sort-icon>
                            </a>
                        </th>
                        <th class="w-5">
                            <a wire:click.prevent="sortBy('phase')" role="button" href="#">
                                {{ trans('general.phase') }}
                                <x-sort-icon sortDirection="{{$sortDirection}}" sortField="phase"
                                             field="{{$sortField}}"></x-sort-icon>
                            </a>
                        </th>
                        <th class="w-5">
                            <a wire:click.prevent="sortBy('status')" role="button" href="#">
                                {{ trans('general.status') }}
                                <x-sort-icon sortDirection="{{$sortDirection}}" sortField="status"
                                             field="{{$sortField}}"></x-sort-icon>
                            </a>
                        </th>
                        <th class="color-primary-500 w-20">{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $index=>$item)
                        @if(in_array($companyActive,$item->subsidiaries->pluck('company_id')->toArray()) )
                            <tr wire:key="{{time().$index}}">
                                <td>{{$item->code}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{trans('general.'.$item->type)}}</td>
                                @isset($item->responsible->name)
                                    <td>{{ $item->responsible->getFullName() ??''}}</td>
                                @else
                                    <td class="text-center"><i class="fal fa-minus color-danger-700 fs-2x"></i></td>
                                @endisset
                                @if($item->locations->count()>0)
                                    <td>

                                        {{$item->locations->first() ? $item->locations->first()->getPath() :''}}
                                    </td>
                                @else
                                    <td class="text-center"><i class="fal fa-minus color-danger-700 fs-2x"></i></td>

                                @endif
                                <td>{{$item->start_date? $item->start_date->format('j F, Y'):''}}</td>
                                <td>{{$item->end_date?$item->end_date->format('j F, Y'):''}}</td>
                                <td>
                                    <span>{{ $item->phase->label() }}</span>
                                </td>
                                @if($item->type!=\App\Models\Projects\Project::TYPE_INTERNAL_DEVELOPMENT)
                                    <td>
                                        <span class="badge {{ $item->status->color() }} badge-pill">{{ $item->status->label() }}</span>
                                    </td>
                                @else
                                    <td class="text-center"><i class="fal fa-minus color-danger-700 fs-2x"></i></td>
                                @endif
                                @if( user()->can('project-manage')||in_array($companyActive,$item->subsidiaries->pluck('company_id')->toArray()))
                                    <td>
                                        <div class="frame-wrap">
                                            <div class="d-flex justify-content-start">
                                                @if($item->company_id===$companyActive || in_array($companyActive,$item->subsidiaries->pluck('company_id')->toArray()))
                                                    @if($item->type == \App\Models\Projects\Project::TYPE_MISSIONARY_PROJECT || $item->type == \App\Models\Projects\Project::TYPE_EMERGENCY)
                                                        @if($item->phase instanceof \App\States\Project\StartUp)
                                                            @if(user()->can('project-view')||user()->can('project-manage')||
                                                                in_array($companyActive,$item->subsidiaries->pluck('company_id')->toArray()))
                                                                <div class="p-2">
                                                                    <a href="{{ route('projects.showIndex', $item->id) }}"
                                                                       aria-expanded="false"
                                                                       data-toggle="tooltip" data-placement="top" title=""
                                                                       data-original-title="Ficha del Proyecto">
                                                                        <i class="fas fa-eye text-info"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="p-2">
                                                                    <a href="{{ route('projects.showReferentialBudget', $item->id) }}"
                                                                       aria-expanded="false"
                                                                       data-toggle="tooltip" data-placement="top" title=""
                                                                       data-original-title="Presupuesto del Proyecto">
                                                                        <i class="fas fa-dollar-sign text-info"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="p-2">
                                                                <a href="{{ route('projects.activities_results', $item->id) }}"
                                                                   aria-expanded="false"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="Actividades">
                                                                    <i class="fas fa-arrow-alt-from-top text-info"></i>
                                                                </a>
                                                            </div>
                                                            <div class="p-2">
                                                                <a href="{{ route('projects.activities', $item->id) }}"
                                                                   aria-expanded="false"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title=Cronograma>
                                                                    <i class="fas fa-analytics text-info"></i>
                                                                </a>
                                                            </div>
                                                            @if($item->hasTransaction())
                                                                <div class="p-2">
                                                                    <a href="{{ route('projects.budgetDocumentReport', $item->id) }}"
                                                                       aria-expanded="false"
                                                                       data-toggle="tooltip" data-placement="top" title=""
                                                                       data-original-title=Presupuesto>
                                                                        <i class="fas fa-dollar-sign text-success mr-1"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        <div class="p-2">
                                                            <a href="{{ route('projects.logic-frame', $item->id) }}"
                                                               aria-expanded="false"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="Marco Lógico">
                                                                <i class="fas fa-file-archive text-info"></i>
                                                            </a>
                                                        </div>
                                                        <div class="p-2">
                                                            <a href="{{ route('projects.showSummary', $item->id) }}"
                                                               aria-expanded="false"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="Resumen del Proyeccto">
                                                                <i class="fas fa-folder-open text-info"></i>
                                                            </a>
                                                        </div>
                                                        <div class="p-2">
                                                            <a href="{{ route('projects.files', $item->id) }}"
                                                               aria-expanded="false"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="Archivos">
                                                                <i class="fas fa-paperclip text-info"></i>
                                                            </a>
                                                        </div>
                                                        <div class="p-2">
                                                            @if( user()->can('project-manage'))
                                                                <button class="border-0 bg-transparent"
                                                                        wire:click="$emit('deleteProject', '{{ $item->id }}')"
                                                                        data-toggle="tooltip"
                                                                        data-placement="top" title="Eliminar"
                                                                        data-original-title="Eliminar"><i
                                                                            class="fas fa-trash text-danger"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    @else
                                                        @if(user()->can('project-view')||user()->can('project-manage')||
                                                               in_array($companyActive,$item->subsidiaries->pluck('company_id')->toArray()))
                                                            <div class="p-2">
                                                                <a href="{{ route('projects.showIndexInternal', $item->id) }}"

                                                                   aria-expanded="false"
                                                                   data-toggle="tooltip" data-placement="top" title=""
                                                                   data-original-title="Ficha del Proyecto">
                                                                    <i class="fas fa-eye text-info"></i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="p-2">
                                                            <a href="{{ route('projects.activities_resultsInternal', $item->id) }}"
                                                               aria-expanded="false"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="Actividades">
                                                                <i class="fas fa-arrow-alt-from-top text-info"></i>
                                                            </a>
                                                        </div>
                                                        <div class="p-2">
                                                            <a href="{{ route('projects.showReferentialBudgetInternal', $item->id) }}"
                                                               aria-expanded="false"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="Presupuesto del Proyecto">
                                                                <i class="fas fa-dollar-sign text-info"></i>
                                                            </a>
                                                        </div>
                                                        <div class="p-2">
                                                            <a href="{{ route('projects.showSummaryInternal', $item->id) }}"
                                                               aria-expanded="false"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="Resumen del Proyeccto">
                                                                <i class="fas fa-folder-open  text-info"></i>
                                                            </a>
                                                        </div>
                                                        <div class="p-2">
                                                            <a href="{{ route('projects.filesInternal', $item->id) }}"
                                                               aria-expanded="false"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="Archivos">
                                                                <i class="fas fa-paperclip text-info"></i>
                                                            </a>
                                                        </div>
                                                        <div class="p-2">
                                                            @if( user()->can('project-manage'))
                                                                <button class="border-0 bg-transparent"
                                                                        wire:click="$emit('deleteProject', '{{ $item->id }}')"
                                                                        data-toggle="tooltip"
                                                                        data-placement="top" title="Eliminar"
                                                                        data-original-title="Eliminar"><i
                                                                            class="fas fa-trash text-danger"></i>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @else
                                                    @if($item->phase instanceof \App\States\Project\Implementation && $item->status instanceof \App\States\Project\Execution)
                                                        <div class="p-2">
                                                            <a href="{{ route('projects.activities_results', $item->id) }}"
                                                               aria-expanded="false"
                                                               data-toggle="tooltip" data-placement="top" title=""
                                                               data-original-title="Actividades">
                                                                <i class="fas fa-arrow-alt-from-top text-info"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <x-pagination :items="$projects"/>
            </div>
        </div>
    @else
        <x-empty-content>
            <x-slot name="title">
                No existen proyectos
            </x-slot>
        </x-empty-content>
    @endif
</div>
