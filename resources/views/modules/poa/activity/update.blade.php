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
        <li class="breadcrumb-item active">{{ $activity->code }}</li>
    </ol>
@endsection

@section('content')
    <div class="d-flex flex-column">
        <div class="d-flex flex-nowrap">
            <div class="flex-grow-1 w-65" style="overflow: hidden auto">
                <div class="pr-4">
                    <div class="d-flex flex-wrap">
                        <x-label-section>{{ trans('general.name') }}</x-label-section>
                        @can('poa-edit-activity-name')
                            <livewire:components.input-text :modelId="$activity->id"
                                                            class="\App\Models\Poa\PoaActivity"
                                                            field="name"
                                                            defaultValue="{{ $activity->name }}"/>
                        @else
                            <x-content-detail>{{ $activity->name }}</x-content-detail>
                        @endcan
                    </div>
                    <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-general" role="tab" aria-selected="true">{{ trans('general.general') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-goal" role="tab" aria-selected="false">{{ trans('general.goal') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-budget" role="tab" aria-selected="false">{{ trans('budget.expense') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-general" role="tabpanel">
                            <div class="pl-2">
                                <div class="mt-2">
                                    <x-label-section>{{ trans('general.description') }}</x-label-section>
                                    <livewire:components.input-text-editor-inline-editor
                                            :modelId="$activity->id"
                                            class="\App\Models\Poa\PoaActivity"
                                            field="description"
                                            :placeholder="trans('general.add_description')"
                                            :defaultValue="$activity->description"/>
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
                        <div class="tab-pane fade" id="tab-budget" role="tabpanel">
                            <div class="pl-2 pt-2">
                                <div class="content-detail">
                                    <div class="d-flex flex-column">
                                        <x-label-section>{{ trans_choice('budget.budget',1) }}</x-label-section>
                                        <div class="section-divider"></div>
                                        @if($expenses->count()>0)
                                            <div class="table-responsive">
                                                <table class="table table-light table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th class="table-th w-30"> {{trans('general.item')}}</th>
                                                        <th class="table-th w-30">{{ trans('general.name')}}</th>
                                                        <th class="table-th w-10">{{trans('general.description')}}</th>
                                                        <th class="table-th w-20">{{trans('general.value')}}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($expenses as $item)
                                                        <tr class="tr-hover">
                                                            <td>{{ $item->account->code }}</td>
                                                            <td>{{ $item->account->name }}</td>
                                                            <td>{{ $item->account->description }}</td>
                                                            <td>${{ money_decimal_format($item->credit)}} </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr style="background-color: #e0e0e0">
                                                        <td colspan="3"></td>
                                                        <td style="color: #008000" class="fs-2x fw-700">Total: ${{$total}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <x-empty-content>
                                                <x-slot name="img">
                                                    <i class="fas fa-money-bill-wave" style="color: #2582fd;"></i>
                                                </x-slot>
                                                <x-slot name="title">
                                                    No existen partidas presupuestarias creadas
                                                </x-slot>
                                            </x-empty-content>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-grow-1 w-35" style="overflow: hidden auto">
                <x-label-section>{{ trans_choice('general.details', 2) }}</x-label-section>
                <div class="section-divider"></div>

                <div class="pl-2 content-detail">
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.responsible') }}</x-label-detail>
                        <div class="detail">
                            <livewire:components.dropdown-user :modelId="$activity->id" modelClass="\App\Models\Poa\PoaActivity" field="user_id_in_charge"
                                                               :key="time().$activity->id" :user="$activity->responsible"/>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.poa_activity_impact') }}</x-label-detail>
                        <div class="detail">
                            <livewire:components.dropdown-simple :modelId="$activity->id"
                                                                 modelClass="\App\Models\Poa\PoaActivity"
                                                                 :values="\App\Models\Poa\PoaActivity::CATEGORIES"
                                                                 field="impact"
                                                                 event="App\Events\Poa\PoaActivityWeightChanged"
                                                                 :defaultValue="\App\Models\Poa\PoaActivity::CATEGORIES[$activity->impact]"/>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.poa_activity_complexity') }}</x-label-detail>
                        <div class="detail">
                            <livewire:components.dropdown-simple :modelId="$activity->id"
                                                                 modelClass="\App\Models\Poa\PoaActivity"
                                                                 :values="\App\Models\Poa\PoaActivity::CATEGORIES"
                                                                 field="complexity"
                                                                 event="App\Events\Poa\PoaActivityWeightChanged"
                                                                 :defaultValue="\App\Models\Poa\PoaActivity::CATEGORIES[$activity->complexity]"/>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.poa_activity_cost') }}</x-label-detail>
                        <div class="detail">
                            @if($total)
                                <x-content-detail>  {{$total}}</x-content-detail>
                            @else
                                <livewire:components.input-text :modelId="$activity->id"
                                                                class="\App\Models\Poa\PoaActivity"
                                                                field="cost"
                                                                event="App\Events\Poa\PoaActivityWeightChanged"
                                                                :rules="'required|numeric|min:0'"
                                                                defaultValue="{{ $activity->cost }}"/>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.weight') }}</x-label-detail>
                        <div class="detail">
                            <x-content-detail>  {{number_format((float)$activity->poa_weight,2,'.','') }}</x-content-detail>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">
                        <x-label-detail>{{ trans('general.poa_activity_location') }}</x-label-detail>
                        <div class="detail">
                            <livewire:components.location :modelId="$activity->id"
                                                          modelClass="\App\Models\Poa\PoaActivity"
                                                          :default="$activity->location"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
