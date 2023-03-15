<table>
    <thead>
    <tr>
        <th  colspan="3">{{$project->name}}</th>
        <th  colspan="3">{{$companyName}}</th>
    </tr>
    <tr>
        <th>{{__('general.code')}}</th>
        <th>{{__('general.name')}}</th>
        <th>{{__('general.responsable')}}</th>
        <th>{{__('general.assumptions')}}</th>
        <th>{{trans_choice('general.indicators',2)}}</th>
        <th>{{__('general.services')}}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($results as $item)
        <tr>
            <td>{{$item->code ?? '-'}}</td>
            <td>{{$item->text ?? '-'}}</td>
            <td>{{$item->responsible->name ?? '-'}} </td>
            <td>{{$item->assumptions ?? '-'}}</td>
            <td>
                @foreach($item->indicators as $indicator)
                 {{  $indicator->name ?? '-' }} <br>
                @endforeach
            </td>
            <td>
                @foreach($item->services as $service)
                    {{  $service->name ?? '-' }} <br>
                @endforeach
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">
                No se encontraron resultados
            </td>
        </tr>
    @endforelse
    </tbody>
</table>