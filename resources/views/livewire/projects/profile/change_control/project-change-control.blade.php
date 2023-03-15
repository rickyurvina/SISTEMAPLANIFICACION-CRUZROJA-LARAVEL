<div wire:ignore.self>
    <div class="d-flex align-items-center mb-2" wire:ignore.self c>
        <div class="btn-group">
            <button type="button" class="btn btn-info" style="background-color: #0046AD">  {{trans('common.filters')}}
                <i class="fal fa-filter"></i></button>
            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split"
                    style="background-color: #0046AD" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <span class="sr-only"></span>
            </button>
            <div wire:ignore.self class="dropdown-menu" id="dropdown-filter" style="width: 50rem !important;">
                <div class="d-flex">
                    <div class="flex-fill p-3 w-75">
                        <h5 class="mb-0"> {{trans('general.user')}}</h5>
                        <div class="dropdown-divider"></div>
                        <div style="width: 100% !important;">
                            <select class="form-control"
                                    wire:model.defer="selectedUser">
                                <option value="">{{ trans('general.select') }}</option>
                                @if($users)
                                    @foreach($users as $index =>$item)
                                        <option value="{{$item->id}}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="flex-fill  p-3 w-100">
                        <h5 class="mb-0">  {{trans('general.dates_ranges')}}</h5>
                        <div class="dropdown-divider"></div>
                        <div class="form-group row">
                            <div class="col-12 col-lg-12">
                                <div class=" input-group">
                                    <input type="date" class="form-control" name="start" wire:model.defer="startDate">
                                    <div class="input-group-append input-group-prepend">
                                        <span class="input-group-text fs-xl"><i class="fal fa-ellipsis-h"></i></span>
                                    </div>
                                    <input type="date" class="form-control" name="end" wire:model.defer="endDate">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="text-right mr-3">
                    <button type="button" class="btn btn-xs btn-outline-primary fs-xl shadow-0"
                            wire:click="filter()"><span class="fal fa-filter mr-1"></span> {{trans('common.filter')}}
                    </button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-light ml-2" style="background-color: #D52B1E; color: white;"
                wire:click="cleanAllFilters()">  {{trans('common.clean_filters')}}</button>
        @foreach($filtersSelected as $f)
            <div class="alert alert-primary alert-dismissible fade show ml-1 mb-0" role="alert"
                 style="padding: 0.5rem 1.25rem !important;color: dimgray; background-color: #f3f1f5; border-color: #d6d3da; padding-right: 3.7rem !important; ">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        style="padding: 0.5rem 1.25rem !important;"
                        wire:click="cleanFilter('{{ $f['type'] }}')">
                    <span aria-hidden="true">×</span>
                </button>
                <strong> {{ strlen($f['name'])>15?substr($f['name'],0,15)."...": $f['name']  }}</strong>
            </div>
        @endforeach
    </div>
    <div class="card-header">
        <div class="d-flex position-relative ml-auto w-100">
            <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem"
               wire:target="search" wire:loading></i>
            <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem"
               wire:loading.remove></i>
            <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                   placeholder="Buscar por Acción">
        </div>
    </div>
    <div class="card">
        <div class="table-responsive" wire:ignore.self c>
            <table class="table m-0">
                <thead class="bg-primary-50">
                <tr>
                    <th>{{ trans('general.user')}}</th>
                    <th>{{ trans('general.action')}}</th>
                    <th>{{ trans('general.activity')}}</th>
                    <th>{{ trans('general.date')}}</th>
                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $activitiesLog as $item)
                    <tr>
                        <td>
                                                <span class="mr-2">
                                                @if (is_object($item->picture))
                                                        <img src="{{ Storage::url($item->causer->picture->id) }}"
                                                             class="rounded-circle width-2"
                                                             alt="  {{ $item->causer->name }}">
                                                    @else
                                                        <img src="{{ asset_cdn("img/user.svg") }}"
                                                             class="rounded-circle width-2"
                                                             alt="  {{ $item->causer->name }}}">
                                                    @endif
                                                </span>
                            {{ $item->causer->name }}
                        </td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->subject?$item->subject->name:'' }}</td>
                        <td>{{ $item->created_at->format('F j, Y, g:i a') }}</td>
                        <td class="text-center">
                            <a href="javascript:void(0);" class="" aria-expanded="false"
                               wire:click="$emitTo('projects.profile.change-control.project-change-control-detail', 'open', {{ $item->id }})">
                                <i class="fas fa-edit mr-1 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver detalles"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :items="$activitiesLog"/>
    </div>
    <div wire:ignore>
        <livewire:projects.profile.change-control.project-change-control-detail/>
    </div>
</div>
@push('page_script')
    <script>
        Livewire.on('toggleModalProjectChangeControlDetail', () => $('#project-change-control-detail').modal('toggle'));
        Livewire.on('toggleDropDownFilter', () => $("#dropdown-filter").removeClass("show"));
    </script>
@endpush
