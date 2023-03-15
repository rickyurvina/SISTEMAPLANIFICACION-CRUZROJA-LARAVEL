@extends('layouts.admin')

@section('title', trans_choice('general.organizational_structure', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-balance-scale-right text-primary"></i> <span class="fw-300">{{trans_choice('general.department',0)}}</span>
    </h1>
    <div class="subheader-block d-lg-flex align-items-center">
        @can('admin-crud-admin')
            <a href="{{ route('departments.create') }}" class="btn btn-success btn-sm"><span
                        class="fas fa-plus mr-1"></span> &nbsp;{{ trans('general.add_new') }}</a>
        @endcan
    </div>
@endsection

@section('content')


    <div class="card">

        <x-search route="{{ route('departments.index') }}"/>

        <div class="table-responsive">
            <table class="table m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th class="d-none">@sortablelink('id', trans('general.id'))</th>
                    <th>@sortablelink('code', trans('general.code'))</th>
                    <th>@sortablelink('name', trans('general.name'))</th>
                    <th>@sortablelink('responsible', trans('general.responsible'))</th>
                    <th>@sortablelink('created_at', trans('general.created'))</th>
                    <th>@sortablelink('enabled', trans('general.enabled'))</th>
                    @can('admin-crud-admin')
                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach($departments as $item)
                    <tr>
                        <th class="d-none"></th>
                        <th>{{ $item->code }}</th>
                        <td>
                            @if(Gate::check('admin-crud-admin'))
                                <a href="{{ route('departments.edit', $item->id) }}">{{ $item->name }}</a>
                            @elseif (Gate::check('admin-read-admin'))
                                {{ $item->name }}
                            @endif
                        </td>
                        <td>{{ $item->responsible()->get()->first()->name }}</td>
                        <td>@date($item->created_at)</td>
                        <td>
                            @if ($item->enabled)
                                <badge rounded type="success" class="mw-60">{{ trans('general.yes') }}</badge>
                            @else
                                <badge rounded type="danger" class="mw-60">{{ trans('general.no') }}</badge>
                          @endif
                        </td>
                        @can('admin-crud-admin')
                      <td class="text-center">
                        <x-delete-link action="{{ route('departments.destroy', $item->id) }}" id="{{ $item->id }}"/>
                      </td>
                      @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
      <x-pagination :items="$departments"/>
    </div>
@endsection
