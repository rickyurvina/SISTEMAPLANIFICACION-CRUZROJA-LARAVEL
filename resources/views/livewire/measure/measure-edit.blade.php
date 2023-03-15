<div>
    <div
            x-data="{
                show: @entangle('show'),
                type: @entangle('type')
            }"
            x-init="$watch('show', value => {
            if (value) {
                $('#measure-edit-modal').modal('show')
            } else {
                $('#measure-edit-modal').modal('hide');
            }
        })"
            x-on:keydown.escape.window="show = false"
            x-on:close.stop="show = false"
    >

        <div wire:ignore.self class="modal fade" id="measure-edit-modal" tabindex="-1" role="dialog" aria-hidden="true"
             data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h4"><i class="fas fa-plus-circle text-success"></i> {{ trans('indicators.indicator.edit_indicator')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" wire:click="resetInputs">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    @if($measure)
                        <div class="modal-body">
                            <div class="card border mb-g">
                                <div class="card-body pl-4 pt-4 pr-4">
                                    <div class="row">
                                        {{-- nombre --}}
                                        <div class="form-group required col-sm-12 col-md-6 col-lg-6">
                                            <label class="form-label" for="name">{{ trans('general.name') }}</label>
                                            <input type="text" name="name" id="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="Escriba el nombre del indicador" wire:model.defer="name">
                                            <div class="invalid-feedback">{{ $errors->first('name',':message') }} </div>
                                        </div>

                                        @if($goalsClosed===false)
                                            {{-- tipo --}}
                                            <div class="form-group required col-sm-12 col-md-6 col-lg-6">
                                                <label class="form-label" for="type">{{ trans('general.type') }}</label>
                                                <select class="custom-select @error('type') is-invalid @enderror" id="type" name="type" wire:model="type">
                                                    <option value="{{ \App\Models\Measure\Measure::TYPE_MANUAL }}">{{ trans('indicators.indicator.Manual') }}</option>
                                                    <option value="{{ \App\Models\Measure\Measure::TYPE_GROUPED }}">{{ trans('indicators.indicator.Grouped') }}</option>
                                                </select>
                                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('type',':message') }} </div>
                                            </div>
                                        @endif

                                        {{-- codigo --}}
                                        <div class="form-group required col-sm-12 col-md-6 col-lg-6">
                                            <label class="form-label" for="code">{{ trans('general.code') }}</label>
                                            <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                                                   placeholder="Escriba el código del Indicador" wire:model.defer="code">
                                            <div class="invalid-feedback">{{ $errors->first('code',':message') }} </div>
                                        </div>

                                        {{--                                    --}}{{-- Categoria --}}
                                        <div class="form-group required col-sm-12 col-md-6 col-lg-6">
                                            <label class="form-label" for="category">{{ trans('general.category') }}</label>
                                            <select class="custom-select @error('type') is-invalid @enderror" id="category" name="category" wire:model="category">
                                                <option value="{{ \App\Models\Measure\Measure::CATEGORY_TACTICAL }}">{{ \App\Models\Measure\Measure::CATEGORY_TACTICAL }}</option>
                                                <option value="{{ \App\Models\Measure\Measure::CATEGORY_OPERATIVE }}">{{ \App\Models\Measure\Measure::CATEGORY_OPERATIVE }}</option>
                                            </select>
                                            <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('category',':message') }} </div>
                                        </div>

                                        {{--                                    --}}{{-- responsable --}}
                                        <div class="form-group required col-sm-12 col-md-6 col-lg-6">
                                            <label class="form-label" for="responsible">{{ trans('general.responsible') }}</label>
                                            <select class="custom-select @error('userId') is-invalid @enderror" id="user_id" name="user_id" wire:model.defer="userId">
                                                @if(isset($users))
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" @if($user->id === $userId) selected @endif>{{ $user->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('userId',':message') }} </div>
                                        </div>

                                        @if($type === \App\Models\Measure\Measure::TYPE_MANUAL)
                                            {{--                                         año línea base--}}
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label class="form-label" for="baseLineYear">{{ trans('indicators.indicator.baseline_year') }}</label>
                                                <input type="number" name="baseLineYear" id="baseLineYear" class="form-control @error('baseLineYear') is-invalid @enderror"
                                                       placeholder="Escriba el año de la línea base" wire:model.defer="baseLineYear">
                                                <div class="invalid-feedback">{{ $errors->first('baseLineYear',':message') }} </div>
                                            </div>

                                            {{--                                         línea base--}}
                                            <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                                <label class="form-label" for="baselineYear">{{ trans('indicators.indicator.base_line') }}</label>
                                                <input type="number" name="baseLine" id="baseLine" class="form-control @error('baseLine') is-invalid @enderror"
                                                       placeholder="Escriba la línea base" wire:model.defer="baseLine">
                                                <div class="invalid-feedback">{{ $errors->first('baseLine',':message') }} </div>
                                            </div>
                                        @endif

                                        {{--                                    --}}{{-- fuente --}}
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label class="form-label" for="source">{{ trans('general.source') }}</label>
                                            <select class="custom-select @error('indicatorSourceId') is-invalid @enderror" id="indicatorSourceId" name="indicatorSourceId"
                                                    wire:model.defer="indicatorSourceId">
                                                @if(isset($indicatorSources))
                                                    @foreach($indicatorSources as $source)
                                                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('indicatorSourceId',':message') }} </div>
                                        </div>

                                        {{--                                    --}}{{-- resultados --}}
                                        <div class="form-group col-sm-5 col-md-6 col-lg-6">
                                            <label class="form-label" for="results">{{ trans('indicators.indicator.results') }}</label>
                                            <textarea class="form-control @error('results') is-invalid @enderror"
                                                      id="results" name="results" rows="4"
                                                      placeholder="Escriba la descripción o los resultados esperados"
                                                      wire:model.defer="results"></textarea>
                                            <div class="invalid-feedback">{{ $errors->first('results',':message') }} </div>
                                        </div>
                                        {{--                                Indicador nacional--}}
                                        <div class="form-group col-lg-3 col-sm-3 col-md-3">
                                            <label class="form-label" for="national_edit">{{ trans('indicators.indicator.indicator_national') }}</label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="national_edit" checked="" wire:model.defer="national">
                                                <label class="custom-control-label" for="national_edit">{{ trans('indicators.indicator.indicator_national') }}</label>
                                                <div class="invalid-feedback">{{ $errors->first('national',':message') }} </div>
                                            </div>
                                        </div>
                                        {{--Cerrar Metas--}}
                                        <div class="form-group col-lg-3 col-sm-3 col-md-3">
                                            <label class="form-label" for="goals_closed">{{ trans('indicators.indicator.goals_closing') }}</label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="goals_closed" checked="" wire:model.defer="goalsClosed">
                                                <label class="custom-control-label" for="goals_closed">{{ trans('indicators.indicator.goals_closing') }}</label>
                                                <div class="invalid-feedback">{{ $errors->first('goals_closed',':message') }} </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($goalsClosed===false)
                                <div class="card border mb-g">
                                    <div class="card-header py-2">
                                        <div class="card-title">
                                            DETALLES DEL INDICADOR
                                        </div>
                                    </div>
                                    <div class="card-body pl-4 pt-4 pr-4">
                                        <div class="row">
                                            {{-- tipo de medición --}}
                                            <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                                <label class="form-label" for="scoring-type">{{ trans('indicators.indicator.scoring_type') }}</label>
                                                <div>
                                                    <div class="btn-group w-100">
                                                        <button class="btn btn-outline-secondary dropdown-toggle text-left"
                                                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            @if($scoringTypeId != null)
                                                                {{ $scoringTypeName }}
                                                            @else
                                                                {{ trans('general.select') }}
                                                            @endif
                                                        </button>

                                                        <div class="dropdown-menu w-100">
                                                            @foreach($scoring as $score)
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('scoringTypeId', '{{ $score->id }}')">
                                                                    <span>{{ $score->name }}</span>
                                                                    @if($scoringTypeId == $score->id)
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('scoringTypeId')
                                                <div class="error-dropdown">{{ $errors->first('scoringTypeId',':message') }} </div>
                                                @enderror
                                            </div>
                                            {{-- Calendario --}}
                                            <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                                <label class="form-label" for="frequency">{{ trans('indicators.indicator.frequency_update') }}</label>
                                                <div>
                                                    <div class="btn-group w-100">
                                                        <button class="btn btn-outline-secondary dropdown-toggle text-left"
                                                                type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            @if($calendarId != null)
                                                                {{ $calendarName }}
                                                            @else
                                                                {{ trans('general.select') }}
                                                            @endif
                                                        </button>

                                                        <div class="dropdown-menu w-100">
                                                            @foreach($calendars as $calendar)
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('calendarId', '{{ $calendar->id }}')">
                                                                    <span>{{ $calendar->name }}</span>
                                                                    @if($calendarId == $calendar->id)
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @error('calendarId')
                                                    <div class="error-dropdown">{{ $errors->first('calendarId',':message') }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @if($scoringType == \App\Models\Measure\ScoringType::TYPE_YES_NO)
                                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                                    <label class="form-label" for="is_yes_good">{{ trans('indicators.indicator.is_yes_good') }}</label>
                                                    <div>
                                                        <div class="btn-group w-100">
                                                            <button class="btn btn-outline-secondary dropdown-toggle text-left"
                                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                @if($isYesGood == 1)
                                                                    <span><i class="fas fa-check text-success"></i> {{ trans('general.yes') }}</span>
                                                                @else
                                                                    <span><i class="fas fa-times text-danger"></i> {{ trans('general.no') }}</span>
                                                                @endif
                                                            </button>

                                                            <div class="dropdown-menu w-100">
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('isYesGood', 1)">
                                                                    <span><i class="fas fa-check text-success"></i> {{ trans('general.yes') }}</span>
                                                                    @if($isYesGood == 1)
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('isYesGood', 0)">
                                                                    <span><i class="fas fa-times text-danger"></i> {{ trans('general.no') }}</span>
                                                                    @if($isYesGood == 0)
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @error('isYesGood')
                                                            <div class="error-dropdown">{{ $errors->first('isYesGood',':message') }} </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($scoringType == \App\Models\Measure\ScoringType::TYPE_GOAL_ONLY)
                                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                                    <label class="form-label" for="is_yes_good">{{ trans('indicators.indicator.higher_better') }}</label>
                                                    <div>
                                                        <div class="btn-group w-100">
                                                            <button class="btn btn-outline-secondary dropdown-toggle text-left"
                                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                @if($higherBetter == 1)
                                                                    <span><i class="fas fa-check text-success"></i> {{ trans('general.yes') }}</span>
                                                                @else
                                                                    <span><i class="fas fa-times text-danger"></i> {{ trans('general.no') }}</span>
                                                                @endif
                                                            </button>

                                                            <div class="dropdown-menu w-100">
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('higherBetter', 1)">
                                                                    <span><i class="fas fa-check text-success"></i> {{ trans('general.yes') }}</span>
                                                                    @if($higherBetter == 1)
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('higherBetter', 0)">
                                                                    <span><i class="fas fa-times text-danger"></i> {{ trans('general.no') }}</span>
                                                                    @if($higherBetter == 0)
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            {{-- Tipo de dato --}}
                                            @if($scoringType != \App\Models\Measure\ScoringType::TYPE_YES_NO)
                                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                                    <label class="form-label" for="data_type">{{ trans('indicators.indicator.data_type') }}</label>
                                                    <div>
                                                        <div class="btn-group w-100">
                                                            <button class="btn btn-outline-secondary dropdown-toggle text-left"
                                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                @if($dataType != null)
                                                                    <i class="fas fa-{{ trans('indicators.indicator.data_icon_' . $dataType) }}"></i>
                                                                    {{ trans('indicators.indicator.data_' . $dataType) }}
                                                                @else
                                                                    {{ trans('general.select') }}
                                                                @endif
                                                            </button>

                                                            <div class="dropdown-menu w-100">
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('dataType', 'number')">
                                                        <span><i class="fas fa-{{ trans('indicators.indicator.data_icon_number') }}"></i>
                                                            {{ trans('indicators.indicator.data_number') }}</span>
                                                                    @if($dataType == 'number')
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('dataType', 'percent')">
                                                        <span><i class="fas fa-{{ trans('indicators.indicator.data_icon_percent') }}"></i>
                                                            {{ trans('indicators.indicator.data_percent') }}</span>
                                                                    @if($dataType == 'percent')
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('dataType', 'currency')">
                                                                    <span><i class="fas fa-{{ trans('indicators.indicator.data_icon_currency') }}"></i> {{ trans('indicators.indicator.data_currency') }}</span>
                                                                    @if($dataType == 'currency')
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @error('dataType')
                                                            <div class="error-dropdown">{{ $errors->first('dataType',':message') }} </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            {{-- tipo de agragacion--}}
                                            <div class="form-group col-sm-6 col-md-4 col-lg-4">
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
                                                        @if($scoringType != \App\Models\Measure\ScoringType::TYPE_YES_NO)
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
                                                            @if($type == \App\Models\Measure\Measure::TYPE_MANUAL)
                                                                <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                     wire:click="$set('typeOfAggregation', 'last')">
                                                                    <span><i class="fas fa-{{ trans('indicators.indicator.TYPE_AGGREGATION_ICON_last') }}"></i> {{ trans('indicators.indicator.TYPE_AGGREGATION_last') }}</span>
                                                                    @if($typeOfAggregation == 'last')
                                                                        <i class="fas fa-check text-success"></i>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                 wire:click="$set('typeOfAggregation', 'number-of-yeses')">
                                                        <span><i class="fas fa-{{ trans('indicators.indicator.TYPE_AGGREGATION_ICON_number-of-yeses') }}"></i>
                                                            {{ trans('indicators.indicator.TYPE_AGGREGATION_number-of-yeses') }}</span>
                                                                @if($typeOfAggregation == 'number-of-yeses')
                                                                    <i class="fas fa-check text-success"></i>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @error('typeOfAggregation')
                                                    <div class="error-dropdown">{{ $errors->first('typeOfAggregation',':message') }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- Unidades --}}
                                            @if($scoringType != \App\Models\Measure\ScoringType::TYPE_YES_NO)
                                                <div class="form-group col-sm-6 col-md-4 col-lg-4">
                                                    <label class="form-label" for="unit">{{ trans('indicators.indicator.unit') }}</label>
                                                    <div>
                                                        <div class="btn-group w-100">
                                                            <button class="btn btn-outline-secondary dropdown-toggle text-left"
                                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                @if($indicatorUnitId != null)
                                                                    {{ $indicatorUnitName }}
                                                                @endif
                                                            </button>

                                                            <div class="dropdown-menu w-100">
                                                                @foreach($indicatorUnits as $unit)
                                                                    <div class="dropdown-item d-flex align-items-center justify-content-between"
                                                                         wire:click="$set('indicatorUnitId', '{{ $unit->id }}')">
                                                                        <span>{{ $unit->name }}</span>
                                                                        @if($indicatorUnitId == $unit->id)
                                                                            <i class="fas fa-check text-success"></i>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @error('indicatorUnitId')
                                                            <div class="error-dropdown">{{ $errors->first('indicatorUnitId',':message') }} </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        @if($scoringType != \App\Models\Measure\ScoringType::TYPE_YES_NO)
                                            <h3 class="mt-3">Umbrales</h3>
                                            <div class="row">
                                                @forelse($scoringConfig as $index => $config)
                                                    <div class="form-group required col-sm-4 col-md-3 col-lg-3" wire:key="field-{{ $index }}">
                                                        <label class="form-label">{{ $config['label'] }}</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control @error('series.'. $index) is-invalid @enderror"
                                                                   placeholder="Valor por defecto" wire:model.defer="series.{{ $index }}">
                                                            <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                    class="fal fa-{{ trans('indicators.indicator.data_icon_' . $dataType) }} fs-xl"></i></span>
                                                            </div>
                                                            <div class="invalid-feedback">{{ $errors->first('series.'. $index, ':message') }} </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                @endforelse
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if($type == \App\Models\Measure\Measure::TYPE_GROUPED)
                                    <div class="card border mb-g">
                                        <div class="card-header py-2">
                                            <div class="card-title">
                                                INDICADORES
                                            </div>
                                        </div>
                                        <div class="card-body pl-4 pt-4 pr-4">
                                            @if(count($groupedMeasures))
                                                <div class="card border mb-4">
                                                    <div class="card-header bg-info-500">
                                                        INDDICADORES SELECCIONADOS
                                                    </div>
                                                    <ul class="list-group list-group-flush">
                                                        @foreach($groupedMeasures as $measure)
                                                            <li class="list-group-item">
                                                                <div class="d-flex justify-content-between">
                                                                    <span>{{ $measure['name'] }}</span>
                                                                    <span class="cursor-pointer" wire:click="measureUnSelected({{ $measure['id'] }})"><i class="fas fa-trash
                                                            text-danger"></i></span>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <div class="alert @if($errors->has('groupedMeasures')) alert-danger @else alert-info @endif" role="alert">
                                                    Seleccione los indicadores que desea agrupar
                                                </div>
                                            @endif
                                            @include('livewire.measure.measure-create-element', ['element' => $element])
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary mr-1" x-on:click="show = false">
                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                        </button>
                        <button class="btn btn-success" wire:click="save">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        $(document).ready(function () {
            $('#select-category').select2({
                placeholder: "{{ trans('general.select') }}"
            });
        });
    </script>
@endpush