@if (!is_null($selectedType) && !is_null($selectedThreshold))
    <div class="form-group col-lg-4 required">
        <label class="form-label" for="minTW">Limite Inferior</label>
        <div class="input-group bg-white shadow-inset-2">
            <input type="number" name="minThreshold" min="0" pattern="^[0-9]+" id="minThreshold"
                   class=" form-control border-left-0 bg-transparent pl-0 text-center text-center"
                   wire:model.defer="minThreshold"
                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.min')]) }}">
            <div class="invalid-feedback">{{ $errors->first('minTW',':message') }} </div>
        </div>
    </div>
    <div class="form-group col-lg-4 required">
        <label class="form-label" for="maxThreshold">Limite Superior</label>
        <div class="input-group bg-white shadow-inset-2">
            <input type="number" name="maxThreshold" min="0" pattern="^[0-9]+" id="maxThreshold"
                   class=" form-control border-left-0 bg-transparent pl-0 text-center"
                   wire:model.defer="maxThreshold"
                   placeholder="{{ trans('general.form.enter', ['field' => trans('general.max')]) }}">
            <div class="invalid-feedback">{{ $errors->first('maxTW',':message') }} </div>
        </div>
    </div>
@endif