<div wire:ignore.self class="modal fade in" id="edit-modal-poa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header mb-0 pb-0">
                <h3 class="modal-title font-weight-bold">
                    {{ __('poa.poa_edition') }} &nbsp;&nbsp;&nbsp;
                    @if($poa)
                        <span class="badge fs-2x {{ \App\Models\Poa\Poa::STATUS_BG[$poa->status->label()] }}  badge-pill">
                            {{ $poa->status }}
                        </span>
                    @endif
                </h3>
                <button type="button" wire:click="resetModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body mt-4 pt-0">
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            @if($poa)
                                <div class="form-group col-md-6 mb-0">
                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('poa.name') }}</b></label>
                                    <livewire:components.input-inline-edit :modelId="$poaId"
                                                                           class="{{\App\Models\Poa\Poa::class}}"
                                                                           field="name"
                                                                           defaultValue="{{$poa->name}}"
                                                                           :key="time().$poaId"/>
                                </div>
                                <div class="form-group col-md-6 mb-0">
                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('poa.year') }}</b></label>
                                    <div class="fs-3x">
                                        {{ $poa->year }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-0">
                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('poa.responsible') }}</b></label>

                                    <livewire:components.select-inline-edit :modelId="$poaId"
                                                                            :fieldId="$poa->user_id_in_charge"
                                                                            class="{{\App\Models\Poa\Poa::class}}"
                                                                            field="user_id_in_charge"
                                                                            value="{{ $poa->responsible->name??'' }}"
                                                                            :selectClass="$users"
                                                                            selectField="name"
                                                                            selectRelation="responsible"
                                                                            :key="time().$poaId"/>
                                </div>
                                <div class="form-group col-md-6 mb-0">
                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('poa.instance_reviewed') }}</b></label>
                                    <div class="custom-control custom-switch">
                                        <input wire:model="poaReviewed" wire:change="reviewed()" type="checkbox" id="poaReviewed"
                                               class="custom-control-input" {{ $poaReviewed ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="poaReviewed">{{ $poaReviewed ? __('general.yes') : __('general.no') }}</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 mb-0">
                                    <label class="col-form-label col-form-label-sm"><b>{{trans_choice('general.thresholds',1)}}{{ trans('general.min') }}</b></label>
                                    <livewire:components.input-inline-edit :modelId="$poaId"
                                                                           class="{{\App\Models\Poa\Poa::class}}"
                                                                           field="min"
                                                                           type="number"
                                                                           globalScopes="true"
                                                                           :rules="'required|integer|min:0|max:'.$poa->max-1"
                                                                           defaultValue="{{$poa->min }}"
                                                                           :key="time().$poaId"
                                    />
                                </div>
                                <div class="form-group col-md-6 mb-0">
                                    <label class="col-form-label col-form-label-sm"><b>{{trans_choice('general.thresholds',1)}}{{ trans('general.max') }}</b></label>
                                    <livewire:components.input-inline-edit :modelId="$poa->id"
                                                                           class="{{\App\Models\Poa\Poa::class}}"
                                                                           field="max"
                                                                           type="number"
                                                                           globalScopes="true"
                                                                           :rules="'required|integer|max:100|min:'.$poa->min+1"
                                                                           defaultValue="{{$poa->max}}"
                                                                           :key="time().$poaId"
                                    />
                                </div>
                                <div class="form-group col-md-12 mb-0" wire:ignore>
                                    <label class="col-form-label col-form-label-sm"><b>{{ trans('general.departments') }}</b></label>
                                    <select class="form-control" multiple="multiple" id="select2-dropdown"></select>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>
        document.addEventListener('livewire:load', function (event) {
            @this.
            on('refreshDropdown', function () {
                let departments = [];

                $.each(@this.existingDepartments, function (key, department) {
                    departments.push({
                        text: department.name,
                        id: department.id,
                        selected: department.selected
                    });
                }
            )
                ;

                $('#select2-dropdown')
                    .empty()
                    .select2({
                        dropdownParent: $("#edit-modal-poa"),
                        placeholder: "{{ trans('general.select').' '.trans('general.departments') }}",
                        data: departments
                    }).on('change', function (e) {
                    @this.
                    set('departmentsSelect', $(this).val());
                });
            });
        });

    </script>
@endpush