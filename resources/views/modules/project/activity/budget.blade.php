<div class="d-flex flex-column">
    <x-label-section>{{ trans_choice('budget.budget',1) }}</x-label-section>
    <div class="section-divider"></div>
    @isset($expenses)
        <div class="table-responsive">
            <table class="table table-light table-hover">
                <thead>
                <tr>
                    <th class="table-th w-20">@sortablelink('code', trans('general.item'))</th>
                    <th class="table-th w-30">@sortablelink('name', trans('general.name'))</th>
                    <th class="table-th w-30">@sortablelink('description', trans('general.description'))</th>
                    <th class="table-th w-10">@sortablelink('debit', trans('general.value'))</th>
                </tr>
                </thead>
                <tbody>
                @foreach($expenses as $item)
                    <tr class="tr-hover">
                        <td>
                            <span class="badge {{$item->is_new ? 'badge-warning' : '' }}  badge-pill fs-1x fw-700">{{ $item->code }}</span>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        @if($transaction->status instanceof \App\States\Transaction\Approved)
                            <td>{{ money( $item->balance->getAmount()) }} </td>
                        @else
                            <td>{{ money( $item->balanceDraft->getAmount()) }} </td>
                        @endif
                    </tr>
                @endforeach
                <tr style="background-color: #e0e0e0">
                    <td colspan="3"></td>
                    <td style="color: #008000" class="fs-2x fw-700">Total: {{money($total) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    @else
        <x-empty-content>
            <x-slot name="img">
                <i class="fas fa-money-bill-wave"
                   style="color: #2582fd;"></i>
            </x-slot>
            <x-slot name="title">
                No existen partidas presupuestarias creadas
            </x-slot>
        </x-empty-content>
    @endisset
</div>
