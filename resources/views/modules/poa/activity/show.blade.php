@extends('layouts.admin')

@section('title', __('poa.activities_poa'))

@push('css')
    <style>
        .subheader {
            margin-bottom: 8px !important;
        }
    </style>
@endpush

@section('breadcrumb')
    <ol class="breadcrumb bg-transparent pl-0 pr-0 mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('poa.poas') }}">
                {{ trans('poa.list_poas') }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('poas.activities.index', ['poa' => $activity->program->poa->id]) }}">
                {{ trans_choice('general.activities', 2) }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ $activity->name }}</li>
    </ol>
@endsection

@section('content')

    <div class="d-flex flex-column">
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-65" style="overflow: hidden auto">
                <div class="pr-4">
                    <x-label-section>{{ $activity->name }}</x-label-section>

                    <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-general" role="tab" aria-selected="true">{{ trans('general.general') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-goal" role="tab" aria-selected="false">{{ trans('general.goal') }}</a>
                        </li>
                        @if (!$activity->program->poa->isClosed())
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-request" role="tab" aria-selected="false">{{ trans('general.poa_requests') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-matrix-piat" role="tab" aria-selected="false">{{ trans('poa.piat_matrix_tag') }}</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-general" role="tabpanel">
                            <div class="pl-2">
                                <div class="mt-2 content-detail">
                                    <x-label-section>{{ trans('general.description') }}</x-label-section>
                                    <x-content-detail>{!! $activity->description  !!}</x-content-detail>
                                </div>
                                <div class="mt-2">
                                    <livewire:components.files :modelId="$activity->id" model="\App\Models\Poa\PoaActivity" folder="poa_activities"/>
                                </div>
                                <div class="mt-2">
                                    <x-label-section>{{ trans('general.comments') }}</x-label-section>
                                    <livewire:components.comments :modelId="$activity->id" class="\App\Models\Poa\PoaActivity"
                                                                  :key="time().$activity->id" identifier="activities"/>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-goal" role="tabpanel">
                            <div class="pl-2 pt-2">
                                <div class="content-detail">
                                    <x-label-section>{{ trans('general.alignment') }}</x-label-section>
                                    <div class="section-divider"></div>

                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans_choice('general.poa_program', 1) }}</x-label-detail>
                                        <x-content-detail>{{ $activity->planDetail ? $activity->planDetail->name:'' }}</x-content-detail>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <x-label-detail>{{ trans_choice('general.indicators', 1) }}</x-label-detail>
                                        <x-content-detail>
                                                 <span>
                                                   <i class="{{$activity->measure->unit->getIcon() }}"></i>
                                                    {{ $activity->measure->name }}
                                                </span>
                                        </x-content-detail>
                                    </div>
                                    <x-label-section>{{ trans('general.poa_edit_activity_goal_title_planning') }}</x-label-section>
                                    <div class="section-divider"></div>
                                    <livewire:poa.activity.poa-activity-goal-edit :activity="$activity"/>
                                </div>
                            </div>
                        </div>
                        @if (!$activity->program->poa->isClosed())
                            <div class="tab-pane fade" id="tab-request" role="tabpanel">
                                <div class="pl-2 pt-2">
                                    <div class="content-detail">
                                        <livewire:poa.requests.poa-activity-goal-change-request :activityId="$activity->id"/>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-matrix-piat" role="tabpanel">
                                <livewire:piat.poa-activity-piat-matrix-index class="{{\App\Models\Poa\PoaActivity::class}}" :idModel="$activity->id"/>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex-grow-1 w-35" style="overflow: hidden auto">
                <x-label-section>{{ trans_choice('general.details', 2) }}</x-label-section>
                <div class="section-divider"></div>

                <div class="pl-2 content-detail">
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.responsible') }}</x-label-detail>
                        <x-content-detail>
                            @if($activity->responsible)
                                <span class="mr-2">
                                    <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">
                                </span>
                                {{$activity->responsible? $activity->responsible->name :'' }}
                            @else
                                <span class="mr-2">
                                    <img src="{{ asset_cdn('img/user_off.png') }}" class="rounded-circle width-1">
                                </span>
                                {{ trans('general.not_assigned') }}
                            @endif
                        </x-content-detail>
                    </div>

                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.poa_activity_impact') }}</x-label-detail>
                        <x-content-detail>
                            <i class="{{ \App\Models\Poa\PoaActivity::CATEGORIES[$activity->impact]['icon'] }} mx-1 fw-700"></i>
                            <span>{{ \App\Models\Poa\PoaActivity::CATEGORIES[$activity->impact]['text'] }}</span>
                        </x-content-detail>
                    </div>

                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.poa_activity_complexity') }}</x-label-detail>
                        <x-content-detail>
                            <i class="{{ \App\Models\Poa\PoaActivity::CATEGORIES[$activity->complexity]['icon'] }} mx-1 fw-700"></i>
                            <span>{{ \App\Models\Poa\PoaActivity::CATEGORIES[$activity->complexity]['text'] }}</span>
                        </x-content-detail>
                    </div>

                    @if($transaction && $activity->getTotalBudget($transaction)->getAmount()>0)
                        <div class="d-flex flex-wrap">
                            <x-label-detail>{{ trans('general.module_budget') }}</x-label-detail>
                            <x-content-detail>{{ $activity->getTotalBudget($transaction) }}</x-content-detail>
                        </div>
                    @else
                        <div class="d-flex flex-wrap">
                            <x-label-detail>{{ trans('general.poa_activity_cost') }}</x-label-detail>
                            <x-content-detail>{{ $activity->cost }}</x-content-detail>
                        </div>
                    @endif
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.weight') }}</x-label-detail>
                        <div class="detail">
                            <x-content-detail>  {{number_format((float)$activity->poa_weight,2,'.','') }}</x-content-detail>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.poa_activity_location') }}</x-label-detail>
                        <x-content-detail>{{$activity->location? $activity->location->description:'' }}</x-content-detail>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
