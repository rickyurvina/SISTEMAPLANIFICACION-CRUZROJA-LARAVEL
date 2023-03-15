<div class="d-flex flex-wrap mt-2">
    <x-label-detail>{{ trans('general.responsible') }}</x-label-detail>
    <div class="detail" style="z-index: 99" wire:ignore>
        @if($project->phase instanceof  \App\States\Project\Planning)
            <livewire:components.dropdown-user :modelId="$task->id"
                                               modelClass="\App\Models\Projects\Activities\Task"
                                               field="owner_id"
                                               :user="$task->responsible"
                                               event="notifyUser"
                                               :usersAdd="$users"
                                               :key="time().$task->id"
            />
        @else
            {{$task->responsible ? $task->responsible->getFullName() : ''}}
        @endif
    </div>
</div>
<div class="d-flex flex-wrap mt-2">
    <x-label-detail>{{ trans('general.code') }}</x-label-detail>
    <div class="detail" wire:ignore>
        @if($project->phase instanceof  \App\States\Project\Planning)
            <livewire:components.input-inline-edit :modelId="$task->id"
                                                   class="\App\Models\Projects\Activities\Task"
                                                   field="code"
                                                   defaultValue="{{ $task->code }}"
                                                   :rules="$rule"
                                                   :code="true"
                                                   :key="time().$task->id"
            />
        @else
            {{$task->code}}
        @endif
    </div>
</div>
<div class="d-flex flex-wrap mt-2">
    <x-label-detail>{{ trans('general.start_date') }}</x-label-detail>
    <div class="detail">
        @if($project->phase instanceof  \App\States\Project\Planning)
            <livewire:components.date-inline-edit :modelId="$task->id"
                                                  class="\App\Models\Projects\Activities\Task"
                                                  field="start_date"
                                                  type="date"
                                                  event="refreshPage"
                                                  :rules="'required|before:'.$task->end_date"
                                                  defaultValue="{{$task->start_date? $task->start_date->format('j F, Y'): ''}}"
                                                  :key="time().$task->id"/>
        @else
            {{$task->start_date? $task->start_date->format('j F, Y'): ''}}
        @endif
    </div>
</div>
<div class="d-flex flex-wrap mt-2">
    <x-label-detail>{{ trans('general.end_date') }}</x-label-detail>
    <div class="detail">
        @if($project->phase instanceof  \App\States\Project\Planning)

            <livewire:components.date-inline-edit :modelId="$task->id"
                                                  class="\App\Models\Projects\Activities\Task"
                                                  field="end_date"
                                                  type="date"
                                                  event="refreshPage"
                                                  :rules="'required|after:'.$task->start_date"
                                                  defaultValue="{{$task->end_date ? $task->end_date->format('j F, Y'): ''}}"
                                                  :key="time().$task->id"/>
        @else
            {{$task->end_date? $task->end_date->format('j F, Y'): ''}}
        @endif
    </div>
</div>
<div class="d-flex flex-wrap mt-2">
    <x-label-detail>{{trans('general.status')}}</x-label-detail>
    <x-content-detail>{{ $task->status }}</x-content-detail>
</div>
<div class="d-flex flex-wrap mt-2">
    <label class="form-label" for="type_of_aggregation">{{ trans('indicators.indicator.type_of_aggregation') }}</label>
    <div class="btn-group w-100">
        <button class="btn btn-outline-secondary dropdown-toggle text-left"
                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if($typeOfAggregation != null)
                <i class="fas fa-{{ trans('indicators.indicator.TYPE_AGGREGATION_ICON_' . $typeOfAggregation) }}"></i>
                {{ trans('indicators.indicator.TYPE_AGGREGATION_' . $typeOfAggregation) }}
            @else
                {{ trans('general.select') }}
            @endif
        </button>

        <div class="dropdown-menu w-100">
            <div class="dropdown-item d-flex align-items-center justify-content-between"
                 wire:click="$set('typeOfAggregation', 'sum')">
                                                    <span><i class="fas fa-{{ trans('indicators.indicator.TYPE_AGGREGATION_ICON_sum') }}"></i>
                                                        {{ trans('indicators.indicator.TYPE_AGGREGATION_sum') }}</span>
                @if($typeOfAggregation == 'sum')
                    <i class="fas fa-check text-success"></i>
                @endif
            </div>
            <div class="dropdown-item d-flex align-items-center justify-content-between"
                 wire:click="$set('typeOfAggregation', 'ave')">
                                                    <span><i class="fas fa-{{ trans('indicators.indicator.TYPE_AGGREGATION_ICON_ave') }}"></i>
                                                        {{ trans('indicators.indicator.TYPE_AGGREGATION_ave') }}</span>
                @if($typeOfAggregation == 'ave')
                    <i class="fas fa-check text-success"></i>
                @endif
            </div>
        </div>
    </div>
</div>