@extends('layouts.admin')

@section('title', trans('general.module_risk'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-list text-primary"></i> <span class="fw-300">Riesgos</span>
    </h1>
    <div class="subheader-block d-lg-flex align-items-center">
        @can('create-auth-users')
            <livewire:risks.create-risk :projectId="0"/>
        @endcan
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header pr-2 d-flex align-items-center flex-wrap">
            <div class="d-flex position-relative ml-auto w-100">
                <i class="fal fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
                <input type="text" class="form-control bg-subtlelight pl-6"
                       placeholder="{{ trans('general.search_placeholder') }}">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th class="d-none">@sortablelink('id', trans('general.id'))</th>
                    <th>@sortablelink('name', trans('general.name'))</th>
                    <th>@sortablelink('description', trans('general.description'))</th>
                    <th>@sortablelink('incidence_date', trans('general.incidence_date'))</th>
                    <th>@sortablelink('identification_date', trans('general.identification_date'))</th>
                    <th>@sortablelink('closing_date', trans('general.closing_date'))</th>
                    <th>@sortablelink('state', trans('general.state'))</th>
                    <th>@sortablelink('created_at', trans('general.created'))</th>
                    <th>@sortablelink('enabled', trans('general.enabled'))</th>
                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($risks as $item)
                    <tr>
                        <td class="d-none"></td>
                        <!-- <td><livewire:risks.updated-risk :risk="$item" wire:key="" /></td>-->
                        <td>
                            <a href="#" data-toggle="modal" data-risk-id="{{ $item->id }}"
                               data-target="#edit-modal-risk">{{ $item->name }}</a>
                        </td>
                        <td>{{ $item->description }}</td>
                        <td>@date($item->incidence_date)</td>
                        <td>@date($item->identification_date)</td>
                        <td>@date($item->closing_date)</td>
                        <td>
                            @if ($item->state->description == \App\Models\Risk\Risk::RISK_STATE_OPEN)
                                <span class="badge badge-success">{{ $item->state->description }}</span>
                            @else
                                <span class="badge badge-danger">{{ $item->state->description }}</span>
                            @endif
                        </td>
                        <td>@date($item->created_at)</td>
                        <td>
                            @if ($item->enabled)
                                <badge rounded type="success" class="mw-60">{{ trans('general.yes') }}</badge>
                            @else
                                <badge rounded type="danger" class="mw-60">{{ trans('general.no') }}</badge>
                            @endif
                        </td>
                        <td class="text-center">
                            @can('delete-risk')
                                <x-delete-link action="{{ route('risks.destroy', $item->id) }}" id="{{ $item->id }}"></x-delete-link>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <livewire:risks.updated-risk/>
    </div>
@endsection

@push('page_script')
    <script>
        $('#edit-modal-risk').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let riskId = $(e.relatedTarget).data('risk-id');
            //Livewire event trigger
            Livewire.emit('loadUpdateForm', riskId);

            Livewire.emit('loadRiskChart');
        });
    </script>
@endpush
