<div wire:ignore.self class="modal fade" id="weights" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-info">
                    <i class="fas fa-edit"></i>
                    {{ __('general.assign_weights') }}
                </h5>
            </div>
            <div class="modal-body pt-0">
                <div class="alert alert-info mb-3" role="alert">
                    El peso de cada elemento determina cuánto afecta el Score del padre. Un peso de 1 es normal. Un peso de 2 significa que tiene el doble de efecto.
                </div>
                <div class="card border">
                    <div class="card-header py-2">
                        <div class="card-title">
                            Pesos Actuales
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table m-0 table-light table-striped">
                            <thead>
                            <tr>
                                <th class="w-75"></th>
                                <th class="w-15 text-center font-weight-bold">{{ __('general.weight') }}</th>
                                <th></th>
                                <th class="w-10 text-center font-weight-bold">{{ __('general.total') }} %</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div wire:key="post-field-{{ $index }}">
                                            <input type="text" wire:model="items.{{ $index }}.weight"
                                                   class="form-control @error('items.'. $index. '.weight') is-invalid @enderror">
                                        </div>
                                    </td>
                                    <td class="text-center">=</td>
                                    <td class="text-center">{{ $this->weight($item->weight) }}%</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="font-weight-bolder border-top">{{ __('general.total') }}</td>
                                <td class="font-weight-bolder text-center border-top">{{ $this->total }}</td>
                                <td class="font-weight-bolder border-top">=</td>
                                <td class="font-weight-bolder text-center border-top">100%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary mr-1" data-dismiss="modal">
                    <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                </button>
                <button class="btn btn-success" wire:click="save" data-dismiss="modal" {{ $isValid ? '': 'disabled' }}>
                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                </button>
            </div>
        </div>
    </div>
</div>