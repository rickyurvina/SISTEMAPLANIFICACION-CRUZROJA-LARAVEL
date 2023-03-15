<div>

    <div class="col-12">
        <div class="card-header pr-2 d-flex flex-wrap w-100">
            <div class="d-flex position-relative mr-auto w-100">
                <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem" wire:target="search" wire:loading></i>
                <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem" wire:loading.remove></i>
                <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                       placeholder="Buscar...">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table m-0">
            <thead class="bg-primary-50">
            <tr>
                <th>
                    <a wire:click.prevent="sortBy('description')" role="button" href="#">
                        {{trans('general.name')}}
                        <x-sort-icon sortDirection="{{$sortDirection}}" sortField="description"
                                     field="{{$sortField}}"></x-sort-icon>
                    </a>
                </th>
                <th>
                    <a wire:click.prevent="sortBy('code')" role="button" href="#">
                        {{trans('general.code')}}
                        <x-sort-icon sortDirection="{{$sortDirection}}" sortField="code"
                                     field="{{$sortField}}"></x-sort-icon>
                    </a>
                </th>
                <th>
                    <a wire:click.prevent="sortBy('full_code')" role="button" href="#">
                        {{trans('general.full_code')}}
                        <x-sort-icon sortDirection="{{$sortDirection}}" sortField="full_code"
                                     field="{{$sortField}}"></x-sort-icon>
                    </a>
                </th>
                <th>
                    <a wire:click.prevent="sortBy('type')" role="button" href="#">
                        {{trans('general.type')}}
                        <x-sort-icon sortDirection="{{$sortDirection}}" sortField="type"
                                     field="{{$sortField}}"></x-sort-icon>
                    </a>
                </th>
                @can('budget-crud-budget')
                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($geographicClassifier as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->full_code }}</td>
                    <td>{{ $item->type }}</td>
                    @can('budget-crud-budget')
                        <td class="text-center">

                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-pagination :items="$geographicClassifier"/>
</div>
