<form wire:submit.prevent="submitRequirements()" method="post" autocomplete="off">
    @if(!$is_terminated)
        <x-label-section>{{ trans('poa.piat_matrix_activity_requirement') }}
        </x-label-section>
        <div class="section-divider"></div>
        <div class="d-flex flex-wrap align-items-center justify-content-between w-100 mr-2">
            <div class="form-group w-100 pr-1 required">
                <label class="form-label fw-700"
                       for="description">{{ trans('poa.piat_matrix_create_placeholder_description') }}</label>
                <input type="text" wire:model.defer="description" id="descriptionReq"
                       class="form-control"
                       placeholder="{{ trans('poa.piat_matrix_create_placeholder_description') }}"/>
                <div class="invalid-feedback" style="display: block;">{{ $errors->first('description') }}</div>
            </div>
            <div class="form-group"></div>
        </div>
        <div class="d-flex flex-wrap align-items-center justify-content-between w-100 mr-2">
            <div class="form-group w-33 pr-1 required">
                <label class="form-label fw-700"
                       for="quantity">{{ trans('poa.piat_matrix_create_placeholder_quantity') }}</label>
                <input type="number" wire:model.defer="quantity" id="quantity" class="form-control"
                       placeholder="{{ trans('poa.piat_matrix_create_placeholder_quantity') }}"/>
                <div class="invalid-feedback" style="display: block;">{{ $errors->first('quantity') }}</div>
            </div>
            <div class="form-group w-33 pr-1 required">
                <label class="form-label fw-700"
                       for="approximateCost">{{ trans('poa.piat_matrix_create_placeholder_cost') }}</label>
                <input type="text" wire:model.defer="approximateCost" id="approximateCost"
                       class="form-control"
                       placeholder="{{ trans('poa.piat_matrix_create_placeholder_cost') }}"/>
                <div class="invalid-feedback" style="display: block;">{{ $errors->first('approximateCost') }}
                </div>
            </div>
            @if($responsibles)
                <div class="form-group w-33" style="margin-bottom: 1.5rem">
                    <label class="form-label fw-700"
                           for="responsableReq">{{ trans('poa.piat_matrix_create_placeholder_responsable') }}</label>
                    <select wire:model.defer="responsableReq" class="custom-select bg-transparent">
                        <option value="{{ $responsableReq }}" selected>
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
                    <div class="invalid-feedback" style="display: block;">{{ $errors->first('responsableReq') }}
                    </div>
                </div>
            @endif

        </div>
        <div class="modal-footer justify-content-center">
            <div class="card-footer text-muted py-2 text-center">
                <a wire:click="cleanRequirements()" href="javascript:void(0);" class="btn btn-outline-secondary mr-1">
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
                    <th>{{ __('poa.piat_matrix_create_placeholder_description') }}</th>
                    <th>{{ __('poa.piat_matrix_create_placeholder_quantity') }}</th>
                    <th>{{ __('poa.piat_matrix_create_placeholder_cost') }}</th>
                    <th>{{ __('poa.responsible') }}</th>
                    <th><a href="#">{{ trans('general.actions') }} </a></th>
                </tr>
                </thead>
                <tbody>
                @if($piatReq)
                    @forelse($piatReq as $index => $item)
                        <tr wire:key="{{time().$index.$item->id}}">
                            <td>
                                <div class="d-flex float-left">
                                    @if(!$is_terminated)
                                        <div wire:key="{{time().$index}}" style="width: 250px; !important;" wire:ignore>
                                            <livewire:components.input-text :modelId="$item->id"
                                                                            class="\App\Models\Poa\Piat\PoaActivityPiatRequirements"
                                                                            field="description"
                                                                            :rules="'required|max:255'"
                                                                            defaultValue="{{$item->description}}"
                                                                            :key=" time().$item->id"/>
                                        </div>
                                    @else
                                        <span class="color-item shadow-hover-5 mr-2 cursor-default"></span>
                                        <span>{{ $item->description }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex float-left">
                                    @if(!$is_terminated)
                                        <livewire:components.input-text :modelId="$item->id"
                                                                        class="\App\Models\Poa\Piat\PoaActivityPiatRequirements"
                                                                        field="quantity"
                                                                        :rules="'required|numeric'"
                                                                        defaultValue="{{$item->quantity}}"
                                                                        :key=" time().$item->id"/>
                                    @else
                                        <span>{{ $item->quantity}}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex float-left">
                                    @if(!$is_terminated)
                                        <livewire:components.input-text :modelId="$item->id"
                                                                        class="\App\Models\Poa\Piat\PoaActivityPiatRequirements"
                                                                        field="approximate_cost"
                                                                        :rules="'required|numeric'"
                                                                        defaultValue="{{$item->approximate_cost}}"
                                                                        :key=" time().$item->id"/>
                                    @else
                                        <span>{{ $item->approximate_cost}}</span>
                                    @endif
                                </div>
                            </td>
                            @if($item->responsable)
                                <td>
                                    <span>{{ $item->responsible->user_id ? $item->responsible->user->getFullName() : $item->responsible->name}}</span>
                                </td>
                            @else
                                <td>
                                    -
                                </td>
                            @endif
                            <td>
                                @if(!$is_terminated)
                                    <div class="d-flex flex-wrap">
                                                                  <span class="cursor-pointer trash"
                                                                        wire:click="deleteRequirements('{{ $item->id }}')">
                                                                <i class="fas fa-trash text-danger"></i></span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="d-flex align-items-center justify-content-center">
                                                            <span class="color-fusion-500 fs-3x py-3"><i
                                                                        class="fas fa-exclamation-triangle color-warning-900"></i>
                                                                No se encontraron requerimientos</span>
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