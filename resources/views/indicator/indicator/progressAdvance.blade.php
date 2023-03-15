@extends('layouts.admin')
@section('title', trans('indicators.indicator.show_advance')))

@section('subheader-title')
    <i class="fal fa-plus text-primary"></i> {{ trans('indicators.indicator.show_advance') }}
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row" style="display: flex; justify-content: center">
                <div class="col-lg-12" style="margin: 0 auto">
                    <div id="panel-11" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                {{trans('indicators.indicator.progress_report')}}
                            </h2>
                        </div>
                        @if($indicator->progressIndicator())
                            <div class="panel-container show">
                                <div class="panel-content">

                                    <div class="table-responsive">
                                        <table class="table m-0" id="table_thresholds">
                                            <thead class="bg-primary-50">
                                            <tr class="text-center">
                                                <th style="display: none">Id</th>
                                                <th>@sortablelink('number', trans('indicators.indicator.number'))</th>
                                                <th>@sortablelink('name', trans('indicators.indicator.name'))</th>
                                                <th>@sortablelink('status', trans('indicators.indicator.status'))</th>
                                                <th>@sortablelink('advance', trans('indicators.indicator.period_progress'))</th>
                                                <th>@sortablelink('final_goal', trans('indicators.indicator.final_goal'))</th>
                                                <th>@sortablelink('period_result', trans('indicators.indicator.period_result'))</th>
                                                <th>@sortablelink('last_updated_period', trans('indicators.indicator.last_updated_period'))</th>
                                                <th>@sortablelink('date_for_last_updated', trans('indicators.indicator.date_for_last_updated'))</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr class="text-center">
                                                <td style="width: 5%">
                                                    <label>Nro </label>
                                                </td>
                                                <td style="width: 20%">
                                                    <label>{{$indicator->name}}</label>
                                                </td>
                                                <td style="width: 5%">
                                                    <label>{{$indicator->status}}</label>
                                                </td>
                                                <td style="width: 7%">
                                                    <span class="form-label badge {{$indicator->getStateIndicator()[0]}}  badge-pill">{{$indicator->getStateIndicator()[1]}}</span>
                                                </td>
                                                <td style="width: 7%">
                                                    <label>{{number_format($indicator->goalsRegister(),2) }}</label>
                                                </td>
                                                <td style="width: 7%">
                                                    <label>{{number_format($indicator->progressIndicator(),2) }}</label>
                                                </td>
                                                <td style="width: 10%">
                                                    <label>{{$indicator->lastMonthRegister()}}</label>
                                                </td>
                                                <td style="width: 10%">
                                                    <label>{{$indicator->updated_at}}</label>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel-container show">
                                        <div class="panel-content">
                                            <h1>{{trans('general.There_are_no_actual_values')}}{{$indicator->name}}</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
