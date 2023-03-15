<div>
    <div class="card-body">
        @if($results)
            <div class="table-responsive">
                <table class="table m-0 mx-auto">
                    <tr class="bg-primary-50">
                        <th class="w-20">Nombre Resultado  <x-tooltip-help message="{{$messages->where('code','presupuesto')->first()->description}}"> </x-tooltip-help>
                        </th>
                        @foreach($funders as $funder)
                            <th class="w-10">{{$funder->name}}</th>
                        @endforeach
                        <th class="w-auto">Monto total</th>
                    </tr>

                    @foreach($results as $result)
                        <tr>
                            <td class="text-truncate-xs text-truncate-lg text-truncate-md">{{ $result->name}}</td>
                            @foreach($funders as $index => $funder)
                                <td class="">
                                    <input type="text" wire:model="plans.{{$result->id}}.{{$index+1}}" class="form-control bg-transparent pl-0" style="width: auto">
                                </td>
                            @endforeach
                            @if(isset($plans[$result['id']]))
                                <td>
                                    {{ '$'.number_format(array_sum($plans[$result->id]),2) }}
                                </td>
                            @else
                                <td>$0.00</td>
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <th class="w-10">Total</th>
                        @foreach($funders as $index => $funder)
                            <td class="">
                                {{ '$'.number_format(array_sum(array_column($plans,$index+1)),2) }}
                            </td>
                        @endforeach
                        <td>
                            {{ '$'.number_format($project->estimated_amount,2) }}
                        </td>
                    </tr>
                </table>
            </div>
        @else
            <x-empty-content>
                <x-slot name="title">
                    No existen resultados o plazo establecido
                </x-slot>
            </x-empty-content>

        @endif
    </div>
</div>