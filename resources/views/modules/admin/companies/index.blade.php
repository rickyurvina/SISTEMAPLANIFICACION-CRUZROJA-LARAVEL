@extends('layouts.admin')

@section('title', trans_choice('general.companies', 2))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-landmark text-primary"></i> <span class="fw-300">Compañías</span>
    </h1>
    <div class="subheader-block d-lg-flex align-items-center">
        @if(Gate::check('admin-manage') )
            <a href="{{ route('companies.create') }}" class="btn btn-success btn-sm"><span class="fas fa-plus mr-1"></span>
                &nbsp;{{ trans('general.add') }}</a>
        @endif
    </div>
@endsection

@section('content')

    @if (count($companies))
        <div class="card">
            <div class="card-header pr-2 d-flex align-items-center flex-wrap">
                <div class="d-flex position-relative ml-auto w-100">
                    <i class="fal fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
                    <input type="text" id="searchIndexCompanies" name="search" value="{{ request()->get('search', '') }}" class="form-control bg-subtlelight pl-6"
                           placeholder="{{ trans('general.search_placeholder') }}">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover m-0">
                    <thead class="bg-primary-50">
                    <tr>
                        <th class="d-none">@sortablelink('id', trans('general.id'))</th>
                        <th>@sortablelink('level', trans('general.level'))</th>
                        <th>@sortablelink('name', trans('general.name'))</th>
                        <th>@sortablelink('identification', trans('general.ruc'))</th>
                        <th>@sortablelink('created_at', trans('general.created'))</th>
                        <th>@sortablelink('enabled', trans('general.enabled'))</th>
                        <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody id="indexCompaniesTable">
                    @foreach($companies as $item)
                        <tr>
                            <th class="d-none"></th>
                            <th>{{ $item->level }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->identification }}</td>
                            <td>@date($item->created_at)</td>
                            <td>
                                @if ($item->enabled)
                                    <badge rounded type="success" class="mw-60">{{ trans('general.yes') }}</badge>
                                @else
                                    <badge rounded type="danger" class="mw-60">{{ trans('general.no') }}</badge>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(Gate::check('admin-manage') )

                                    <a href="{{ route('companies.edit', $item->id) }}" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="Editar">
                                        <i class="fas fa-edit mr-1 text-info"
                                        ></i></a>
                                    <x-delete-link action="{{ route('companies.destroy', $item->id) }}"
                                                   id="{{ $item->id }}"/>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <x-pagination :items="$companies"/>
        </div>
    @else
        <x-empty-content>
            <x-slot name="title">
                {{ trans('general.no_companies_found') }}
            </x-slot>
        </x-empty-content>
    @endif

@endsection
@push('page_script')
    <script>
        $(document).ready(function () {
            $("#searchIndexCompanies").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#indexCompaniesTable tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endpush