<div>
    <div class="d-flex flex-wrap mb-2">
        <div class="d-flex flex-wrap w-100">
            <div class="d-flex w-50">
                <div class="pr-2 d-flex flex-wrap w-100">
                    <div class="d-flex position-relative mr-auto w-100">
                        <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem" wire:target="search" wire:loading></i>
                        <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem" wire:loading.remove></i>
                        <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                               placeholder="Buscar...">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-container show">
        @if($measures->count()>0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table  m-0">
                        <thead class="bg-primary-50">
                        <tr>
                            <th class="w-10">
                                <a wire:click.prevent="sortBy('code')" role="button" href="#">
                                    {{trans('general.code')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="code"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>

                            <th class="w-35">
                                <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                    {{trans('general.name')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="name"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="w-15">
                                <a wire:click.prevent="sortBy('unit_id')" role="button" href="#">
                                    {{trans('general.indicator_unit')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="unit_id"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>
                            <th class="w-15">
                                <a wire:click.prevent="sortBy('user_id')" role="button" href="#">
                                    {{trans('general.responsible')}}
                                    <x-sort-icon sortDirection="{{$sortDirection}}" sortField="user_id"
                                                 field="{{$sortField}}"></x-sort-icon>
                                </a>
                            </th>

                            <th class="color-primary-500 w-10">
                                {{ trans('general.actions') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($measures as $index=>$item)
                            <tr wire:key="{{time().$index.$item->id}}">
                                <td>{{$item->indicatorable->full_code.'.'.$item->code}}</td>
                                <td>
                                     <span>
                                         <i class="{{$item->unit->getIcon() }}"></i>
                                           {{$item->name}}
                                    </span>
                                </td>
                                <td>{{$item->unit->name}}</td>
                                <td>{{$item->responsible->getFullName()}}</td>
                                <td class="text-center">
                                    <div class="frame-wrap">
                                        <div class="d-flex justify-content-start">
                                            @if($item->scores->sum('actual')<1)
                                                <div class="p-1 mt-1">
                                                    <a href="javascript:void(0)"
                                                       data-toggle="modal"
                                                       data-target="#measure-edit-modal"
                                                       data-measure-id="{{$item->id}}"><i
                                                                class="fas fa-edit text-success ml-2"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="p-1 mt-1">
                                                <a href="javascript:void(0)"
                                                   data-toggle="modal"
                                                   data-target="#measure-update-goals"
                                                   data-measure-id="{{$item->id}}">
                                                    <i aria-expanded="false"
                                                       data-toggle="tooltip" data-placement="top" title=""
                                                       data-original-title=" {{trans('general.update_frequencies')}}"
                                                       class="fas fa-book-open text-info ml-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <x-pagination :items="$measures"/>
                </div>
            </div>
        @else
            <x-empty-content>
                <x-slot name="title">
                    No existen indicadores
                </x-slot>
            </x-empty-content>
        @endif
    </div>
    <div wire:ignore.self>
        <livewire:measure.measure-edit/>
    </div>
    <div wire:ignore.self>
        <livewire:measure.measure-update-goals/>
    </div>
</div>

@push('page_script')
    <script>
        $('#measure-edit-modal').on('show.bs.modal', function (e) {
            let id = $(e.relatedTarget).data('measure-id');
            window.livewire.emitTo('measure.measure-edit', 'show', id);
        });
        $('#measure-update-goals').on('show.bs.modal', function (e) {
            let id = $(e.relatedTarget).data('measure-id');
            window.livewire.emitTo('measure.measure-update-goals', 'show', id);
        });
    </script>
@endpush