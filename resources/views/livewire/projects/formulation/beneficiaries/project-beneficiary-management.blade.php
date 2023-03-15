<div>
    <div class="d-flex mb-2 w-100">
        <x-label-section> {{trans_choice('general.description_beneficiaries',0)}}
            <x-tooltip-help message="{{$messages->where('code','beneficiarios')->first()->description}}"></x-tooltip-help>
        </x-label-section>

        <button type="button" class="btn btn-success ml-auto btn-sm" data-toggle="modal"
                data-target="#add_beneficiary_modal">
            <i class="fas fa-plus mr-1"></i>
            {{ trans('general.create') }}
        </button>
    </div>
    <div class="">
        <div class="col-12 col-sm-12 col-md-12">
            <div class="row mb-2">
                <div class="col-xl-12">
                    <livewire:components.input-text-editor-inline-editor
                            :modelId="$project->id"
                            class="\App\Models\Projects\Project"
                            field="description_beneficiaries"
                            :defaultValue="$project->description_beneficiaries"
                            :key="time().$project->id"/>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            @if($project_beneficiaries->count()>0)
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($project_beneficiaries as $item)
                            <tr>
                                <td>
                                    <livewire:components.select-inline-edit :modelId="$item->id"
                                                                            :fieldId="$item->type_id"
                                                                            class="\App\Models\Projects\ProjectBeneficiaries"
                                                                            field="type_id"
                                                                            value="{{$item->types->description??''}}"
                                                                            :selectClass="$catalogs_types"
                                                                            selectField="description"
                                                                            selectRelation="types"
                                                                            :key="time().$item->id"/>
                                </td>
                                <td>
                                    <livewire:components.input-inline-edit :modelId="$item->id"
                                                                           class="\App\Models\Projects\ProjectBeneficiaries"
                                                                           field="amount"
                                                                           :rules="'required|numeric'"
                                                                           defaultValue="{{$item->amount}}"
                                                                           :key="time().$item->id"/>
                                </td>
                                <td class="text-center">
                                    <button class="border-0 bg-transparent"
                                            wire:click="$emit('beneficiaryDelete', '{{ $item->id }}')" data-toggle="tooltip"
                                            data-placement="top" title="Eliminar"
                                            data-original-title="Eliminar"><i class="fas fa-trash mr-1 text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else

                <x-empty-content>
                    <x-slot name="title">
                        No existen beneficiarios creados para el proyecto
                    </x-slot>
                </x-empty-content>

            @endif
        </div>
    </div>
</div>
<div wire:ignore>
    <livewire:projects.formulation.beneficiaries.project-beneficiary-create :id="$projectId"/>
</div>

@push('page_script')
    <script>
        Livewire.on('togglePublicBeneficiaryAddModal', () => $('#add_beneficiary_modal').modal('toggle'));
        document.addEventListener('DOMContentLoaded', function () {

        @this.on('beneficiaryDelete', id => {
            Swal.fire({
                title: '{{ trans('messages.warning.sure') }}',
                text: '{{ trans('messages.warning.delete') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                if (result.value) {
                @this.call('delete', id);
                }
            });
        });
        })

    </script>
@endpush