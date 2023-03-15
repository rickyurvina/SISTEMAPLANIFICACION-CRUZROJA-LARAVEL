<div>
    <x-label-section>{{ $account->code }}</x-label-section>

    <table class="border ex-e-table w-100">
        <tr class="border text-center header">
            <th class="border text-center bold-h4 p-2">FECHA</th>
            <th class="border text-center bold-h4 p-2">COMPROBANTE</th>
            <th class="border text-center bold-h4 p-2">DESCRIPCCIÓN</th>
            <th class="border text-center bold-h4 p-2">ASIG. INI</th>
            <th class="border text-center bold-h4 p-2">REFORMA</th>
            <th class="border text-center bold-h4 p-2">CÓDIFICADO</th>
            <th class="border text-center bold-h4 p-2">COMPROMETIDO</th>
            <th class="border text-center bold-h4 p-2">DEVENGADO</th>
            <th class="border text-center bold-h4 p-2">CERTIFICADO</th>
            <th class="border text-center bold-h4 p-2">POR COMPROMETER</th>
            <th class="border text-center bold-h4 p-2">POR DEVENGAR</th>
        </tr>
        @foreach($transactions as $transaction)
            <tr class="border text-center">
                <td class="border text-center p-2">{{$transaction->transaction->created_at}}</td>
                <td class="border text-center p-2">{{$transaction->transaction->type}}{{$transaction->transaction->number}}</td>
                <td class="border text-center p-2">{{$transaction->transaction->description}}</td>
                <td class="border text-center p-2">{{$account->balanceInitial()}}</td>
                <td class="border text-center p-2">{{$account->balanceRe}}</td>
                <td class="border text-center p-2">{{$account->getBalanceEncodedApproved()}}</td>
                <td class="border text-center p-2">{{$account->balanceCm}}</td>
                <td class="border text-center p-2"></td>
                <td class="border text-center p-2"></td>
                <td class="border text-center p-2"></td>
                <td class="border text-center p-2"></td>
            </tr>
        @endforeach
    </table>
</div>