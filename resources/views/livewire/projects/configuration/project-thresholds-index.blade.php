<div>
    <div class="d-flex mb-3">
        <div class="input-group bg-white shadow-inset-2 w-25 mr-2">
            <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                   placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.activities', 2) }} ..."
                   wire:model="search">
            <div class="input-group-append">
                <span class="input-group-text bg-transparent border-left-0">
                    <i class="fal fa-search"></i>
                </span>
            </div>
        </div>
        <div class="d-flex w-20">
            <div class="form-group col-12">
                <div class="position-relative w-100" x-data="{ open: false }">
                    <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if(count($selectedProjects) > 0) filtered @endif" x-on:click="open = ! open"
                            type="button">
                        <span class="spinner-border spinner-border-sm" wire:loading></span>
                        @if(count($selectedProjects) > 0)
                            <span class="badge bg-white ml-2">
                                @foreach($selectedProjects as $item)
                                    {{$item}}
                                @endforeach
                            </span>
                        @else
                            {{trans_choice('general.project',2)}}
                        @endif
                    </button>
                    <div class="dropdown mb-2 w-100" x-on:click.outside="open = false" x-show="open"
                         style="will-change: top, left;top: 37px;left: 0;">
                        <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child"
                             wire:target="searchLocation">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div wire:loading.class="hidden-child">
                            <div style="max-height: 300px; overflow-y: auto" class="w-100">
                                @if(empty($projects))
                                    <div class="dropdown-item" x-cloak
                                         @click="open = false">
                                        <span>{{ trans_choice('general.project',2) }}</span>
                                    </div>
                                @endif
                                @foreach($projects as $index => $item)
                                    <div class="dropdown-item cursor-pointer"
                                         wire:key="{{time().$index}}">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="i-project-{{ $item }}" wire:model="selectedProjects"
                                                   value="{{ $item->id }}">
                                            <label class="custom-control-label"
                                                   for="i-project-{{ $item }}">{{ $item->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                                @if(count($selectedProjects) > 0 )
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-item">
                                        <span wire:click="$set('selectedProjects', [])" class="cursor-pointer">{{ trans('general.delete_selection') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(count($selectedProjects) > 0 || $search != '')
            <div class="d-flex w-15">
                <a href="javascript:void(0);" class="btn btn-outline-default ml-2" wire:click="cleanFilters()">{{ trans('common.clean_filters') }}</a>
            </div>
        @endif
    </div>
    <div class="d-flex flex-wrap align-items-start">
        <div class="w-100 pl-2">
            @if($thresholds->count()>0)
                <div class="table-responsive">
                    <table class="table table-light table-hover">
                        <thead>
                        <tr>
                            <th class="w-auto table-th text-center">{{trans('general.progress')}}</th>
                            <th class="w-auto table-th text-center">{{trans('general.start_date')}}</th>
                            <th class="w-auto table-th text-center">{{trans('general.end_date')}}</th>
                            <th class="w-auto table-th text-center">{{trans('general.description')}}</th>
                            <th class="w-auto table-th text-center">{{trans('general.name')}}</th>
                            <th class="w-auto table-th text-center">{{trans_choice('general.thresholds',1)}}</th>
                            <th class="w-auto table-th text-center">{{trans('general.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($thresholds as $item)
                            @if($item->thresholdable)
                                <tr class="tr-hover">
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail>{{$item->progress_physic}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail>{{$item->start_date}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail>{{$item->end_date}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail>{{$item->description}}</x-label-detail>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center  ">
                                            <x-label-detail>{{$item->thresholdable->name ? $item->thresholdable->name  :$item->thresholdable->text }}</x-label-detail>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th colspan="2" class="text-center text-primary">{{trans('general.estimated_time')}}</th>
                                                <th colspan="2" class="text-center text-primary">{{trans('general.progress')}}</th>
                                            </tr>
                                            <tr>
                                                <th>{{trans('general.min')}}</th>
                                                <th>{{trans('general.max')}}</th>
                                                <th>{{trans('general.min')}}</th>
                                                <th>{{trans('general.max')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{$item->properties['time']['min'] ?? ''}}</td>
                                                <td>{{$item->properties['time']['max'] ?? ''}}</td>
                                                <td>{{$item->properties['progress']['min'] ?? ''}}</td>
                                                <td>{{$item->properties['progress']['max'] ?? ''}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_threshold"
                                           data-item-id="{{$item->id}}" class="">
                                            <i class="fas fa-pencil mr-1 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <x-pagination :items="$thresholds"/>
                </div>
            @else
                <x-empty-content>
                    <x-slot name="title">
                        {{trans('general.there_are_no_thresholds')}}
                    </x-slot>
                </x-empty-content>
            @endif
        </div>
    </div>
    <div wire:ignore>
        <livewire:projects.configuration.edit-threshold-project/>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleEditThreshold', () => $('#edit_threshold').modal('toggle'));

        $('#edit_threshold').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let id = $(e.relatedTarget).data('item-id');
            //Livewire event trigger
            Livewire.emit('openEditThreshold', id);
        });

    </script>
@endpush