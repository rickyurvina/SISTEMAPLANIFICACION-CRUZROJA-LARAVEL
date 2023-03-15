<div class="d-flex flex-nowrap mt-2">
    <div class="flex-grow-1 w-auto" style="overflow: hidden auto">
        <div class="d-flex flex-wrap">
            <x-label-section>Cronograma- Año Fiscal {{ date("Y")}}</x-label-section>
            <div class="ml-auto pr-4">
                <x-label-section>Avance
                    Físico {{$project->physicProgress()}}%
                </x-label-section>
            </div>
            <div class="ml-auto">
                <button type="button" class="btn btn-sm btn-outline-secondary mr-2"
                        data-toggle="modal"   data-target="#project-objectives-weight">
                    {{ __('general.weight') }} {{ trans('general.objectives_name') }}
                </button>
{{--                <button type="button" class="btn btn-sm btn-outline-secondary mr-4"--}}
{{--                        data-toggle="modal" data-target="#project-activities-wbs"--}}
{{--                        data-id="{{ $project->id }}">--}}
{{--                    WBS--}}
{{--                </button>--}}
            </div>
        </div>
        <div class="section-divider"></div>
        <div class="row">
            <div class="col-10">
                <div class="d-flex flex-wrap">
                    <x-label-detail>{{ trans_choice('general.project',1) }}</x-label-detail>
                    <x-content-detail>{{ $project->name}}</x-content-detail>
                </div>
                <div class="d-flex flex-wrap">
                    <x-label-detail>{{ trans('general.start_date') }}</x-label-detail>
                    <x-content-detail>{{$project->start_date?  $project->start_date->format('j F, Y') :'' }} </x-content-detail>
                </div>
                <div class="d-flex flex-wrap">
                    <x-label-detail>{{ trans('general.end_date') }}</x-label-detail>
                    <x-content-detail>{{$project->end_date? $project->end_date->format('j F, Y') :'' }}</x-content-detail>
                </div>
            </div>
            <div class="col-2">
                <div class="d-flex flex-wrap">
                    <x-label-detail>Terminada</x-label-detail>
                    <i class="fas fa-circle color-success-700 mt-2"></i>
                </div>
                <div class="d-flex flex-wrap">
                    <x-label-detail>En tiempo</x-label-detail>
                    <i class="fas fa-circle color-info-700 mt-2"></i>
                </div>
                <div class="d-flex flex-wrap">
                    <x-label-detail>Atraso</x-label-detail>
                    <i class="fas fa-circle color-danger-700 mt-2"></i>
                </div>
            </div>
        </div>

    </div>
    <div class="w-50">
        <div class="row">
            <div class="col-4 text-center">
                <x-label-section> Estado A la Fecha</x-label-section>
                <div class="mt-4" wire:ignore>
                    <div class="js-easy-pie-chart {{$project->calcSemaphore()}}
                                                                position-relative d-inline-flex align-items-center justify-content-center"
                         data-percent="{{$project->physicProgressUntilDate()}}"
                         data-piesize="100" data-linewidth="7" data-linecap="round"
                         data-scalelength="7">
                        <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                            <span class="js-percent d-block text-dark"></span>
                            <div class="d-block fs-xs text-dark opacity-70">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 text-center">
                <x-label-section> Estado Actual Del Proyecto</x-label-section>
                <div class="mt-4" wire:ignore>
                    <div class="js-easy-pie-chart color-info-700
                                                                position-relative d-inline-flex align-items-center justify-content-center"
                         data-percent="{{$project->physicProgress()}}"
                         data-piesize="100"
                         data-linewidth="7" data-linecap="round"
                         data-scalelength="7">
                        <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                            <span class="js-percent d-block text-dark"></span>
                            <div class="d-block fs-xs text-dark opacity-70">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <x-label-section> % Avance de Tiempo</x-label-section>
                <div class="mt-4">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success"
                             role="progressbar"
                             style="width: {{$project->getProgressTimeUpDate()}}%"
                             aria-valuenow="{{$project->getProgressTimeUpDate()}}"
                             aria-valuemin="0"
                             aria-valuemax="100">{{$project->getProgressTimeUpDate()}}
                            %
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>