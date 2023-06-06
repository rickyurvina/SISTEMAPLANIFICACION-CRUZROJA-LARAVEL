@extends('layouts.admin')

@section('title', trans_choice('general.users', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-tasks text-primary"></i> {{ trans_choice('general.users', 2) }}

    </h1>
    @if(Gate::check('admin-manage-users') )
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_user_modal">
            <i class="fas fa-plus mr-1"></i>
            {{ trans('general.create') }}
        </button>
    @endif
@endsection

@section('content')

    <div class="card">
        <x-search route="{{ route('users.index') }}"/>
        <div class="table-responsive">
            <table class="table m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th>@sortablelink('name', trans('general.name'))</th>
                    <th>@sortablelink('email', trans('general.email'))</th>
                    <th class="color-primary-500">{{ trans_choice('general.companies', 0) }}</th>
                    <th class="color-primary-500">{{ trans_choice('general.roles', 0) }}</th>
                    <th class="color-primary-500">{{ trans_choice('general.department', 0) }}</th>
                    <th>@sortablelink('last_logged_in_at', trans('general.last_logged_in_at'))</th>
                    <th>@sortablelink('enabled', trans('general.enabled'))</th>

                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach($users as $item)
                    <tr>
                        <td>
                            <span class="mr-2">
                                @if (is_object($item->picture))
                                    <img src="{{ Storage::url($item->picture->id) }}" class="rounded-circle width-2" alt="{{ $item->name }}">
                                @else
                                    <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-2" alt="{{ $item->name }}">
                                @endif
                            </span>
                            @if(Gate::check('admin-crud-admin'))
                                <a aria-expanded="false" href="{{ route('profile', $item->id) }}"> {{ $item->name }}</a>
                            @elseif (Gate::check('admin-read-admin'))
                                {{ $item->name }}
                            @endif
                        </td>
                        <td>{{ $item->email }}</td>
                        <td>
                            @foreach($item->companies as $company)
                                <span class="badge badge-primary badge-pill">{{ $company->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($item->roles as $role)
                                <span class="badge badge-info badge-pill">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($item->departments as $department)
                                <span class="badge badge-secondary badge-pill">{{ $department->name }}</span>
                            @endforeach
                        </td>
                        <td>{{  $item->last_logged_in_at }}</td>
                        <td>
                            <x-enabled enabled="{{ $item->enabled }}"/>
                        </td>
                        <td class="text-center w-20">
                            @if(Gate::check('admin-manage-users') )
                                <div class="frame-wrap">
                                    <div class="d-flex justify-content-center">
                                        {{--                                        <div class="p-2">--}}
                                        {{--                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_user_modal"--}}
                                        {{--                                               data-id="{{$item->id}}" class="">--}}
                                        {{--                                                <i class="fas fa-pencil mr-1 text-info" data-toggle="tooltip" data-placement="top"--}}
                                        {{--                                                   title="" data-original-title="Editar"></i>--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </div>--}}
                                        <div class="p-2">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#user_assign_roles"
                                               data-id="{{$item->id}}" class="">
                                                <i class="fas fa-user-alt-slash mr-1 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="" data-original-title="Asignar Roles"></i>
                                            </a>
                                        </div>
                                        <div class="p-2">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#user_assign_companies"
                                               data-id="{{$item->id}}" class="">
                                                <i class="fas fa-home mr-1 text-success" data-toggle="tooltip" data-placement="top"
                                                   title="" data-original-title="Asignar Juntas"></i>
                                            </a>
                                        </div>
                                        <div class="p-2">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#user_assign_departments"
                                               data-id="{{$item->id}}" class="">
                                                <i class="fas fa-clipboard-list mr-1 text-secondary" data-toggle="tooltip" data-placement="top"
                                                   title="" data-original-title="Asignar Departamentos"></i>
                                            </a>
                                        </div>
                                        <div class="p-2">
                                            <x-delete-link action="{{ route('users.destroy', $item->id) }}" id="{{ $item->id }}"/>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :items="$users"/>
    </div>
    <livewire:admin.user-create-modal/>
    <livewire:admin.user-edit-modal/>
    <livewire:admin.user-assign-companies/>
    <livewire:admin.user-assign-roles/>
    <livewire:admin.user-assign-departments/>
@endsection
@push('page_script')
    <script>
        Livewire.on('toggleUserEditModal', () => $('#edit_user_modal').modal('toggle'));
        Livewire.on('toggleUserAddModal', () => $('#add_user_modal').modal('toggle'));
        Livewire.on('toggleAssignDepartments', () => $('#user_assign_departments').modal('toggle'));
        $('#edit_user_modal').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('openUserEditModal', id);
        });
        $('#user_assign_roles').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('openUserAssignRoles', id);
        });
        $('#user_assign_departments').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('openUserAssignDepartments', id);
        });
        $('#user_assign_companies').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('openUserAssignCompanies', id);
        });

        $('#add_user_modal').on('show.bs.modal', function (e) {
            //Livewire event trigger
            Livewire.emit('loadForm');
        });

    </script>
@endpush
