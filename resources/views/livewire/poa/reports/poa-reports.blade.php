<div>
    @include('modules.poa.reports.activities.header')
    @if($poa)
        <div class="card">
            <div class="card-header pr-2 d-flex align-items-center flex-wrap">
                <div class="d-flex position-relative ml-auto w-100">
                    <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem" wire:target="search" wire:loading></i>
                    <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem" wire:loading.remove></i>
                    <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                           placeholder="Buscar por Nombre de la Actividad...">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm m-0">
                    <thead class="bg-primary-50">
                    <tr>
                        <th class="w-20">{{trans('general.program')}}</th>
                        <th class="w-20">{{trans('general.indicator')}}</th>
                        <th class="w-20">{{trans('general.activity')}}</th>
                        <th class="w-10">{{trans('general.goal')}}</th>
                        <th class="w-10">{{trans('general.actual')}}</th>
                        <th class="w-10">{{trans('general.progress')}}</th>
                        <th class="w-10"> {{trans('general.community')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color: #e8ecec" class="text-center align-items-center">
                        <td colspan="8" style="font-size: 17px; font-weight: 600">
                            <div class="d-flex justify-content-center chart">
                            <span class="p-3">
                                 {{ $poa->company->name }}  {!! $poa->thresholdProgress()!!}
                            </span>
                            </div>
                        </td>
                    </tr>
                    @foreach($poa->programs as $program)
                        @foreach($program->poaActivities as $activity)
                            <tr>
                                @if($loop->first)
                                    <td rowspan="{{$program->poaActivities->count()}}">{{ $program->planDetail->name }}</td>
                                @endif
                                <td>
                                     <span>
                                         <i class="{{$activity->measure->unit->getIcon() }}"></i>
                                          {{ $activity->measure->name }}
                                    </span>
                                 </td>
                                <td>
                                    <a href="javascript:void(0);" aria-expanded="false"
                                       wire:click="$emitTo('poa.reports.poa-show-activity', 'open', {{ $activity->id }})">
                                        {{ $activity->name }}
                                    </a>
                                </td>
                                <td>{{ $activity->measureAdvances->sum('goal') }}</td>
                                <td>{{ $activity->measureAdvances->sum('actual') }}</td>
                                <td>{!!  $activity->thresholdProgressPoaActivity() !!}</td>
                                @if($activity->location)
                                    <td>{{  $activity->location->getPath()  }} / {{ $activity->community }}</td>
                                @else
                                    <td>'N/A'</td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <x-empty-content>
            <x-slot name="img">
                <img src="{{ asset_cdn("img/no_info.png") }}" width="auto" height="auto" alt="No Info">
            </x-slot>
        </x-empty-content>
    @endif
</div>
<div wire:ignore>
    <livewire:poa.reports.poa-show-activity/>
</div>

@push('page_script')
    <script>
        Livewire.on('toggleShowModal', () => $('#poa-show-activity-modal').modal('toggle'));
        Livewire.on('toggleDropDownFilter', () => $("#dropdown-filter").removeClass("show"));
    </script>
@endpush