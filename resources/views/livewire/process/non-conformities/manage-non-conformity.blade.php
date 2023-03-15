<div>
    <div wire:ignore.self class="modal fade" id="manage-non-conformity" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary color-white">
                    <h5 class="modal-title h4">{{ trans('general.manage') }} No Conformidad</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                            wire:click="closeModal">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($nonConformity)
                        <div class="table-responsive">
                            <table class="table  m-0">
                                <thead class="bg-primary-50">
                                <tr>
                                    <th class="w-10 text-center">
                                        Criterios para aceptar la AC o la AP #{{$nonConformity->number}}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <livewire:components.input-text-editor-inline-editor :modelId="$nonConformity->id"
                                                                                             class="{{\App\Models\Process\NonConformities::class}}"
                                                                                             field="criteria"
                                                                                             :defaultValue="$nonConformity->criteria"
                                                                                             :key="time().$nonConformity->id"/>


                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <x-label-section>Verificación</x-label-section>
                            </div>

                            <div class="col-5">
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-nowrap">
                                        <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                                            <div class="pl-2 content-detail">
                                                <div class="d-flex flex-wrap mt-2">
                                                    <x-label-detail>Dueño de proceso:</x-label-detail>
                                                    <div class="detail mt-2">
                                                        {{$nonConformity->process->owner_id ? $nonConformity->process->owner->getFullName() : ''}}
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap">
                                                    <x-label-detail>SACP levantada por</x-label-detail>

                                                    <livewire:components.dropdown-user :modelId="$nonConformity->id"
                                                                                       modelClass="{{\App\Models\Process\NonConformities::class}}"
                                                                                       field="raised_by"
                                                                                       :key="time().$nonConformity->id"
                                                                                       :user="$nonConformity->raisedBy"/>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="frame-wrap pl-2 mt-2 mb-2">
                                    <div class="custom-control-inline w-20">
                                        <x-label-detail>Verificación de Cierre de SACP:</x-label-detail>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="defaultInline1Radio" name="inlineDefaultRadiosExample" value="1"
                                               wire:model="closingVerification">
                                        <label class="custom-control-label" for="defaultInline1Radio">Si</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="defaultInline2Radio" name="inlineDefaultRadiosExample" value="0"
                                               wire:model="closingVerification">
                                        <label class="custom-control-label" for="defaultInline2Radio">No</label>
                                    </div>
                                    <div class="custom-control-inline">
                                        <x-label-detail> Fecha: {{ $nonConformity->verification_close_date ?
                                        $nonConformity->verification_close_date->format('j F, Y') :''}}</x-label-detail>
                                    </div>
                                </div>
                                <div class="frame-wrap pl-2">
                                    <div class="custom-control-inline w-20">
                                        <x-label-detail> Verificación de Eficacia:</x-label-detail>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="efficiencyVerification1" name="efficiencyVerification" value="1"
                                               wire:model="efficiencyVerification">
                                        <label class="custom-control-label" for="efficiencyVerification1">Si</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="efficiencyVerification2" name="efficiencyVerification" value="0"
                                               wire:model="efficiencyVerification">
                                        <label class="custom-control-label" for="efficiencyVerification2">No</label>
                                    </div>
                                    <div class="custom-control-inline">
                                        <x-label-detail> Fecha: {{ $nonConformity->verification_effectiveness_date ?
                                        $nonConformity->verification_effectiveness_date->format('j F, Y') :''}}</x-label-detail>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <x-label-section>Proceso de Cierre</x-label-section>
                            </div>
                            <div class="col-12 mt-1">
                                <div class="frame-wrap mt-1">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="state2" wire:model="stateWillClosed">
                                        <label class="custom-control-label" for="state2">Proceso de Cierre</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <x-label-section>Cerrar No Conformidad</x-label-section>
                            </div>
                            @if($nonConformity->canBeClosed())
                                <div class="col-12 mt-1">
                                    <div class="frame-wrap mt-1">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="state1" wire:model="state">
                                            <label class="custom-control-label" for="state1">Cerrar</label>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-12 mt-1">
                                    <div class="panel-tag">
                                        No se puede cerrar la No Conformidad
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
