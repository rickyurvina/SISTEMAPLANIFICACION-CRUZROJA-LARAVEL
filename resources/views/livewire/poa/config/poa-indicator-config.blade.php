@if(count($data)<1)
    <x-empty-content>
        <x-slot name="title">
            {{trans('general.there_are_no_programs_neither_indicators')}}
        </x-slot>
    </x-empty-content>
@else
    <div class="card">
        <div class="row">
            <div class="col-8">
                <div class="panel-tag">
                    {{ __('general.poa_indicator_config_card_body') }}
                </div>
            </div>
            @if($showButtonDeleteIndicators==false)
                <div class="col-4">
                    <button wire:click="deletePrograms" class="btn btn-sm btn-danger waves-effect waves-themed ml-auto">
                        <span class="fal fa-times mr-1"></span>
                        Eliminar Indicadores Asociados
                    </button>
                </div>
            @endif
        </div>
        <br>
        @if(count($data)>=1)
            <div class="row">
                <div class="col-12">
                    <table class="col-12 border border-dark">
                        <thead class="bg-primary-50 border border-dark">
                        <tr class="border border-dark">
                            <th class="border border-dark text-center">Programa - Objetivo Especifico</th>
                            <th class="border border-dark text-center w-10">Selección</th>
                            <th class="border border-dark text-center">Justificación</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php ($auxProgramName = "")
                        @for($i=0;$i<count($data);$i++)
                            @if ($auxProgramName!=$data[$i]['planDetailName'])
                                <tr class="bg-gray-400 border border-dark">
                                    <td>{{$data[$i]['planDetailName']}} - {{$data[$i]['specificGoal']}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                            <tr class="border border-dark">
                                <td>{{$data[$i]['indicatorName']}}</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input wire:model="data.{{$i}}.id"
                                               wire:change="checkActivities({{$data[$i]['measureId']}},{{$data[$i]['programId']}},{{$i}})"
                                               type="checkbox" class="custom-control-input"
                                               @if ($data[$i]['national'] == true) disabled @endif id="customSwitch2_{{$i}}"
                                               value="{{$data[$i]['measureId']}}">
                                        <label class="custom-control-label" for="customSwitch2_{{$i}}"></label>
                                    </div>
                                </td>
                                <td><textarea wire:model.defer="data.{{$i}}.reason" rows="4" cols="50"
                                              class="form-control @error('data.'.$i.'.reason') is-invalid @enderror" type="text"
                                              name="data.{{$i}}.reason"
                                              value="{{$data[$i]['reason']}}" id="data.{{$i}}.reason">
                            </textarea>
                                </td>
                            </tr>
                            @php ($auxProgramName = $data[$i]['planDetailName'])
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            @if(!$poa->isClosed())
                <div class="row">
                    <div class="col-12" style="display:flex;justify-content:center">
                        <a href="{{ route('poa.poas') }}" class="btn btn-outline-secondary mr-1">
                            <span class="fal fa-times"></span>
                            {{ trans('general.cancel') }}
                        </a>
                        <button wire:click="saveConfig" type="button" class="btn btn-primary">
                            <span class="fas fa-save pr-2"></span>
                            {{ trans('general.save') }}
                        </button>
                    </div>
                </div>
            @endif

        @endif
        @endif
    </div>