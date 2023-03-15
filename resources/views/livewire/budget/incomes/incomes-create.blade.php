<div wire:ignore.self class="modal fade fade" id="budget-income-create" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4"><i class="fas fa-plus-circle text-success"></i> {{ trans('budget.new_item_income') }}</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <form method="post" autocomplete="off" wire:submit.prevent="submit()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label class="form-label">{{ trans('budget.item_code') }}</label><br>
                                <label class="fs-2x">{{ $budgetItem }}</label>
                            </div>
                            <div class="form-group col-md-6 col-sm-12 required">
                                <label class="form-label" for="name">{{ trans('budget.item_name') }}</label><br>
                                <input type="text" wire:model.defer="itemName" id="name" class="form-control @error('itemName') is-invalid @enderror">
                                @error('itemName')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            @foreach($fields as $key => $field)
                                @switch($field['meta']['type'])
                                    @case('input')
                                    <div class="form-group col-12 required" wire:key="field-{{ $loop->index }}">
                                        <label class="form-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                        <input type="{{ $field['meta']['content'] }}" wire:model="fields.{{ $key }}.value"
                                               name="{{ $field['name'] }}"
                                               readonly="{{ $field['meta']['readonly'] }}"
                                               class="form-control">
                                    </div>
                                    @break
                                    @case('select')
                                    <div class="form-group col-12 required" wire:key="field-{{ $loop->index }}">
                                        <label class="form-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                        <select class="select2 form-control w-100 @error('fields.' . $key . '.value') is-invalid @enderror" wire:model="fields.{{ $key }}.value">
                                            <option value="">{{trans('general.select')}}</option>
                                            @foreach($field['meta']['source']['options'] as $item)
                                                <option value="{{ $item[$field['meta']['source']['field']] }}" wire:key="op-{{ $loop->index }}">
                                                    {{ $item[$field['meta']['source']['field']] . ' - ' . $item[$field['meta']['source']['field_display']] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fields.' . $key . '.value')
                                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    @break
                                @endswitch
                            @endforeach
                            @if($transaction->status instanceof \App\States\Transaction\Draft)
                                <div class="form-group col-md-12 required">
                                    <label class="form-label" for="amount">{{ trans('budget.value') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.01" wire:model.defer="itemAmount" id="amount" class="form-control @error('itemAmount') is-invalid @enderror">
                                        @error('itemAmount')
                                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            @else
                                <div class="form-group col-md-12 required">
                                    <label class="form-label" for="amount">{{ trans('budget.value') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                            <a class="ml-2 mt-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Para asignar un valor es necesario hacer una reforma">
                                                <i class="fas fa-info mr-1 ml-1 text-warning"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group col-md-12 required">
                                <label class="form-label" for="description">{{ trans('general.description') }}</label><br>
                                <textarea wire:model.defer="itemDescription" id="description" class="form-control @error('itemDescription') is-invalid @enderror"></textarea>
                                @error('itemDescription')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <x-form.modal.footer wirecancelevent="resetForm"></x-form.modal.footer>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>

        document.addEventListener("DOMContentLoaded", () => {
            window.initSelect2 = () => {
                $('.select2').select2({
                    placeholder: "{{ trans('general.select') }}",
                    dropdownParent: $("#budget-income-create")
                });
            };
            initSelect2();
            $('.select2').on('change', function (e) {
            @this.set($(e.target).attr('wire:model'), e.target.value);
            });
            window.livewire.on('initSelect2', () => {
                initSelect2();
            });

        });
    </script>
@endpush