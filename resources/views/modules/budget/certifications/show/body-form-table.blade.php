<tr class="tr-hover">
    <td><span class="badge {{$item->is_new ? 'badge-warning' : '' }}  badge-pill fs-1x fw-700">{{ $item->code }} {{$item->name}}</span>
    </td>
    <td>{{ $item->id }}</td>
    <td>{{ $item->description }}</td>
    @if($transaction->status instanceof  \App\States\Transaction\Approved)
        <td>
            {{ $item->balance }}
        </td>
        <td>
            {{ $transaction->expenseCertifications($item->id) }}
        </td>
    @else
        <td class="@if($item->balance->getAmount()< $transaction->expenseCertifications($item->id)->getAmount() )color-danger-700 @endif">
            {{ $item->balance }}
        </td>
        <td class="@if($item->balance->getAmount()< $transaction->expenseCertifications($item->id)->getAmount() )color-danger-700 @endif">
            {{ $transaction->expenseCertifications($item->id) }}
        </td>
    @endif

</tr>