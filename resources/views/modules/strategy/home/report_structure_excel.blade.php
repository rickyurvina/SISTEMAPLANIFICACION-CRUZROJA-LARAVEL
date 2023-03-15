<table class="table  m-0">
    <thead class="bg-primary-50">
    <tr>
        <th class="text-primary">name_program</th>
        <th class="text-primary">code_program</th>
        <th class="text-primary">name_result</th>
        <th class="text-primary">code_result</th>
        <th class="text-primary">code_indicator</th>
        <th class="text-primary">Nombre Indicador</th>
    </tr>
    </thead>
    <tbody>
    @foreach($measures as $measure)
        <tr>
            <td>{{$measure->indicatorable->parent->name}}</td>
            <td>{{$measure->indicatorable->parent->code}}</td>
            <td>{{$measure->indicatorable->name}}</td>
            <td>{{$measure->indicatorable->code}}</td>
            <td>{{$measure->code}}</td>
            <td>{{$measure->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>