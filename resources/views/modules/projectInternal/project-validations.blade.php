@extends('modules.projectInternal.project')

@section('project-page')
    <div>
        <div class="table-responsive">
            <table class="table table-light table-hover">
                <thead>
                <tr>
                    <th class="w-auto table-th text-center">{{ __('general.state') }}</th>
                    <th class="w-auto table-th text-center">{{ __('general.validations') }}</th>
                    <th class="w-auto table-th text-center">{{trans('general.status')}}</th>
                    <th class="w-auto table-th text-center">{{ __('general.responsable') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($project->stateValidations as $item)
                    <tr class="tr-hover text-center">
                        <td>
                            <div class="d-flex justify-content-center  ">
                                <span class="badge badge- @isset( \App\Models\Projects\Project::STATUS_BG[$item->state])
                                {{ \App\Models\Projects\Project::STATUS_BG[$item->state] }}
                                @else
                                {{\App\Models\Projects\Project::PHASE_BG[$item->state]}}
                                @endisset badge-pill">
                                    {{ $item->state }}
                                </span>
                            </div>
                        </td>
                        <td class="text-center">
                            <table class="w-100 table-bordered table-border-0">
                                <thead>
                                <tr class="border border-bottom">
                                    @foreach($item->validations as $index => $dep)
                                        <th>{{$index}}</th>
                                    @endforeach
                                </tr>

                                </thead>
                                <tbody>
                                <tr>
                                    @foreach($item->validations as $index => $dep_)
                                        <th>{{$dep_['description'] ? $dep_['description'] : trans('general.There_are_no_records')}}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach($item->validations as $index => $dep2)
                                        <th>{{$dep2['value'] == 1 ? \App\Models\Projects\ProjectStateValidations::STATUS_VALIDATED:
                                             \App\Models\Projects\ProjectStateValidations::STATUS_NO_VALIDATED}}
                                        </th>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <span class="badge badge- {{ \App\Models\Projects\ProjectStateValidations::STATUSES_BG[$item->status] }} badge-pill">{{ $item->status }}</span>

                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <div class="" @if($item->user) data-toggle="tooltip" data-placement="top"
                                     title="{{ $item->user->getFullName() }}" data-original-title="{{ $item->user->getFullName() }}" @endif>
                                    <div class="dropdown-item">
                                                            <span class="mr-2">
                                                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                            </span>
                                        <span class="pt-1">{{ $item->user->getFullName() }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

