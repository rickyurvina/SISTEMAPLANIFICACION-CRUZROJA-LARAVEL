{{-- tipo --}}
@if(!$this->indicator)
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
@endif
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
    <label class="form-label" for="results">{{ trans('indicators.indicator.indicator_detail') }}</label>
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
    <label class="form-label" for="threshold_type">{{ trans('general.behaviour') }}</label>
    <div class="input-group bg-white shadow-inset-2">
        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-right-0">
                                               <i class="fal fa-arrows-v"></i>
                                            </span>
        </div>
        <select class="custom-select" wire:model="selectedType" id="threshold_type" name="threshold_type">
            <option value="">{{trans('general.choose')}}-{{ trans('general.behaviour') }}</option>
            <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_TOLERANCE}}">{{trans('indicators.indicator.TYPE_tolerance') }}</option>
            <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_ASCENDING}}">{{trans('indicators.indicator.TYPE_ascending') }}</option>
            <option value="{{\App\Models\Indicators\Indicator\Indicator::TYPE_DESCENDING}}">{{trans('indicators.indicator.TYPE_descending') }}</option>
        </select>
    </div>
    <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('selectedType',':message') }} </div>
</div>
{{-- fecha inicio y fin --}}
<div class="form-group col-lg-4 required" wire:ignore.self>
    <label class="form-label" for="start_date">{{ trans('general.start_date') }}</label>
    <div class="input-group bg-white shadow-inset-2">
        <input class="form-control" id="start_date" type="month" name="start_date" wire:model.lazy="start_date">
    </div>
    <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('start_date',':message') }} </div>
</div>
<div class="form-group col-lg-4 required" wire:ignore.self>
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