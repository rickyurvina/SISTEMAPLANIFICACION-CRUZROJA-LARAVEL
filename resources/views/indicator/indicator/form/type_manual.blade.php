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
{{-- check cierre de metas --}}
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
<div class="form-group col-lg-4">
    <label class="form-label" for="national">{{ trans('indicators.indicator.goals_closing') }}</label>
    <div class="custom-control custom-checkbox custom-checkbox-circle">
        <input type="checkbox" name="goals_closed" class="custom-control-input" id="goals_closed"
               wire:model.lazy="state">
        <label class="custom-control-label" for="goals_closed">{{trans('indicators.indicator.goals_closing')}}</label>
    </div>
</div>