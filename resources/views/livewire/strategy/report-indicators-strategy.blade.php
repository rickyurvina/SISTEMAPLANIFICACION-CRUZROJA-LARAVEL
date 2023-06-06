<div>
    <div class="panel-container show" style="margin-top: -2%;">
        @if($existIndicators)
            <div class="card-header pr-2 d-flex align-items-center flex-wrap">
                <div class="d-flex position-relative ml-auto w-100">
                    <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem" wire:target="search" wire:loading></i>
                    <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem" wire:loading.remove></i>
                    <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                           placeholder="Buscar por nombre del indicador...">
                </div>
            </div>
            <div class="card p-2">
                <livewire:measure.filter-periods :periodId="$periodId"/>
            </div>
            <div class="card">
                <div class="table-responsive">
                    <table class="table  m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th class="text-primary">{{ trans('general.name')}}</th>
                            <th class="text-primary">{{ trans('general.indicator_unit')}}</th>
                            <th class="text-primary">{{ trans('general.score')}}</th>
                            <th class="text-primary">{{ trans('general.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($plans as $plan)
                            @foreach($plan->planDetails as $planDetail)
                                @if(count($planDetail->measures)>0)
                                    <tr style="background-color: #e8ecec" class="text-center">
                                        <td colspan="6" style="font-size: 17px; font-weight: 600">{{$planDetail->name}}-{{$planDetail->plan->name}}</td>
                                    </tr>
                                    @foreach($planDetail->measures as $indicator)
                                        @php
                                            $score= $indicator->score($periodId);
                                        @endphp
                                        <tr>
                                            <td>
                                                <i class="fas fa-stop-circle mr-3" @if(isset( $score['dataUsed']))
                                                    style="color: {{ $score['dataUsed'][0]['color']}}" @endif></i>
                                                <span>
                                                     <i class="{{$indicator->unit ? $indicator->unit->getIcon() :'' }}"></i>
                                                           {{ $indicator->name }}
                                                </span>
                                            </td>
                                            <td>  {{ $indicator->unit ? $indicator->unit->name :'' }}</td>
                                            @if(isset( $indicator->score($periodId)['dataUsed']))
                                                <td class="text-center">
                                                    <span style="color: {{ $score['dataUsed'][0]['color'] }}">
                                                        {{ $score['dataUsed'][0]['score']  }}
                                                    </span>
                                                </td>
                                            @else
                                                <td class="text-center"><span></span></td>
                                            @endif
                                            <th class="w-10 text-center table-th">
                                                @if(Gate::check('strategy-manage-indicator-reports') || Gate::check('strategy-manage'))
                                                    <div class="frame-wrap">
                                                        <div class="d-flex justify-content-start">
                                                            <div class="p-2">
                                                                @if($indicator->scores->sum('score')==0)
                                                                    <a href="javascript:void(0)"
                                                                       data-toggle="modal"
                                                                       data-target="#measure-edit-modal"
                                                                       data-measure-id="{{$indicator->id}}">
                                                                        <i class="fas fa-edit mr-1 text-info"
                                                                           data-toggle="tooltip" data-placement="top" title=""
                                                                           data-original-title="Editar"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="p-2">
                                                                <a href="javascript:void(0)"
                                                                   data-toggle="modal"
                                                                   data-target="#measure-show-modal"
                                                                   data-measure-id="{{$indicator->id}}">
                                                                    <i class="fas fa-eye mr-1 text-success"
                                                                       data-toggle="tooltip" data-placement="top" title=""
                                                                       data-original-title="Ver"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </th>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <x-empty-content>
                <x-slot name="title">
                    No existen indicadores asociados
                </x-slot>
            </x-empty-content>
        @endif
    </div>
    <div wire:ignore.self>
        <livewire:measure.measure-edit/>
    </div>
    <div wire:ignore.self>
        <livewire:measure.measure-show :periodId="$periodId"/>
    </div>
</div>

@push('page_script')
    <script>
        Livewire.on('toggleIndicatorShowModal', () => $('#indicator-show-modal').modal('toggle'));
    </script>
    <script>
        $('#measure-edit-modal').on('show.bs.modal', function (e) {
            let id = $(e.relatedTarget).data('measure-id');
            window.livewire.emitTo('measure.measure-edit', 'show', id);
        });
    </script>
    <script>
        $('#measure-show-modal').on('show.bs.modal', function (e) {
            let id = $(e.relatedTarget).data('measure-id');
            window.livewire.emitTo('measure.measure-show', 'show', id);
        });
    </script>
@endpush
