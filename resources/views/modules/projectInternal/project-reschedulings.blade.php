@extends('modules.projectInternal.project')

@section('project-page')
    <div>
        <div class="p-2">
            <div class="d-flex flex-row-reverse">
                <div>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#project-create-rescheduling"
                       class="btn btn-success btn-sm mb-2 mr-2 ml-auto">
                        <span class="fas fa-plus mr-1"></span> &nbsp;{{ trans('general.add_new') }}
                    </a>
                </div>
            </div>
            <h2 class="text-center text-info fs-2x fw-700 mt-2 mb-2">{{trans('general.rescheduling')}}</h2>

            @if($project->reschedulings->count()>0)
                <div class="table-responsive">
                    <table class="table table-light table-hover">
                        <thead>
                        <tr>
                            <th class="w-auto table-th text-center">{{ __('general.description') }}</th>
                            <th class="w-auto table-th text-center">{{ __('general.phase') }}</th>
                            <th class="w-auto table-th text-center">{{trans('general.status')}}</th>
                            <th class="w-auto table-th text-center">{{ __('general.poa_request_user') }}</th>
                            <th class="w-auto table-th text-center">{{ __('general.poa_answer_user') }}</th>
                            <th class="w-10 table-th text-center">{{ __('general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($project->reschedulings as $item)
                            @if($project->phase != $item->phase)
                                <tr class="tr-hover text-center">
                                    <td>{{$item->description}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                <span class="badge badge- {{ \App\Models\Projects\Project::PHASE_BG[$item->phase] }}
                                        badge-pill">
                                    {{ $item->phase }}
                                </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge badge- {{ \App\Models\Projects\ProjectRescheduling::STATUSES_BG[$item->status] }} badge-pill">{{ $item->status }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <div class="" @if($item->applicant) data-toggle="tooltip" data-placement="top"
                                                 title="{{ $item->applicant->getFullName() }}" data-original-title="{{ $item->applicant->getFullName() }}" @endif>
                                                <div class="dropdown-item">
                                                            <span class="mr-2">
                                                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                            </span>
                                                    <span class="pt-1">{{ $item->applicant->getFullName() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->approver)
                                            <div class="d-flex justify-content-center">
                                                <div class="" @if($item->approver) data-toggle="tooltip" data-placement="top"
                                                     title="{{ $item->approver->getFullName() }}" data-original-title="{{ $item->approver->getFullName() }}" @endif>
                                                    <div class="dropdown-item">
                                                            <span class="mr-2">
                                                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                                                            </span>
                                                        <span class="pt-1">{{ $item->approver->getFullName() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->status==\App\Models\Projects\ProjectRescheduling::STATUS_OPENED)
                                            <a href="javascript:void(0)"
                                               data-toggle="modal"
                                               data-target="#project-approve-rescheduling"
                                               data-item-id="{{$item->id}}">
                                                <i class="fas fa-check-circle mr-1 text-info"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Aprobar"></i>
                                            </a>

                                            <a href="javascript:void(0)"
                                               data-toggle="modal"
                                               data-target="#project-edit-rescheduling"
                                               data-item-id="{{$item->id}}">
                                                <i class="fas fa-edit mr-1 text-info"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Editar"></i>
                                            </a>
                                            <x-delete-link action="{{ route('projects.delete_rescheduling', $item->id) }}" id="{{ $item->id }}"/>
                                        @endif

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-empty-content>
                    <x-slot name="title">
                        No existen reprogramaciones creadas
                    </x-slot>
                </x-empty-content>
            @endif
        </div>
        <div wire:ignore>
            <livewire:projects-internal.reschedulings.project-create-rescheduling :project="$project"/>
        </div>
        <div wire:ignore>
            <livewire:projects-internal.reschedulings.project-edit-rescheduling :project="$project"/>
        </div>
        <div wire:ignore>
            <livewire:projects-internal.reschedulings.project-approve-rescheduling/>
        </div>


    </div>

@endsection

@push('page_script')
    <script>
        Livewire.on('toggleCreateRes', () => $('#project-create-rescheduling').modal('toggle'));
        Livewire.on('toggleEditRes', () => $('#project-edit-rescheduling').modal('toggle'));

        $('#project-edit-rescheduling').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openEditRescheduling', id);
        });
        $('#project-approve-rescheduling').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openApproveRescheduling', id);
        });
    </script>
@endpush