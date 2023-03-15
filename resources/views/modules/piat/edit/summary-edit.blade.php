@if ($piat)
    @include('modules.piat.edit.request-sivol')
    @include('modules.piat.edit.statuses')
@endif
<form wire:submit.prevent="submit()" method="post" autocomplete="off">
    <x-label-section>{{ trans('poa.piat_matrix_activity_workshop') }}</x-label-section>
    <div class="section-divider"></div>
    <div class="d-flex flex-wrap align-items-center justify-content-between w-100 mr-2">
        <div class="form-group w-100 pr-1">
            <label class="form-label fw-700"
                   for="name">{{ trans('poa.piat_matrix_create_placeholder_name') }}</label>
            <input type="text"
                   class="form-control bg-transparent  @error('name') is-invalid @enderror"
                   placeholder="{{ trans('poa.piat_matrix_create_placeholder_name') }}"
                   wire:model.defer="name">
            <div class="invalid-feedback" style="display: block;">{{ $errors->first('name') }}</div>
        </div>
        <div></div>
    </div>
    <div class="d-flex flex-wrap align-items-center justify-content-between w-65 mr-2">
        <div class="form-group w-33 pr-1">
            <label class="form-label fw-700"
                   for="place">{{ trans('poa.piat_matrix_create_placeholder_place') }}</label>
            <input type="text" wire:model.defer="place" class="form-control"
                   placeholder="{{ trans('poa.piat_matrix_create_placeholder_place') }}"/>
            <div class="invalid-feedback" style="display: block;">{{ $errors->first('place') }}</div>
        </div>
        <div class="form-group w-33">
            <label class="form-label fw-700"
                   for="date">{{ trans('poa.piat_matrix_create_placeholder_date') }}</label>
            <input type="date" wire:model.defer="date"
                   class="form-control bg-transparent @error('date') is-invalid @enderror"
            />
            <div class="invalid-feedback" style="display: block;">{{ $errors->first('date') }}</div>
        </div>
        <div class="form-group w-33">
            <label class="form-label fw-700"
                   for="endDate">{{ trans('poa.piat_matrix_create_placeholder_end_date') }}</label>
            <input type="date" wire:model.defer="endDate"
                   class="form-control bg-transparent @error('endDate') is-invalid @enderror"
            />
            <div class="invalid-feedback" style="display: block;">{{ $errors->first('endDate') }}</div>
        </div>
        <div class="form-group"></div>
    </div>
    <div class="d-flex flex-wrap align-items-center justify-content-between w-65 mr-2">
        <div class="form-group w-50 pr-1">
            <label class="form-label fw-700 timepicker"
                   for="initTime">{{ trans('poa.piat_matrix_create_placeholder_initial_time') }}</label>
            <input type="time" wire:model.defer="initTime"
                   class="form-control bg-transparent  @error('initTime') is-invalid @enderror"
                   placeholder="{{ trans('poa.piat_matrix_create_placeholder_initial_time') }}"/>
            <div class="invalid-feedback" style="display: block;">{{ $errors->first('initTime') }}</div>
        </div>
        <div class="form-group w-50">
            <label class="form-label fw-700 timepicker"
                   for="endTime">{{ trans('poa.piat_matrix_create_placeholder_end_time') }}</label>
            <input type="time" wire:model.defer="endTime"
                   class="form-control bg-transparent  @error('endTime') is-invalid @enderror"
                   placeholder="{{ trans('poa.piat_matrix_create_placeholder_end_time') }}"/>
            <div class="invalid-feedback" style="display: block;">{{ $errors->first('endTime') }}</div>
        </div>
        <div class="form-group"></div>
    </div>
    <div class="d-flex flex-wrap align-items-center justify-content-between mr-2">
        <div class="form-group w-30 pr-1">
            <label class="form-label fw-700"
                   for="province">{{ trans('poa.piat_matrix_create_placeholder_province') }}</label>
            <select wire:model="province"
                    class="custom-select bg-transparent  @error('province') is-invalid @enderror"
                    id="province">
                <option value="" selected>
                    {{ trans('poa.piat_matrix_create_placeholder_province') }}
                </option>
                @foreach ($provinces as $item)
                    <option value="{{ $item->id }}">{{ $item->description }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">{{ $errors->first('province') }}</div>
        </div>
        <div class="form-group w-30">
            <label class="form-label fw-700"
                   for="canton">{{ trans('poa.piat_matrix_create_placeholder_canton') }}</label>
            <select wire:model="canton"
                    class="custom-select bg-transparent  @error('canton') is-invalid @enderror">
                <option value="" selected>
                    {{ trans('poa.piat_matrix_create_placeholder_canton') }}
                </option>
                @foreach ($cantons as $item)
                    <option value="{{ $item->id }}">{{ $item->description }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">{{ $errors->first('canton') }}</div>
        </div>
        <div class="form-group w-30">
            <label class="form-label fw-700"
                   for="parish">{{ trans('poa.piat_matrix_create_placeholder_parish') }}</label>
            <select wire:model="parish"
                    class="custom-select bg-transparent  @error('parish') is-invalid @enderror">
                <option value="" selected>
                    {{ trans('poa.piat_matrix_create_placeholder_parish') }}
                </option>
                @foreach ($parishes as $item)
                    <option value="{{ $item->id }}">{{ $item->description }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">{{ $errors->first('parish') }}</div>
        </div>
        <div class="form-group"></div>
    </div>
    <div class="d-flex flex-wrap align-items-center justify-content-between w-100 mr-2">
        <div class="form-group w-100 pr-1">
            <label class="form-label fw-700"
                   for="goal">{{ trans('poa.piat_matrix_create_placeholder_goals') }}</label>
            <textarea wire:model.defer="goal" class="form-control"
                      placeholder="{{ trans('poa.piat_matrix_create_placeholder_goals') }}"></textarea>
            <div class="invalid-feedback" style="display: block;">{{ $errors->first('goal') }}</div>
        </div>
    </div>

    <div class="modal-footer justify-content-center">
        <div class="card-footer text-muted py-2 text-center">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
            </button>
        </div>
    </div>
</form>