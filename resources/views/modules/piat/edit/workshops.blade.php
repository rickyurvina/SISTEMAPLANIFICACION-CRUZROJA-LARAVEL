<form wire:submit.prevent="submitPlan()" method="post" autocomplete="off">
    @if(!$is_terminated)
        <x-label-section>{{ trans('poa.piat_matrix_activity_plan') }}</x-label-section>
        <div class="section-divider"></div>
        <div class="d-flex flex-wrap align-items-center justify-content-between w-65 mr-2">
            <div class="form-group w-50 pr-1 mb-0 required">
                <label class="form-label fw-700"
                       for="task">{{ trans('poa.piat_matrix_create_placeholder_task') }}</label>
                <input type="text" id="task" class="form-control"
                       placeholder="{{ trans('poa.piat_matrix_create_placeholder_task') }}"
                       wire:model.defer="taskPlan">
                <div class="invalid-feedback" style="display: block;">{{ $errors->first('taskPlan') }}</div>
            </div>
            @if($responsibles)
                <div class="form-group w-50">
                    <label class="form-label fw-700"
                           for="responsablePlan">{{ trans('poa.piat_matrix_create_placeholder_responsable') }}</label>
                    <select wire:model.defer="responsablePlan" class="custom-select bg-transparent">
                        <option value="{{ $responsablePlan }}" selected>
                            {{ trans('poa.piat_matrix_create_placeholder_responsable') }}
                        </option>
                        @foreach ($responsibles as $item)
                            @if($item->user_id)
                                <option value="{{ $item->id }}">{{ $item->user->getFullName() }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <div class="invalid-feedback" style="display: block;">{{ $errors->first('responsablePlan') }}</div>
                </div>
            @endif
        </div>
        <div class="d-flex flex-wrap align-items-center justify-content-between mr-2">
            <div class="form-group w-25 pr-1 mb-0 required">
                <label class="form-label fw-700"
                       for="datePlan">{{ trans('poa.piat_matrix_create_placeholder_date') }}</label>
                <input type="date" wire:model.defer="datePlan" id="datePlan" class="form-control"
                />
                <div class="invalid-feedback" style="display: block;">{{ $errors->first('datePlan') }}</div>
            </div>
            <div class="form-group w-25 pr-1 mb-0 required">
                <label class="form-label fw-700"
                       for="endDatePlan">{{ trans('poa.piat_matrix_create_placeholder_date') }}</label>
                <input type="date" wire:model.defer="endDatePlan" id="endDatePlan" class="form-control"
                />
                <div class="invalid-feedback" style="display: block;">{{ $errors->first('endDatePlan') }}</div>
            </div>
            <div class="form-group w-25 mb-0">
                <label class="form-label fw-700 timepicker required"
                       for="initTimePlan">{{ trans('poa.piat_matrix_create_placeholder_initial_time') }}</label>
                <input type="time" wire:model.defer="initTimePlan" id="initTimePlan"
                       class="form-control"
                       placeholder="{{ trans('poa.piat_matrix_create_placeholder_initial_time') }}"/>
                <div class="invalid-feedback" style="display: block;">{{ $errors->first('initTimePlan') }}</div>
            </div>
            <div class="form-group w-25">
                <label class="form-label fw-700 timepicker required"
                       for="endTimePlan">{{ trans('poa.piat_matrix_create_placeholder_end_time') }}</label>
                <input type="time" wire:model.defer="endTimePlan" id="endTimePlan"
                       class="form-control"
                       placeholder="{{ trans('poa.piat_matrix_create_placeholder_end_time') }}"/>
                <div class="invalid-feedback" style="display: block;">{{ $errors->first('endTimePlan') }}</div>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
            <div class="card-footer text-muted py-2 text-center">
                <a wire:click="cleanThemeTask()" href="javascript:void(0);" class="btn btn-outline-secondary mr-1">
                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                </button>
            </div>
        </div>
    @endif
</form>
<div class="d-flex flex-wrap align-items-start">
    <div class="w-100 pl-2">
        <div class="table-responsive">
            <table class="table table-light table-hover">
                <thead>
                <tr>
                    <th class="w-auto">{{ __('poa.piat_matrix_create_placeholder_task') }}</th>
                    <th class="w-15">{{ __('poa.piat_matrix_create_placeholder_date') }}</th>
                    <th class="w-15">{{ __('general.end_date') }}</th>
                    <th class="w-10">{{ __('poa.piat_matrix_create_placeholder_initial_time') }}</th>
                    <th class="w-10">{{ __('poa.piat_matrix_create_placeholder_end_time') }}</th>
                    <th class="w-15">{{ __('poa.responsible') }}</th>
                    <th class="w-5"><a href="#">{{ trans('general.actions') }} </a></th>
                </tr>
                </thead>
                <tbody>
                @if($piatPlan)
                    @forelse($piatPlan as $index => $item)
                        <tr wire:key="{{time().$index.$item->id}}" wire:ignore>
                            <td>
                                @if(!$is_terminated)
                                    <div wire:key="{{time().$index}}" style="width: 250px; !important;" wire:ignore>
                                        <livewire:components.input-text :modelId="$item->id"
                                                                        class="\App\Models\Poa\Piat\PoaActivityPiatPlan"
                                                                        field="task"
                                                                        :rules="'required|max:255'"
                                                                        defaultValue="{{$item->task}}"
                                                                        :key="time().$item->id"/>
                                    </div>
                                @else
                                    <span>{{ $item->task }}</span>
                                @endif
                            </td>
                            <td>
                                @if(!$is_terminated)
                                    <livewire:components.date-inline-edit :modelId="$item->id"
                                                                          class="{{\App\Models\Poa\Piat\PoaActivityPiatPlan::class}}"
                                                                          field="date" type="date"
                                                                          :rules="'required|before:'.$item['end_date']"
                                                                          defaultValue="{{$item->date}}"
                                                                          :key="time().$item->id"/>
                                @else
                                    <span>{{ $item->date->format('j F, Y') }}</span>
                                @endif
                            </td>
                            <td>
                                @if(!$is_terminated)
                                    <livewire:components.date-inline-edit :modelId="$item->id"
                                                                          class="{{\App\Models\Poa\Piat\PoaActivityPiatPlan::class}}"
                                                                          field="end_date" type="date"
                                                                          :rules="'required|after:'.$item['date']"
                                                                          defaultValue="{{$item->end_date}}"
                                                                          :key="time().$item->id"/>
                                @else
                                    <span>{{ $item->end_date->format('j F, Y') }}</span>
                                @endif
                            </td>
                            <td>
                                @if(!$is_terminated)
                                    <livewire:components.input-inline-edit :modelId="$item->id"
                                                                           class="{{\App\Models\Poa\Piat\PoaActivityPiatPlan::class}}"
                                                                           field="initial_time" type="time"
                                                                           :rules="'required'"
                                                                           defaultValue="{{$item->initial_time}}"
                                                                           :key="time().$item->id"/>
                                @else
                                    <span>{{ $item['initial_time'] }}</span>
                                @endif
                            </td>
                            <td>
                                @if(!$is_terminated)
                                    <livewire:components.input-inline-edit :modelId="$item->id"
                                                                           class="{{\App\Models\Poa\Piat\PoaActivityPiatPlan::class}}"
                                                                           field="end_time" type="time"
                                                                           :rules="'required|after:'.$item['initial_time']"
                                                                           defaultValue="{{$item->end_time}}"
                                                                           :key="time().$item->id"/>
                                @else
                                    <span>{{ $item->end_time }}</span>
                                @endif
                            </td>
                            @if($item->responsable)
                                <td>
                                    <span>{{ $item->responsible->user_id ? $item->responsible->user->getFullName() : $item->responsible->name}}</span>
                                </td>
                                <td>
                                    <livewire:components.input-text :modelId="$item->responsible->id"
                                                                    class="{{ \App\Models\Poa\Piat\PoaPiatActivityResponsibles::class }}"
                                                                    field="number_hours_worked"
                                                                    type="number"
                                                                    :rules="'required|numeric|integer'"
                                                                    defaultValue="{{$item->responsible->number_hours_worked}}"
                                                                    :key=" time().$item->responsible->id"/>
                                </td>
                            @else
                                <td>-</td>
                            @endif
                            <td>
                                @if(!$is_terminated)
                                    <span class="cursor-pointer trash"
                                          wire:click="deleteThemeTask('{{ $item->id }}')">
                                                                       <i class="fas fa-trash text-danger"></i>
                                                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="d-flex align-items-center justify-content-center">
                                                            <span class="color-fusion-500 fs-3x py-3"><i
                                                                        class="fas fa-exclamation-triangle color-warning-900"></i>
                                                                No se encontraron actividades</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>