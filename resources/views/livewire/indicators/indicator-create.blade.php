<div>
    <div
            x-data="{
                show: @entangle('show'),
                type: @entangle('type')
            }"
            x-init="$watch('show', value => {
            if (value) {
                $('#indicator-create-modal').modal('show')
            } else {
                $('#indicator-create-modal').modal('hide');
            }
        })"
            x-on:keydown.escape.window="show = false"
            x-on:close.stop="show = false"
    >
        <div wire:ignore.self class="modal fade" id="indicator-create-modal" tabindex="-1" role="dialog" aria-hidden="true"
             data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-center modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary color-white">
                        <h5 class="modal-title h4">{{ trans('indicators.indicator.create_indicator')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" x-on:click="show = false">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{-- tipo --}}
                            <div class="form-group col-lg-4 col-sm-12 required">
                                <label class="form-label" for="type">{{ trans('general.type') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fal fa-typewriter"></i>
                                                </span>
                                    </div>
                                    <select class="custom-select @error('type') is-invalid @enderror" id="type" name="type" wire:model="type">
                                        <option value="">{{ trans('general.type') }}</option>
                                        <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_MANUAL}}">{{ trans('indicators.indicator.Manual') }}</option>
                                        <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_GROUPED}}">{{ trans('indicators.indicator.Grouped') }}</option>
                                    </select>
                                </div>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('type',':message') }} </div>
                            </div>
                            {{-- categiria --}}
                            @if(!$hasCategory)
                                <div class="form-group col-lg-4 col-sm-12 required">

                                    <label class="form-label" for="type">{{ trans('general.category') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fal fa-typewriter"></i>
                                                </span>
                                        </div>
                                        <select class="custom-select @error('category') is-invalid @enderror" id="category" name="category" wire:model.defer="category">
                                            <option value="">-{{ trans('general.category') }}-</option>
                                            <option value="{{\App\Models\Indicators\Indicator\Indicator::CATEGORY_TACTICAL}}">{{\App\Models\Indicators\Indicator\Indicator::CATEGORY_TACTICAL}}</option>
                                            <option value="{{\App\Models\Indicators\Indicator\Indicator::CATEGORY_OPERATIVE}}">{{\App\Models\Indicators\Indicator\Indicator::CATEGORY_OPERATIVE}}</option>
                                        </select>
                                    </div>
                                    <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('category',':message') }} </div>
                                </div>
                            @endif
                            {{-- codigo --}}
                            <div class="form-group col-lg-4 required">
                                <label class="form-label" for="code">{{ trans('general.code') }} {{ trans_choice('general.indicators', 1) }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="fal fa-barcode"></i>
                                            </span>
                                    </div>
                                    <input type="text" name="code" id="code" class="form-control border-left-0 bg-transparent pl-0 @error('code') is-invalid @enderror"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans_choice('general.code', 1)]) }}" wire:model.defer="code">
                                    <div class="invalid-feedback">{{ $errors->first('code',':message') }} </div>
                                </div>
                            </div>
                            {{-- nombre --}}
                            <div class="form-group col-lg-4 required">
                                <label class="form-label" for="name">{{ trans('general.name') }} {{ trans_choice('general.indicators', 1) }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="fal fa-address-card"></i>
                                            </span>
                                    </div>
                                    <input type="text" name="name" id="name"
                                           class="form-control border-left-0 bg-transparent pl-0 @error('name') is-invalid @enderror"
                                           placeholder="{{ trans('general.form.enter', ['field' => trans_choice('general.indicators', 1)]) }}" wire:model.defer="name">
                                    <div class="invalid-feedback">{{ $errors->first('name',':message') }} </div>
                                </div>
                            </div>
                            {{-- responsable --}}
                            <div class="form-group col-lg-4 required">
                                <label class="form-label" for="responsible">{{ trans('general.responsible') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fal fa-user-circle"></i>
                                                </span>
                                    </div>
                                    <select class="custom-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" wire:model.defer="user_id">
                                        <option value=""> {{ trans('general.responsible') }}</option>
                                        @if(isset($users))
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">
                                                    {{$user->name}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('user_id',':message') }} </div>
                            </div>
                            {{-- resultados --}}
                            <div class="form-group col-lg-4 required">
                                <label class="form-label" for="results">{{ trans('indicators.indicator.results') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                               <i class="fal fa-align-justify"></i>
                                            </span>
                                    </div>
                                    <textarea class="form-control border-left-0 bg-transparent pl-0 @error('results') is-invalid @enderror"
                                              id="results" name="results" rows="1"
                                              placeholder="{{ trans('general.form.enter', ['field' => trans('indicators.indicator.results')]) }}"
                                              wire:model.defer="results"></textarea>
                                    <div class="invalid-feedback">{{ $errors->first('results',':message') }} </div>
                                </div>
                            </div>
                            {{-- unidad de meddida --}}
                            <div class="form-group col-lg-4 required">
                                <label class="form-label" for="indicator_units_id">{{ trans('indicators.indicator.unit_of_measurement') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="fal fa-balance-scale-left"></i>
                                            </span>
                                    </div>
                                    <select name="indicator_units_id" class="custom-select @error('indicator_units_id') is-invalid @enderror" id="indicator_units_id"
                                            wire:model="indicator_units_id">
                                        <option value=""> {{ trans('indicators.indicator.unit_of_measurement') }}</option>
                                        @if(isset($indicatorUnits))
                                            @foreach($indicatorUnits as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('indicator_units_id',':message') }} </div>
                            </div>
                            {{-- tipo de agragacion --}}
                            <div class="form-group col-lg-4 required">
                                <label class="form-label" for="type_of_aggregation">{{ trans('indicators.indicator.type_of_aggregation') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="fal fa-wave-sine"></i>
                                            </span>
                                    </div>
                                    <select class="custom-select" id="type_of_aggregation" name="type_of_aggregation" wire:model="type_of_aggregation">
                                        <option value="">{{ trans('indicators.indicator.type_of_aggregation') }}</option>
                                        <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_AGGREGATION_SUM}}">{{trans('indicators.indicator.TYPE_AGGREGATION_sum') }}</option>
                                        <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_AGGREGATION_WEIGHTED}}">{{trans('indicators.indicator.TYPE_AGGREGATION_weighted') }}</option>
                                        <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_AGGREGATION_WIGHTED_SUM}}">{{trans('indicators.indicator.TYPE_AGGREGATION_weighted_sum') }}</option>
                                    </select>
                                </div>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('type_of_aggregation',':message') }} </div>
                            </div>
                            {{-- tipo de threshold --}}
                            <div class="form-group  required col-lg-4">
                                <label class="form-label"
                                       for="thresholds_id">{{trans('indicators.indicator.choose_threshold') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                               <i class="fal fa-ballot-check"></i>
                                            </span>
                                    </div>
                                    <select class="custom-select" wire:model="selectedThreshold" id="thresholds_id" name="thresholds_id">
                                        <option value=""> {{ trans('indicators.indicator.choose_threshold') }}</option>
                                        @foreach($thresholds as $threshold)
                                            <option value="{{$threshold->id}}">
                                                {{$threshold->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('selectedThreshold',':message') }} </div>
                            </div>
                            {{-- tipo de ascendente, dsc, tolerancia --}}
                            <div class="form-group  required col-lg-4">
                                <label class="form-label" for="abbreviation">{{ trans('general.type') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                               <i class="fal fa-arrows-v"></i>
                                            </span>
                                    </div>
                                    <select class="custom-select" wire:model="selectedType" id="threshold_type" name="threshold_type">
                                        <option value="">{{trans('general.choose')}}{{ trans('general.type') }}</option>
                                        <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_TOLERANCE}}">{{trans('indicators.indicator.TYPE_tolerance') }}</option>
                                        <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_ASCENDING}}">{{trans('indicators.indicator.TYPE_ascending') }}</option>
                                        <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_DESCENDING}}">{{trans('indicators.indicator.TYPE_descending') }}</option>
                                    </select>
                                </div>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('selectedType',':message') }} </div>
                            </div>
                            {{-- fecha inicio y fin --}}
                            <div class="form-group col-lg-4 required">
                                <label class="form-label" for="start_date">{{ trans('general.start_date') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <input class="form-control" id="start_date" type="month" name="start_date" wire:model.lazy="start_date">
                                </div>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('start_date',':message') }} </div>
                            </div>
                            <div class="form-group col-lg-4 required">
                                <label class="form-label" for="end_date">{{ trans('general.end_date') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <input class="form-control" id="end_date" type="month" name="end_date" wire:model.lazy="end_date">
                                </div>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('end_date',':message') }} </div>
                            </div>
                            {{-- frecuencia --}}
                            <div class="form-group col-lg-4 required">
                                <label class="form-label" for="frequency">{{ trans('indicators.indicator.frequency_update') }}</label>
                                <div class="input-group bg-white shadow-inset-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fal fa-wave-sine"></i>
                                        </span>
                                    </div>
                                    <select class="custom-select" id="frequency" name="frequency" wire:model="frequency">
                                        <option value=""> {{ trans('indicators.indicator.frequency_update') }}</option>
                                        @foreach(\App\Models\Indicators\Indicator\Indicator::TYPE_FREQUENCIES  as $index => $frequency)
                                            <option value="{{$index}}">{{$frequency}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('frequency',':message') }} </div>
                            </div>
                            @if (!is_null($selectedType) && !is_null($selectedThreshold))
                                @if($selectedType==\App\Models\Indicators\Indicator\Indicator::TYPE_ASCENDING)
                                    <div class="form-group col-lg-4 required">
                                        <label class="form-label" for="minAW">Limite Inferior</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <input type="number" name="minAW" min="0" pattern="^[0-9]+" id="minAW"
                                                   class="form-control text-center m-0 p-0"
                                                   wire:model.defer="minAW"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.min')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('minAW',':message') }} </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 required">
                                        <label class="form-label" for="maxAW">Limite Superior</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <input type="number" name="maxAW" min="0" pattern="^[0-9]+" id="maxAW"
                                                   class="form-control text-center m-0 p-0"
                                                   wire:model.defer="maxAW"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.max')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('maxAW',':message') }} </div>
                                        </div>
                                    </div>
                                @endif
                                @if($selectedType==\App\Models\Indicators\Indicator\Indicator::TYPE_DESCENDING)
                                    <div class="form-group col-lg-4 required">
                                        <label class="form-label" for="minDW">Limite Inferior</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <input type="number" name="minDW" min="0" pattern="^[0-9]+" id="minDW"
                                                   class="form-control border-left-0 bg-transparent pl-0 text-center"
                                                   wire:model.defer="minDW"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.min')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('minDW',':message') }} </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 required">
                                        <label class="form-label" for="maxDW">Limite Superior</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <input type="number" name="maxDW" min="0" pattern="^[0-9]+" id="maxDW"
                                                   class="form-control border-left-0 bg-transparent pl-0 text-center"
                                                   wire:model.defer="maxDW"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.max')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('maxDW',':message') }} </div>
                                        </div>
                                    </div>
                                @endif
                                @if($selectedType==\App\Models\Indicators\Indicator\Indicator::TYPE_TOLERANCE)
                                    <div class="form-group col-lg-4 required">
                                        <label class="form-label" for="minTW">Limite Inferior</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <input type="number" name="minTW" min="0" pattern="^[0-9]+" id="minTW"
                                                   class=" form-control border-left-0 bg-transparent pl-0 text-center text-center"
                                                   wire:model.defer="minTW"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.min')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('minTW',':message') }} </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-4 required">
                                        <label class="form-label" for="maxTW">Limite Superior</label>
                                        <div class="input-group bg-white shadow-inset-2">
                                            <input type="number" name="maxTW" min="0" pattern="^[0-9]+" id="maxTW"
                                                   class=" form-control border-left-0 bg-transparent pl-0 text-center"
                                                   wire:model.defer="maxTW"
                                                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.max')]) }}">
                                            <div class="invalid-feedback">{{ $errors->first('maxTW',':message') }} </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if($type===\App\Models\Indicators\Indicator\Indicator::TYPE_MANUAL)
                                {{-- fuente de verificacion --}}
                                <div class="form-group col-4 required">
                                    <label class="form-label" for="source">{{ trans('general.source') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fal fa-address-card"></i>
                                                </span>
                                        </div>
                                        <select class="custom-select @error('indicator_sources_id') is-invalid @enderror" id="indicator_sources_id"
                                                name="indicator_sources_id"
                                                wire:model.defer="indicator_sources_id">
                                            <option value="" selected> {{ trans('general.source') }}</option>
                                            @if(isset($indicatorSource))
                                                @foreach($indicatorSource as $key)
                                                    <option value="{{$key->id}}">{{$key->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('indicator_sources_id',':message') }} </div>
                                </div>
                                {{-- linea base --}}
                                <div class="form-group col-4">
                                    <label class="form-label" for="base_line">{{ trans('indicators.indicator.base_line') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="fal fa-analytics"></i>
                                            </span>
                                        </div>
                                        <input type="number" name="base_line" id="base_line" min="0"
                                               class="form-control border-left-0 bg-transparent pl-0 @error('base_line') is-invalid @enderror"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('indicators.indicator.base_line')]) }}" wire:model.defer="base_line">
                                        <div class="invalid-feedback">{{ $errors->first('base_line',':message') }} </div>
                                    </div>
                                </div>
                                {{-- anio fecha de inicio --}}
                                <div class="form-group col-4">
                                    <label class="form-label" for="baseline_year">{{ trans('indicators.indicator.baseline_year') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0">
                                                    <i class="fal fa-calendar-check"></i>
                                                </span>
                                        </div>
                                        <input type="number" name="baseline_year" id="baseline_year" min="0"
                                               class="form-control border-left-0 bg-transparent pl-0 @error('baseline_year') is-invalid @enderror"
                                               placeholder="{{ trans('general.form.enter', ['field' => trans('indicators.indicator.base_line')]) }}"
                                               wire:model.defer="baseline_year">
                                    </div>
                                    <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('baseline_year',':message') }} </div>
                                </div>
                                {{--check de auto gestionable --}}
                                <div class="form-group col-4">
                                    <label class="form-label" for="self_managed">{{ trans('indicators.indicator.self_managed') }}</label>
                                    <div class="custom-control custom-checkbox custom-checkbox-circle">
                                        <input type="checkbox" name="self_managed" class="custom-control-input" id="self_managed"
                                               wire:model="self_managed">
                                        <label class="custom-control-label" for="self_managed">{{trans('indicators.indicator.self_managed')}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="form-label" for="national">{{ trans('indicators.indicator.indicator_national') }}</label>
                                    <div class="input-group bg-white shadow-inset-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="national" checked="" wire:model.defer="national">
                                            <label class="custom-control-label" for="national">{{ trans('indicators.indicator.indicator_national') }}</label>
                                            <div class="invalid-feedback">{{ $errors->first('national',':message') }} </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- check cierre de metas --}}
                                <div class="form-group col-lg-4">
                                    <label class="form-label" for="national">{{ trans('indicators.indicator.goals_closing') }}</label>
                                    <div class="custom-control custom-checkbox custom-checkbox-circle">
                                        <input type="checkbox" name="goals_closed" class="custom-control-input" id="goals_closed"
                                               wire:model.lazy="state">
                                        <label class="custom-control-label" for="goals_closed">{{trans('indicators.indicator.goals_closing')}}</label>
                                    </div>
                                </div>
                                @if($self_managed)
                                    <div class="form-group col-lg-12 required">
                                        <label class="form-label" for="goals">{{ trans_choice('indicators.indicator.goal',2) }}</label>

                                        <div class="input-group d-flex flex-row">
                                            @switch($selectedType)
                                                @case(\App\Models\Indicators\Indicator\Indicator::TYPE_TOLERANCE)
                                                    @for($i =0; $i < count($this->periods); $i++)
                                                        <div class="p-2" wire:key="{{time().$i}}">
                                                            <x-form.inputs.text type="number" id="min[]" name="min[]" label="{{$data[$i]['frequency']}}" class="mb-0"
                                                                                wire:model.defer="min.{{$i}}" value="{{$min[$i]??0}}"/>
                                                            <x-form.inputs.text type="number" id="max[]" name="max[]" wire:model="max.{{$i}}" value="{{$max[$i]??0}}"/>
                                                        </div>
                                                    @endfor

                                                    @break
                                                @case(\App\Models\Indicators\Indicator\Indicator::TYPE_ASCENDING || \App\Models\Indicators\Indicator\Indicator::TYPE_DESCENDING)
                                                    @for($i =0; $i < count($this->periods); $i++)
                                                        <div class="p-2" wire:key="{{time().$i}}">
                                                            <x-form.inputs.text type="number" name="freq[]" label="{{$data[$i]['frequency']}}" id="freq[]"
                                                                                wire:model.defer="freq.{{ $i  }}" value="{{$freq[$i]??0}}"/>
                                                        </div>
                                                    @endfor
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                    </div>

                                @endif
                            @else
                                @if(isset($this->indicators))
                                    <div class="d-flex w-100 m-2">
                                        <div class="form-group col-12">
                                            <div class="position-relative w-100" x-data="{ open: false }">
                                                <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if(count($indicatorsSelected) > 0) filtered @endif"
                                                        x-on:click="open = ! open"
                                                        type="button">
                                                    <span class="spinner-border spinner-border-sm" wire:loading></span>
                                                    @if(count($indicatorsSelected) > 0)
                                                        <span class="badge bg-white ml-2">
                                                            {{ count($indicatorsSelected) }}
                                                    </span>
                                                    @else
                                                        {{trans_choice('general.indicators',1)}}
                                                    @endif
                                                </button>
                                                <div class="dropdown mb-2 w-100" x-on:click.outside="open = false" x-show="open"
                                                     style="will-change: top, left;top: 37px;left: 0;">
                                                    <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="spinner-border">
                                                                <span class="sr-only"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div wire:loading.class="hidden-child">
                                                        <div style="max-height: 300px; overflow-y: auto" class="w-100">
                                                            @if(empty($indicators))
                                                                <div class="dropdown-item" x-cloak
                                                                     @click="open = false">
                                                                    <span>{{ trans('general.name') }}</span>
                                                                </div>
                                                            @endif
                                                            @foreach($indicators as $index => $item)
                                                                <div class="dropdown-item cursor-pointer"
                                                                     wire:key="{{time().$index}}">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="i-indicator-{{ $item->id }}"
                                                                               wire:model="indicatorsSelected"
                                                                               value="{{ $item->id }}">
                                                                        <label class="custom-control-label"
                                                                               for="i-indicator-{{ $item->id }}">{{ $item->name }}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            @if(count($indicatorsSelected) > 0 )
                                                                <div class="dropdown-divider"></div>
                                                                <div class="dropdown-item">
                                                                    <span wire:click="$set('indicatorsSelected', [])"
                                                                          class="cursor-pointer">{{ trans('general.delete_selection') }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(isset($goalValueTotal))
                                    <div class="form-group col-12">
                                        <dl>
                                            <dt class="col-sm-10">
                                                <h5><strong>{{trans('indicators.indicator.total_goal_value') }}
                                                    </strong>
                                                </h5>
                                            </dt>
                                            <dd class="col-sm-2">
                                                {{ $goalValueTotal }}
                                            </dd>
                                            <dt class="col-sm-10"><h5><strong>{{trans('indicators.indicator.total_actual_value') }}</strong></h5></dt>
                                            <dd class="col-sm-2">
                                                {{ $actualValueTotal }}
                                            </dd>
                                        </dl>
                                    </div>
                                @endif
                            @endif
                            {{-- indicador nacional --}}

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary mr-1" x-on:click="show = false">
                            <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                        </button>
                        <button class="btn btn-primary" wire:click="save">
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
            $('#select-indicators').select2({
                dropdownParent: $("#indicator-create-modal"),
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
                // Livewire.emit('indicatorsSelected', id);
                @this.
                set('indicatorsSelected', $(this).val());
            });

        });
        window.addEventListener('loadIndicators', event => {
            $('#select-indicators').select2({
                dropdownParent: $("#indicator-create-modal"),
                placeholder: "{{ trans('general.select') }}"
            }).on('change', function (e) {
                @this.
                set('indicatorsSelected', $(this).val());

            });
        });
    </script>
@endpush