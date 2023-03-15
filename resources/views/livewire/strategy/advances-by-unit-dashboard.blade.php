<div>
    <div class="col-lg-12 col-xl-12 pl-lg-3">
        <div class="d-flex mt-2 mb-2">
            <i class="fal fa-users mr-2 text-success"></i> {{trans('general.people_reached')}}
            <span class="badge badge-success badge-pill ml-1">
                {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::PEOPLE_REACHED]['progress']}}%
            </span>
            <x-tooltip-help message="Resumen de Avances vs Metas. Los resultados mostrados corresponden al periodo seleccionado"></x-tooltip-help>
            <span class="d-inline-block ml-auto"> <strong class="font-weight-bold">{{trans('general.advance')}}: </strong> {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::PEOPLE_REACHED]['actual']}} /
             <strong class="font-weight-bold">{{trans('general.goal')}}: </strong>      {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::PEOPLE_REACHED]['goal']}}
            </span>
        </div>
        <div class="progress progress-sm mb-3">
            <div class="progress-bar bg-success-500" role="progressbar"
                 style="width: {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::PEOPLE_REACHED]['progress']}}%;"
                 aria-valuenow="{{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::PEOPLE_REACHED]['progress']}}"
                 aria-valuemin="0"
                 aria-valuemax="100"></div>
        </div>
        <div class="d-flex mt-2 mb-2">
            <i class="fal fa-users-class mr-2 text-warning"></i> {{trans('general.trained_people')}}
            <span class="badge badge-warning badge-pill ml-1">
                {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::TRAINED_PEOPLE]['progress']}}%
            </span>
            <x-tooltip-help message="Resumen de Avances vs Metas. Los resultados mostrados corresponden al periodo seleccionado"></x-tooltip-help>
            <span class="d-inline-block ml-auto"><strong class="font-weight-bold">{{trans('general.advance')}}: {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::TRAINED_PEOPLE]['actual']}} /
             <strong class="font-weight-bold">{{trans('general.goal')}}: </strong>     {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::TRAINED_PEOPLE]['goal']}}
            </span>
        </div>
        <div class="progress progress-sm mb-3">
            <div class="progress-bar bg-warning-600" role="progressbar"
                 style="width: {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::TRAINED_PEOPLE]['progress']}}%;"
                 aria-valuenow="{{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::TRAINED_PEOPLE]['progress']}}"
                 aria-valuemin="0"
                 aria-valuemax="100"></div>
        </div>
        <div class="d-flex mb-2">
            <i class="fal fa-file-chart-line mr-2 text-info"></i> {{trans('general.products')}}
            <span class="badge badge-info badge-pill ml-1">
                {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::DOCUMENTS]['progress']}}%
            </span>
            <x-tooltip-help message="Resumen de Avances vs Metas. Los resultados mostrados corresponden al periodo seleccionado"></x-tooltip-help>
            <span class="d-inline-block ml-auto"> <strong class="font-weight-bold">{{trans('general.advance')}}: </strong>  {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::DOCUMENTS]['actual']}} /
              <strong class="font-weight-bold">{{trans('general.goal')}}: </strong>    {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::DOCUMENTS]['goal']}}
            </span>
        </div>
        <div class="progress progress-sm mb-3">
            <div class="progress-bar bg-info-400" role="progressbar"
                 style="width:  {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::DOCUMENTS]['progress']}}%;"
                 aria-valuenow=" {{$resultsByUnit[\App\Models\Indicators\Units\IndicatorUnits::DOCUMENTS]['progress']}}"
                 aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
    </div>
</div>
