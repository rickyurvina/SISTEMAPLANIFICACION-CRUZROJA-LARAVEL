<div class="table-responsive">
    <table class="table table-light table-hover">
        <thead>
        <tr>
            <th class="table-th w-20">{{trans('general.item')}}</th>
            <th class="table-th w-20"> {{trans('general.name')}}</th>
            <th class="table-th w-30"> {{trans('general.description')}}</th>
            <th class="table-th w-10">Certificado</th>
            <th class="table-th w-10">Comprometido</th>
        </tr>
        </thead>
        <tbody>
        @foreach($accounts as $item)
            <tr class="tr-hover">
                <td><span class="badge {{$item->is_new ? 'badge-warning' : '' }}  badge-pill fs-1x fw-700">{{ $item->code }} {{$item->name}}</span>
                </td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->description }}</td>
                <td class="@if($item->getCertifiedValues($certification->id) < $transaction->expenseCommitments($item->id) )color-danger-700 @endif">
                    {{ $item->getCertifiedValues($certification->id)  }}
                </td>
                <td class="@if($item->getCertifiedValues($certification->id)< $transaction->expenseCommitments($item->id) )color-danger-700 @endif">
                    {{ $transaction->expenseCommitments($item->id) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>