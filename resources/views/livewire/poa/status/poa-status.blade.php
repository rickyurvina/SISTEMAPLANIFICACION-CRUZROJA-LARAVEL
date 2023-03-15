<div class="@if($poa->phase->isActive(\App\States\Poa\Execution::class)) d-lg-flex @endif subheader-block align-items-center w-100"
     x-cloak
     x-data="{
        show: @entangle('show').defer,
        phase: @entangle('phase')
        }"
     x-init="
            $watch('show', value => {
                if (value) {
                    $('#poa-status-change').modal('show');
                } else {
                    $('#poa-status-change').modal('hide');
                    phase = false;
                }
            });

"
     x-on:keydown.escape.window="show = false;"
     x-on:close.stop="show = false;"
>
    <ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0">
        @if(!$poa->phase instanceof \App\States\Poa\Execution && !$poa->phase instanceof \App\States\Poa\Closed)
            <li class="@if($poa->phase->isActive(\App\States\Poa\Planning::class)) active @endif">
                <a href="#">
                    <i class="fas fa-tasks"></i>
                    <span class="hidden-md-down ">{{ \App\States\Poa\Planning::label() }}</span>
                </a>
            </li>
            <ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0">
                <li class="@if($poa->status->isActive(\App\States\Poa\InProgress::class)) active @endif">
                    <a href="#" @if($poa->status->to() instanceof \App\States\Poa\InProgress) x-on:click="show = true" @endif>
                        <span class="badge border rounded-pill bg-white">1</span>
                        <span class="hidden-md-down ">{{ \App\States\Poa\InProgress::label() }}</span>
                    </a>
                </li>
                <li class="@if($poa->status->isActive(\App\States\Poa\Reviewed::class)) active @endif">
                    <a href="#" @if($poa->status->to() instanceof \App\States\Poa\Reviewed) x-on:click="show = true" @endif>
                        <span class="badge border rounded-pill bg-white">2</span>
                        <span class="hidden-md-down ">{{ \App\States\Poa\Reviewed::label() }}</span>
                    </a>
                </li>
                <li class="@if($poa->status->isActive(\App\States\Poa\Approved::class)) active @endif">
                    <a href="#" @if($poa->status->to() instanceof \App\States\Poa\Approved) x-on:click="show = true" @endif>
                        <span class="badge border rounded-pill bg-white">3</span>
                        <span class="hidden-md-down ">{{ \App\States\Poa\Approved::label() }}</span>
                    </a>
                </li>
            </ol>
        @endif
    </ol>
    <br/>
    <ol class="breadcrumb breadcrumb-lg breadcrumb-arrow mb-0">
        <li class="@if($poa->phase->isActive(\App\States\Poa\Execution::class)) active @endif">
            <a href="#" @if($poa->status->isActive(\App\States\Poa\Approved::class)) x-on:click="show = true; phase = true" @endif>
                <i class="fas fa-play"></i>
                <span class="hidden-md-down">{{ \App\States\Poa\Execution::label() }}</span>
            </a>
        </li>
        <li class="@if($poa->phase->isActive(\App\States\Poa\Closed::class)) active @endif">
            <a href="#" x-on:click="show = true; phase = true">
                <i class="fas fa-stop"></i>
                <span class="hidden-md-down">{{ \App\States\Poa\Closed::label() }}</span>
            </a>
        </li>
    </ol>
    @if(!$poa->phase instanceof \App\States\Poa\Closed )
        <div class="modal fade" id="poa-status-change" style="display: none;"
             data-backdrop="static" data-keyboard="false" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <template x-if="phase">
                            <h3 class="modal-title">{{ trans('general.change_phase') }}</h3>
                        </template>
                        <template x-if="!phase">
                            <h3 class="modal-title">{{ trans('general.change_status') }}</h3>
                        </template>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" x-on:click="show = false">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <template x-if="phase">
                            <div class="d-flex align-items-center mb-6">
                                <div class="d-flex align-items-center flex-column">
                                    <x-label-section>{{ trans('general.from') }}</x-label-section>
                                    <span class="badge {{ $poa->phase->color() }} fs-2x mr-3">
                                     {{ $poa->phase->label() }}
                                 </span>
                                </div>
                                <span class="mr-3"><i class="fas fa-arrow-right color-success-500 fa-2x"></i></span>
                                <div class="d-flex align-items-center flex-column">
                                    <x-label-section>{{ trans('general.to') }}</x-label-section>
                                    <span class="badge {{ $poa->phase->to()->color() }} fs-2x">
                                      {{ $poa->phase->to()->label() }}
                                     </span>
                                </div>
                            </div>
                        </template>
                        <template x-if="!phase">
                            <div class="d-flex align-items-center mb-6">
                                <div class="d-flex align-items-center flex-column">
                                    <x-label-section>{{ trans('general.phase') }}</x-label-section>
                                    <span class="badge fs-2x mr-3">{{ $poa->phase }}:</span>
                                </div>

                                <div class="d-flex align-items-center flex-column">
                                    <x-label-section>{{ trans('general.from') }}</x-label-section>
                                    <span class="badge {{ $poa->status->color() }} fs-2x mr-3">
                                {{ $poa->status->label() }}
                            </span>
                                </div>

                                <span class="mr-3"><i class="fas fa-arrow-right color-success-500 fa-2x"></i></span>

                                <div class="d-flex align-items-center flex-column">
                                    <x-label-section>{{ trans('general.to') }}</x-label-section>
                                    <span class="badge {{ $poa->status->to()->color() }} fs-2x">
                                {{ $poa->status->to()->label() }}
                            </span>
                                </div>
                            </div>
                        </template>
                        <x-label-section>{{ trans('general.activities_goal') }}</x-label-section>

                        <div class="table-responsive mb-6">
                            <table class="table table-light table-hover">
                                <thead>
                                <tr>
                                    <th class="w-50"><a href="#">{{ trans_choice('general.indicators', 1) }}</a></th>
                                    <th class="w-10"><a href="#">{{ trans_choice('general.activities', 2) }}</a></th>
                                    <th class="w-10"><a href="#">{{ trans('general.goal') }}</a></th>
                                    <th class="w-25"><a href="#">{{ trans('general.type') }}</a></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($resume as $item)
                                    <tr class="tr-hover">
                                        <td>{{ $item['indicator'] }}</td>
                                        <td>{{ $item['activityCount'] }}</td>
                                        <td>{{ $item['goal']}}</td>
                                        <td>{{ $item['type'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <x-label-section>{{ trans('general.change_history') }}</x-label-section>

                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-2 content-detail"><span class="fw-700">{{ trans('general.from') }}</span></div>
                                <div class="col-1"></div>
                                <div class="col-2 content-detail"><span class="fw-700">{{ trans('general.to') }}</span></div>
                                <div class="col-4 content-detail"><span class="fw-700">{{ trans('general.updated_by') }}</span></div>
                                <div class="col-3 content-detail"><span class="fw-700">{{ trans('general.date') }}</span></div>
                            </div>
                            {{--                            @foreach($poa->statusChanges() as $change)--}}
                            {{--                                <div class="row mb-2">--}}
                            {{--                                    <div class="col-2">--}}
                            {{--                                    <span class="badge {{ \App\Models\Poa\Poa::statusColor($change->properties->get('old')['status']) }} mr-3">--}}
                            {{--                                        {{ $change->properties->get('old')['status'] }}--}}
                            {{--                                    </span>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-1"><i class="fas fa-arrow-right color-success-500"></i></div>--}}
                            {{--                                    <div class="col-2">--}}
                            {{--                                    <span class="badge {{ \App\Models\Poa\Poa::statusColor($change->properties->get('attributes')['status']) }}">--}}
                            {{--                                        {{ $change->properties->get('attributes')['status'] }}--}}
                            {{--                                    </span>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-4">--}}
                            {{--                                    <span class="mr-2">--}}
                            {{--                                        <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">--}}
                            {{--                                    </span>--}}
                            {{--                                        {{ $change->causer->name }}</div>--}}
                            {{--                                    <div class="col-3">{{ company_date($change->created_at) }}</div>--}}
                            {{--                                </div>--}}
                            {{--                            @endforeach--}}
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary shadow-none" data-dismiss="modal" x-on:click="show = false">{{ trans('general.cancel') }}</button>
                        @if($phase)
                            <button type="button" class="btn btn-success border-0 shadow-none" wire:click="changePhase">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:target="changePhase" wire:loading></span>
                                {{ trans('general.change') }}
                            </button>
                        @else
                            <button type="button" class="btn btn-success border-0 shadow-none" wire:click="changeStatus">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:target="changeStatus" wire:loading></span>
                                {{ trans('general.change') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
