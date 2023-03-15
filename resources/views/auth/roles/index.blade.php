@extends('layouts.admin')

@section('title', trans_choice('general.roles', 2))

@section('subheader-title')
    <i class="fal fa-tasks text-primary"></i> {{ trans_choice('general.roles', 2) }}
@endsection

@section('subheader')
    @can('admin-crud-admin')
        <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span> &nbsp;{{ trans('general.create') }}</a>
    @endcan
@endsection

@section('content')


    <div class="card">
        <x-search route="{{ route('roles.index') }}"/>
        <div class="table-responsive">
            <table class="table  m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th>@sortablelink('name', trans('general.name'))</th>
                    <th>@sortablelink('created_at', trans('general.created'))</th>
                    @can('admin-crud-admin')
                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $item)
                    <tr>
                        <td>
                            @if(Gate::check('admin-crud-admin'))
                                <x-link route="{{ route('roles.edit', $item->id) }}">{{ $item->name }}</x-link>
                            @elseif (Gate::check('admin-read-admin'))
                                {{ $item->name }}
                            @endif
                        </td>
                        <td>@date($item->created_at)</td>
                        @can('admin-crud-admin')
                        <td class="text-center w-20">
                            <a class="mr-2" href="{{ route('roles.edit', $item->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="fas fa-edit mr-1 text-info"></i></a>
                            <x-delete-link action="{{ route('roles.destroy', $item->id) }}" id="{{ $item->id }}"/>
                        </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :items="$roles" />
    </div>

@endsection
