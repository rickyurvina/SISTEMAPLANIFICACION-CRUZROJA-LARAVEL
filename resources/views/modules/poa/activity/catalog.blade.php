@extends('layouts.admin')

@section('title', __('poa.activities_poa'))

@section('subheader')
    <h1 class="subheader-title">
        <i class="fal fa-align-left text-primary"></i> {{ __('general.poa_activities_catalog_manage') }}
    </h1>
    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_catalog_activity_modal">
        <i class="fas fa-plus mr-1"></i>
        {{ trans('general.create') }}
    </button>
@endsection

@section('content')
    <div>
        @if($poaActTempl->count() > 0)
            <div class="table-responsive">
                <table class="table table-light">
                    <thead>
                    <tr>
                        <th class="w-5 table-th">@sortablelink('code', __('poa.code'))</th>
                        <th class="w-25 table-th">@sortablelink('name', __('poa.name'))</th>
                        <th class="w-10 table-th">@sortablelink('cost', __('poa.cost'))</th>
                        <th class="w-10 table-th">@sortablelink('cost', __('poa.impact'))</th>
                        <th class="w-10 table-th">@sortablelink('cost', __('poa.complexity'))</th>
                        <th class="w-15 table-th"><a href="#">{{ trans('general.actions') }}</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($poaActTempl as $item)
                        <tr class="">
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->cost }}</td>
                            <td>{{\App\Models\Poa\PoaActivity::CATEGORIES[$item->impact]['text']}}</td>
                            <td>{{\App\Models\Poa\PoaActivity::CATEGORIES[$item->complexity]['text']}}</td>
                            <td>
                                <div class="d-flex flex-wrap">
                            <span data-toggle="modal" data-target="#edit_catalog_activity_modal" data-id="{{ $item->id }}">
                                <a class="mr-2" href="javascript:void(0);">
                                    <i class="fas fa-edit mr-1 text-info"></i>
                                </a>
                            </span>
                                    <x-delete-link action="{{ route('poa.delete_catalog_activities', $item->id) }}" id="{{ $item->id }}"/>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    @else

                        <x-empty-content>
                            <x-slot name="title">
                                {{trans('general.there_are_no_activities')}}
                            </x-slot>
                        </x-empty-content>
                    @endif
                    </tbody>
                </table>
            </div>
            <x-pagination :items="$poaActTempl"/>
            <livewire:poa.catalogs.poa-catalog-activity-create-modal/>
            <livewire:poa.catalogs.poa-catalog-activity-edit-modal/>
    </div>
@endsection
@push('page_script')
    <script>
        Livewire.on('toggleCatActivityEditModal', () => $('#edit_catalog_activity_modal').modal('toggle'));
        Livewire.on('toggleCatActivityAddModal', () => $('#add_catalog_activity_modal').modal('toggle'));
        $('#edit_catalog_activity_modal').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('id');
            //Livewire event trigger
            Livewire.emit('loadCatActEditForm', id);
        });

        $('#add_catalog_activity_modal').on('show.bs.modal', function (e) {
            //Livewire event trigger
            Livewire.emit('loadCatActAddForm');
        });

    </script>
@endpush