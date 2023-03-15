{{--<div class="text-right w-100">--}}
{{--    <a href="{{ route('report.poa') }}" class="btn btn-outline-primary btn-xs shadow-0"><i class="fas fa-file-pdf"></i> Exportar</a>--}}
{{--</div>--}}

<div class="d-flex align-items-start mt-3">
    <div class="d-flex flex-column align-items-start w-33">
        <div class="p-3 bg-red-cre rounded overflow-hidden position-relative mb-3 w-100">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                {{ ($sumHombresAlcanzadas + $sumMujeresAlcanzadas) ?? 0 }} <small style="font-size: 14px; display: inline"> / {{ $totalGoal }}</small>
                <small class="m-0 l-h-n" style="font-size: 18px; font-weight: 700">{{trans('common.people_reached')}}</small>
            </h3>
            <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
        <div class="d-flex align-items-center w-100">
            <div class="px-3 py-1 bg-red-cre rounded overflow-hidden position-relative mb-3 w-50">
                <h3 class="display-4 d-block l-h-n m-0 fw-300">
                    {{$sumHombresAlcanzadas ?? 0}}
                    <small class="m-0 l-h-n">{{trans('common.mens')}}</small>
                </h3>
                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
            </div>
            <div class="px-3 py-1 bg-red-cre rounded overflow-hidden position-relative mb-3 w-50 ml-2">
                <h3 class="display-4 d-block l-h-n m-0 fw-300">
                    {{$sumMujeresAlcanzadas ?? 0}}
                    <small class="m-0 l-h-n">{{trans('common.womens')}}</small>
                </h3>
                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
            </div>
        </div>
        <div id="chartPersonalAlcanzado" style="width: 100%; height: 360px;"></div>
    </div>
    <div class="d-flex flex-column align-items-start w-33 ml-2">
        <div class="p-3 bg-blue-cre rounded overflow-hidden position-relative mb-3 w-100">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    {{ ($sumMujeresCapacitadas + $sumHombresCapacitadas ) ?? 0 }} <small
                            style="font-size: 14px; display: inline"> / {{ $this->totalGoalCapacitadas }}</small>
                    <small class="m-0 l-h-n" style="font-size: 18px; font-weight: 700">{{trans('common.people_certified')}}</small>
                </h3>
            </div>
            <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
        </div>
        <div class="d-flex align-items-center w-100">
            <div class="px-3 py-1 bg-blue-cre rounded overflow-hidden position-relative mb-3 w-50">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-300">
                        {{ $sumHombresCapacitadas ?? 0}}
                        <small class="m-0 l-h-n">{{trans('common.mens')}}</small>
                    </h3>
                </div>
                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
            </div>
            <div class="px-3 py-1 bg-blue-cre rounded overflow-hidden position-relative mb-3 w-50 ml-2">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-300">
                        {{ $sumMujeresCapacitadas ?? 0 }}
                        <small class="m-0 l-h-n">{{trans('common.womens')}}</small>
                    </h3>
                </div>
                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
            </div>
        </div>
        <div id="chartPersonalCapacitado" style="width: 100%; height: 360px;"></div>
    </div>
    <div class="d-flex flex-column align-items-start w-33 ml-2">
        <div class="p-3 bg-red-cre rounded overflow-hidden position-relative mb-3 w-100">
            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                {{ $calificacionServicio ?? 0 }}%
                <small class="m-0 l-h-n" style="font-size: 18px; font-weight: 700">{{trans('common.grade_service')}}</small>
            </h3>
            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
        </div>
        <div id="chartCalificacionServicio" style="width: 100%; height: 360px;"></div>
    </div>
</div>

<div class="d-flex align-items-start mt-3">
    <div class="d-flex flex-column w-50">
        <h2 class="text-center fw-700 fs-3x">
            {{trans('general.People_reached_by_program')}}
        </h2>
        <div id="chartPersonalAlcanzadoPrograma" style="width: 100%; height: 360px;"></div>
    </div>
    <div class="d-flex flex-column ml-3 w-50">
        <h2 class="text-center fw-700 fs-3x">
            {{trans('general.Humanitarian_personnel_trained_by_program')}}
        </h2>
        <div id="chartPersonalHumanitarioCapacitado" style="width: 100%; height: 360px;"></div>
    </div>
</div>

