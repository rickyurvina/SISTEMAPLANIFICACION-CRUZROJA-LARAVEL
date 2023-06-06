<div>
    <div class="d-flex flex-wrap">
        <div class="w-30 p-2">
            <div class="d-flex mb-3 w-100">
                <div class="input-group bg-white shadow-inset-f2 w-100 mr-2">
                    <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                           placeholder="{{ trans('general.filter') . ' por Nombre ...'}}"
                           wire:model="search">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent border-left-0">
                            <i class="fal fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="ml-auto mr-2">
            <a href="#" class="btn btn-success btn-md" wire:click="$emit('approveAll')">
                Aprobar
            </a>
        </div>
    </div>
    @if($transaction->status instanceof \App\States\Transaction\Approved)
        <div class="table-responsive">
            <table class="table table-light table-hover">
                <tr class="border text-center header">
                    <th class="border text-center bold-h4 ">Actividad</th>
                    <th class="border text-center bold-h4 "># Partida</th>
                    <th class="border text-center bold-h4 ">ASIG. INI</th>
                    <th class="border text-center bold-h4 ">REFORMA</th>
                    <th class="border text-center bold-h4 ">CODIFICADO</th>
                    <th class="border text-center bold-h4 ">CERTIFICADO</th>
                    <th class="border text-center bold-h4 ">COMPROMETIDO</th>
                    <th class="border text-center bold-h4 ">DEVENGADO</th>
                    <th class="border text-center bold-h4 ">POR COMPROMETER</th>
                    <th class="border text-center bold-h4 ">POR DEVENGAR</th>
                    <th class="border text-center bold-h4 ">PAGADO</th>
                    <th class="border text-center bold-h4 ">{{trans('general.actions')}}</th>
                </tr>
                @foreach($activities as $activity)
                    @foreach($activity->accounts as $account)
                        <tr class="border text-center">
                            @if($loop->first)
                                <td class="border text-center " rowspan="{{$activity->accounts->count()}}">{{$activity->text}}</td>
                            @endif
                            <td class="border text-center ">
                                {{$account->code}}
                            </td>
                            <td>{{ money( $account->balancePr->getAmount()) }} </td>
                            <td class="border text-center ">{{$account->balanceRe}}</td>
                            <td class="border text-center ">{{$account->balanceCeApproved}}</td>
                            <td class="border text-center ">{{$account->balanceCeApproved}}</td>
                            <td class="border text-center ">{{$account->balanceCm}}</td>
                            <td class="border text-center ">0,00 US$</td>
                            <td class="border text-center ">0,00 US$</td>
                            <td class="border text-center ">0,00 US$</td>
                            <td class="border text-center ">0,00 US$</td>
                            <td>
                                <div class="frame-wrap">
                                    <div class="d-flex justify-content-start">
                                        <div class="p-2">
                                            <a href="{{ route('projects.showIndex', $item->id) }}"
                                               aria-expanded="false"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Ficha del Proyecto">
                                                <i class="fas fa-eye text-info"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </table>

        </div>
    @else
        <div class="table-responsive">
            <table class="table table-light table-hover">
                <tr class="border text-center header">
                    <th class="border text-center bold-h4 w-30">{{trans('general.activity')}}</th>
                    <th class="border text-center bold-h4 w-30"># Partida</th>
                    <th class="border text-center bold-h4 w-20">{{trans('general.description')}}</th>
                    <th class="border text-center bold-h4 w-10">Presupuesto</th>
                    <th class="border text-center bold-h4 w-10">{{trans('general.status')}}</th>
                    <th class="border text-center bold-h4 w-10">{{trans('general.actions')}}</th>
                </tr>
                @foreach($activities as $activity)
                    @foreach($activity->accounts as $account)
                        <tr class="border text-center">
                            @if($loop->first)
                                <td class="border text-center " rowspan="{{$activity->accounts->count()}}">{{$activity->name}}</td>
                            @endif
                            <td class="border text-center ">
                                    {{$account->code}}
                            </td>
                            <td class="border text-center">
                                {{ $account->description}}
                            </td>
                            <td class="border text-center ">
                                {{ money( $account->balancePrDraft->getAmount()) }}
                            </td>
                            <td class="border text-center">
                                <span class=" badge badge-pill {{ $account->transactionsPrDraft->first()->status::color() }}">
                                    {{$account->transactionsPrDraft->first()->status}}
                                </span>
                            </td>
                            <td class="border text-center">
                                <div class="frame-wrap">
                                    <div class="d-flex justify-content-center">
                                        <div class="p-2" aria-expanded="false"
                                             data-toggle="tooltip" data-placement="top" title=""
                                             data-original-title="Aprobar Presupuesto">
                                            <a href="#"
                                               data-toggle="modal"
                                               data-account-id="{{ $account->id }}"
                                               data-activity-id="{{ $activity->id }}"
                                               data-target="#budget-expense-project-approve-from-project">
                                                <i class="fas fa-check-circle mr-1 text-info"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
        <x-pagination :items="$activities"/>
    @endif
    <livewire:budget.expenses.project.expense-project-activity-approve-from-budget :transactionId="$transaction->id" class="{{\App\Models\Poa\PoaActivity::class}}"/>
</div>
@push('page_script')

    <script>
        Livewire.on('toggleExpenseApprove', () => $('#budget-expense-project-approve-from-project').modal('toggle'));
        $('#budget-expense-project-approve-from-project').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let accountId = $(e.relatedTarget).data('account-id');
            let activityId = $(e.relatedTarget).data('activity-id');
            //Livewire event trigger
            Livewire.emit('loadApprove', accountId, activityId);
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            @this.
            on('approveAll', id => {
                Swal.fire({
                    title: '{{ trans('messages.warning.sure') }}',
                    text: '{{ trans('general.approve_all_budget_activity_poa') }}',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--success)',
                    confirmButtonText: '<i class="fas fa-check-circle"></i> {{ trans('general.yes') . ', ' . trans('general.approve') }}',
                    cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
                }).then((result) => {
                    if (result.value) {
                        @this.
                        call('approveAllBudget', id);
                    }
                });
            });
        })
    </script>
@endpush