@extends('layouts.admin')

@section('title', trans_choice('general.roles', 2))

@section('subheader-title')
    <i class="fal fa-tasks text-primary"></i> {{ trans_choice('general.roles', 2) }}
@endsection

@section('subheader')
    @if(Gate::check('admin-manage-users') )
        <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span> &nbsp;{{ trans('general.create') }}</a>
    @endif
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
                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $item)
                    <tr>
                        <td>
                            {{ $item->name }}
                        </td>
                        <td>@date($item->created_at)</td>
                        <td class="text-center w-20">
                            @if(Gate::check('admin-manage-users') && $item->can_edit)
                                <a class="mr-2" href="{{ route('roles.edit', $item->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i
                                            class="fas fa-edit mr-1 text-info"></i></a>
                                <x-delete-link action="{{ route('roles.destroy', $item->id) }}" id="{{ $item->id }}"/>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :items="$roles"/>
    </div>

@endsection
