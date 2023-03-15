<div>
    <div wire:ignore.self class="modal fade fade" id="budget-expense-project-approve-from-project" style="display: none;" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4"><i class="fas fa-check-circle text-success"></i> Pre-Aprobación Partida Presupuestaria</h5>
                    <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                @if($transactionDetail)
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered detail-table">
                                    <tbody>
                                    <tr>
                                        <td># Partida Presupuestaria</td>
                                        <td>{{$account->code}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('general.description')}}</td>
                                        <td>{{$transactionDetail->description}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('general.amount')}}</td>
                                        <td>{{ money( $account->balancePrDraft->getAmount()) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('general.activity')}}</td>
                                        <td> {{$this->activity->text ?? $this->activity->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{trans('general.status')}}</td>
                                        <td>
                                           <span class=" badge badge-pill {{ $account->transactionsPrDraft->first()->status::color() }}">
                                                 {{$account->transactionsPrDraft->first()->status}}
                                            </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($transactionDetail->status instanceof \App\States\TransactionDetails\Draft)
                            <div style="border: 1px solid #e5e5e5; overflow: auto; padding: 10px;" class="mt-1">
                                <p>
                                    Al Pre-Aprobar la partida presupuestaria este monto se verá reflejado en el presupuesto general de la Junta para su posterior aprobación
                                    general.
                                </p>
                            </div>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" id="terms" wire:model="terms">
                                <label class="custom-control-label" for="terms">He leído y estoy de acuerdo con los Téminos y Condiciones</label>
                            </div>
                        @endif


                        <div class="d-flex flex-wrap">
                            <div class="mt-2 w-100">
                                <livewire:components.files :modelId="$transactionDetail->id"
                                                           model="{{\App\Models\Budget\TransactionDetail::class}}"
                                                           folder="approveFromProject"/>
                            </div>
                            <div class="mt-2 w-100">
                                <x-label-section>{{ trans('general.comments') }}</x-label-section>
                                <livewire:components.comments :modelId="$transactionDetail->id"
                                                              class="{{\App\Models\Budget\TransactionDetail::class}}"
                                                              :key="time().$transactionDetail->id"
                                                              identifier="approveFromProject"/>
                            </div>
                        </div>
                        @if($terms && $transactionDetail->status instanceof \App\States\TransactionDetails\Draft)
                            <div class="modal-footer justify-content-center">
                                <button class="btn btn-danger" wire:click="save(0)">
                                    <i class="fas fa-save pr-2"></i> {{ trans('general.decline') }}
                                </button>
                                <button class="btn btn-success" wire:click="save(1)">
                                    <i class="fas fa-save pr-2"></i> {{ trans('general.poa_approve') }}
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
