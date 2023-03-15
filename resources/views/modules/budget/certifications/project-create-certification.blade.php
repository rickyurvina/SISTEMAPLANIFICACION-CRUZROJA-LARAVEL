@if($viewProject)
    @if(count($projects) > 0)
        <div class="btn-group">
            <button class="btn btn-outline-secondary dropdown-toggle @if(count($selectedProjects) > 0) filtered @endif"
                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ trans_choice('general.project', 2) }}
                @if(count($selectedProjects) > 0)
                    <span class="badge bg-white ml-2">{{ count($selectedProjects) }}</span>
                @endif
            </button>
            <div class="dropdown-menu">
                @foreach($projects as $project)
                    <div class="dropdown-item">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   id="i-program-{{ $project['id'] }}" wire:model="selectedProjects"
                                   value="{{ $project['id'] }}">
                            <label class="custom-control-label"
                                   for="i-program-{{ $project['id'] }}">{{ $project['name'] }}</label>
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
        <button type="button" class="btn btn-outline-default ml-2"
                wire:click="clearFilters">{{ trans('common.clean_filters') }}</button>
    @endif

    @if( isset($activitiesProject)  && $activitiesProject->count()>0)
        <div class="d-flex align-items-start">
            <div class="w-100">
                <div class="table-responsive">
                    <table class="table table-light table-hover">
                        <thead>
                        <tr>
                            <th class="w-15">@sortablelink('planDetail.name', trans_choice('general.programs', 1))</th>
                            <th class="w-15">@sortablelink('indicator.name', trans_choice('general.indicators', 1))</th>
                            <th class="w-25">@sortablelink('name', __('poa.name'))</th>
                            <th class="w-25">Saldo</th>
                            <th class="w-15">@sortablelink('responsible.name', __('general.responsible'))</th>
                            <th class="w-25">{{trans('general.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activitiesProject as $item)
                            <tr class="tr-hover" wire:loading.class.delay="opacity-50">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span>{{ $item->project->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->indicator ? $item->indicator->name: 'Sin Indicador Asociado' }}</td>
                                <td>
                                    {{ $item->code ? $item->code . ' - ':'' }}{{ $item->text }}
                                </td>
                                <td>{{ $item->getTotalBudget($transactionPr)}}</td>
                                <td>
                                    @if($item->responsible)
                                        <span class="mr-2">
                                        <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">
                                    </span>
                                        {{ $item->responsible->name }}
                                    @else
                                        <span class="mr-2">
                                        <img src="{{ asset_cdn('img/user_off.png') }}" class="rounded-circle width-1">
                                    </span>
                                        {{ trans('general.not_assigned') }}
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="mr-2" wire:click="loadProjectActivity({{$item->id}})"
                                       data-toggle="tooltip"
                                       data-placement="top" title=""
                                       data-original-title="{{trans('general.create')}}{{trans_choice('general.certifications',1)}}">
                                        <i class="fas fa-check-circle color-success-700"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endif

@if($viewProjectActivity)
    @include('modules.budget.certifications.create.header-projects')
    @if($expensesProject->count()>0)
        <div class="table-responsive">
            <table class="table table-light table-hover">
                @include('modules.budget.certifications.create.header-table-form')
                <tbody>
                @foreach($expensesProject as $item)
                    @include('modules.budget.certifications.create.body-table-form')
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif
