<div>
    <div class="card-body">
        @if($time && $existsResults)
            <div class="table-responsive">
                <table class="table m-0">
                    <tr class="bg-primary-50">
                        <th>Nombre Resultado
                            @if($messagesList)
                                <x-tooltip-help message="{{$messagesList->where('code','cronograma')->first()->description}}"></x-tooltip-help>
                            @endif
                        </th>
                        @for($i=1; $i<=$time;$i++)
                            <th>Mes-{{$i}}</th>
                        @endfor
                    </tr>
                    @foreach($results as $result)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{$result->text}}
                                    <a href="javascript:void(0);" wire:click="selectRow({{$result->id}})"
                                       class="ml-4 btn btn-outline-success ml-auto btn-sm btn-icon rounded-circle">
                                        <i class="fal fa-check"></i>
                                    </a>
                                </div>
                            </td>
                            @for($i=1; $i<=$time;$i++)
                                <td class="">
                                    <input type="checkbox" wire:model="plans.{{$result->id}}.{{$i}}">
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <x-empty-content>
                <x-slot name="title">
                    No existen actividades
                </x-slot>
            </x-empty-content>
        @endif
    </div>
</div>