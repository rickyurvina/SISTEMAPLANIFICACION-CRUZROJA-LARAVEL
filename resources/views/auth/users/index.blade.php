@extends('layouts.admin')

@section('title', trans_choice('general.users', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-tasks text-primary"></i> {{ trans_choice('general.users', 2) }}

    </h1>
    @can('admin-crud-admin')
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_user_modal">
            <i class="fas fa-plus mr-1"></i>
            {{ trans('general.create') }}
        </button>

    @endcan
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
                    @can('admin-crud-admin')
                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                    @endcan
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
                        @can('admin-crud-admin')
                        <td class="text-center w-20">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_user_modal"
                                data-id="{{$item->id}}" class="">
                                <i class="fas fa-pencil mr-1 text-info" data-toggle="tooltip" data-placement="top"
                                    title="" data-original-title="Editar"></i>
                            </a>
                            <x-delete-link action="{{ route('users.destroy', $item->id) }}" id="{{ $item->id }}"/>
                        </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :items="$users"/>
    </div>
    <livewire:admin.user-create-modal/>
    <livewire:admin.user-edit-modal/>
@endsection
@push('page_script')
    <script>
        Livewire.on('toggleUserEditModal', () => $('#edit_user_modal').modal('toggle'));
        Livewire.on('toggleUserAddModal', () => $('#add_user_modal').modal('toggle'));
        $('#edit_user_modal').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('openUserEditModal', id);
        });

        $('#add_user_modal').on('show.bs.modal', function (e) {
            //Livewire event trigger
            Livewire.emit('loadForm');
        });

    </script>
@endpush
