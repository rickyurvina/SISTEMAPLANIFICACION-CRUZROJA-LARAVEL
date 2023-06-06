<div>
    <div class="card-body">
{{--        @if($limitSup>12)--}}
            <div class="mr-auto p-2">
                <a href="javascript:void(0);" wire:click="decreaseTime()" class="btn btn-outline-success btn-sm btn-icon waves-effect waves-themed">
                    <i class="fal fa-chevron-double-left"></i>
                </a>
                <a href="javascript:void(0);" wire:click="plusTime()" class="btn btn-outline-success btn-sm btn-icon waves-effect waves-themed">
                    <i class="fal fa-chevron-double-right"></i>
                </a>
            </div>
{{--        @endif--}}
        @if($limitSup && $existsResults)
            <div class="table-responsive">
                <table class="table m-0">
                    <tr class="bg-primary-50">
                        <th class="w-30 p-2">Nombre Resultado
                            <x-tooltip-help message="Permite seleccionar los meses donde se realizarán los resultados"></x-tooltip-help>

                            @if($messagesList)
                                <x-tooltip-help message="{{$messagesList->where('code','cronograma')->first()->description}}"></x-tooltip-help>
                            @endif
                        </th>
                        @for($i=$limitMin; $i<=$limitSup;$i++)
                            <th class="w-5 p-2">Mes-{{$i}}</th>
                        @endfor
                    </tr>
                    @foreach($results as $result)
                        <tr wire:key="{{$result->id.time()}}" wire:ignore.self>
                            <td class="w-30" style="word-wrap: break-word">
                                <div class="d-flex flex-wrap">
                                    {{ $result->text }}
                                    <a href="javascript:void(0);" wire:click="selectRow({{$result->id}})"
                                       class="ml-4 btn btn-outline-success ml-auto btn-sm btn-icon rounded-circle">
                                        <i class="fal fa-check"></i>
                                    </a>
                                </div>
                            </td>
                            @for($i=$limitMin; $i<=$limitSup;$i++)
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