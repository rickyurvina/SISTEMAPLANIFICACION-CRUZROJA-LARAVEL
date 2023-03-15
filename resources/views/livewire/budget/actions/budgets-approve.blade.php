<div wire:ignore.self class="modal fade fade" id="budgets-approve" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4"><i
                                class="fas fa-check-circle text-success"></i> {{ trans('general.poa_approve')  }} {{trans('general.module_budget')}} @if($budget) {{$budget->year}} @endif
                    </h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="border: 1px solid #e5e5e5; height: 200px; overflow: auto; padding: 10px;">
                        <p>Al aprobar la proforma presupuestaria, usted como Director, (a). Financiero, (a), confirma que se ha verificado el cumplimiento del Art. 198 del COOTAD
                            que indica textualmente lo siguiente:</p>
                        <p>Destino de las Transferencias.- las transferencias que efectúa el gobierno central a los gobiernos autónomos descentralizados podrán financiar hasta el
                            treinta por ciento (30%) de gastos permanentes, y un mínimo del setenta por ciento (70%) de gastos no permanentes necesarios para el ejercicio de sus
                            competencias exclusivas con base en la planificación de cada gobierno autónomo descentralizado. Las transferencias provenientes de al menos el diez
                            (10%) por ciento de los ingresos no permanentes, financiarán egresos no permanentes.</p>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="terms" wire:model="terms">
                        <label class="custom-control-label" for="terms">He leído y estoy de acuerdo con los Téminos y Condiciones</label>
                    </div>
                    @if($budget)
                        <div class="d-flex flex-wrap">
                            <div class="mt-2 w-100">
                                <livewire:components.files :modelId="$budget->id"
                                                           model="\App\Models\Budget\Transaction"
                                                           folder="transactions"/>
                            </div>
                            <div class="mt-2 w-100">
                                <x-label-section>{{ trans('general.comments') }}</x-label-section>
                                <livewire:components.comments :modelId="$budget->id"
                                                              class="\App\Models\Budget\Transaction"
                                                              :key="time().$budget->id"
                                                              identifier="transactions"/>
                            </div>
                        </div>
                    @endif
                </div>
                @if($terms)
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-success" wire:click="submit">
                            <i class="fas fa-save pr-2"></i> {{ trans('general.poa_approve') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
