@extends('modules.project.project')

@section('project-page')
    <div class="container-fluid">

        <div class="d-flex">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#project-create-communication"
               class="btn btn-success btn-sm mb-2 ml-auto mr-2">
                {{ trans('general.create') }} {{ trans('general.communication') }}
            </a>
        </div>
        <div class="card w-100">
            @if($communications->count()>0)
                <div class="row">
                    <div class="col-12">
                        <x-search route="{{ route('projects.communication', $project) }}"/>
                        <div class="table-responsive">
                            <table class="table  m-0">
                                <thead class="bg-primary-50">
                                <tr>
                                    <th>@sortablelink('prj_project_stakeholder_id', trans('general.stakeholder'))</th>
                                    <th>@sortablelink('user_id', trans('general.responsible_send_information'))</th>
                                    <th class="w-10">@sortablelink('frequency', trans('general.frequency'))</th>
                                    <th class="w-10">@sortablelink('information_type',
                                        trans('general.information_type'))
                                    </th>
                                    <th>@sortablelink('state', trans('general.state'))</th>
                                    <th class="text-primary text-center w-10"># {{trans('general.files')}}</th>
                                    <th>@sortablelink('start_date', trans('general.delivery_date'))</th>
                                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($communications as $item)
                                    <tr>
                                        <td>
                                            {{ $item->stakeholder->interested->getFullName()??'' }}
                                        </td>
                                        <td>
                                            {{ $item->user->getFullName()??'' }}
                                        </td>
                                        @if($item->frequency)
                                            <td>
                                                {{ $item->frequency }}
                                            </td>
                                        @else
                                            <td class="fs-1x fw-400"><i class="fal fa-times-circle fa-2x"
                                                                        style="color: #D52B1E"></i>
                                            </td>
                                        @endif
                                        <td>
                                            {{ $item->information_type }}
                                        </td>
                                        <td>
                                            @switch($item->state)
                                                @case(\App\Models\Projects\Stakeholders\ProjectCommunicationMatrix::NO_DELIVERED)
                                                <span style="color: red">
                                                    <i class='red fa fa-bell w-10 text-center'></i> {{  $item->state }}
                                                </span>
                                                @break
                                                @case(\App\Models\Projects\Stakeholders\ProjectCommunicationMatrix::DELIVERED)
                                                <span style="color: green">
                                                        <i class='red fa fa-check w-10 text-center'></i> {{  $item->state }}
                                                </span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="text-center">
                                            <a class="mr-2 btn btn-info btn-sm btn-icon waves-effect waves-themed"
                                               href="javascript:void(0);" aria-expanded="false"
                                               data-toggle="modal" data-placement="top" title=""
                                               data-target="#project-files-communication"
                                               data-item-id="{{ $item->id }}"
                                               data-original-title="Ver Archivos">
                                                {{$item->media->count()}}
                                            </a>
                                        </td>
                                        <td>{{ $item->start_date }}</td>
                                        <td class="text-center">
                                            @if(user()->id == $item->user_id||user()->hasRole('super-admin'))
                                                <a href="javascript:void(0);" aria-expanded="false"
                                                   data-toggle="modal"
                                                   data-target="#project-check-send-communication"
                                                   data-item-id="{{ $item->id }}">
                                                    <i class="fas fa-check-circle mr-1 text-info"
                                                       data-toggle="tooltip" data-placement="top" title=""
                                                       data-original-title="Marcar Enviado">
                                                    </i>
                                                </a>
                                            @endif
                                            <a href="javascript:void(0);" aria-expanded="false"
                                               data-toggle="modal"
                                               data-target="#project-edit-communication"
                                               data-item-id="{{ $item->id }}">
                                                <i class="fas fa-edit mr-1 text-info"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Editar">
                                                </i>
                                            </a>
                                            @if($item->media->count()<1)
                                                <x-delete-link-icon
                                                        action="{{ route('project.deleteCommunication', ['id' => $item->id]) }}"
                                                        id="{{ $item->id }}">
                                                </x-delete-link-icon>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <x-pagination :items="$communications"/>
                    </div>
                </div>
            @else

                <x-empty-content>
                    <x-slot name="title">
                        {{trans('general.communication')}}
                    </x-slot>
                </x-empty-content>

            @endif
        </div>
        <div>
            <livewire:projects.stakeholders.project-create-communication :project="$project"/>
        </div>
        <div>
            <livewire:projects.stakeholders.project-edit-communication :project="$project"/>
        </div>
        <div>
            <livewire:projects.stakeholders.project-check-send-communication :project="$project"/>
        </div>
        <div>
            <livewire:projects.stakeholders.project-files-communication :project="$project"/>
        </div>

    </div>


@endsection
@push('page_script')
    <script>
        Livewire.on('toggleProjectCreateCommunication', () => $('#project-create-communication').modal('toggle'));
        Livewire.on('toggleProjectFilesCommunication', () => $('#project-files-communication').modal('toggle'));
        Livewire.on('toggleProjectEditCommunication', () => $('#project-edit-communication').modal('toggle'));
        Livewire.on('closeModalCheckCommunication', () => $('#project-check-send-communication').modal('toggle'));

        $('#project-edit-communication').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let item = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('open', item);
        });

        $('#project-check-send-communication').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let item = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openSend', item);
        });

        $('#project-files-communication').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let item = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openFiles', item);
        });
    </script>
@endpush

