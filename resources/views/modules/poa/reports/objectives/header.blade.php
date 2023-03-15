<div class="d-flex flex-wrap mb-2">
    <div class="d-flex flex-wrap w-100">
        @can('poa-view-all-poas')
            <div class="d-flex w-30">
                <div class="form-group col-12">
                    <div class="position-relative w-100" x-data="{ open: false }">
                        <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if($selectProvinces)
                                filtered @endif" x-on:click="open = ! open"
                                type="button">
                            <span class="spinner-border spinner-border-sm" wire:loading></span>
                            @if($selectProvinces)
                                Provincia
                            @else
                                {{trans('general.province')}}
                            @endif
                        </button>
                        <div class="dropdown mb-2 w-100" x-on:click.outside="open = false" x-show="open"
                             style="will-change: top, left;top: 37px;left: 0;">
                            <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div wire:loading.class="hidden-child">
                                <div style="max-height: 550px; overflow-y: auto" class="w-100">
                                    @if(empty($selectProvinces))
                                        <div class="dropdown-item" x-cloak
                                             @click="open = false">
                                            <span>{{ trans('general.province') }}</span>
                                        </div>
                                    @endif
                                    @foreach($provinces as $index => $item)
                                        <div class="dropdown-item cursor-pointer"
                                             wire:key="{{time().$index.$item->id}}">
                                            <div class="custom-control custom-radio" wire:click="$set('selectProvinces',{{$item->id}})">
                                                <input type="radio" class="custom-control-input" id="i-province-{{ $item->id }}"
                                                       name="defaultProvince" @if($selectProvinces==$item->id) checked @endif>
                                                <label class="custom-control-label"
                                                       for="i-province-{{ $item->id }}">{{ $item->name  }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex w-25">
                <div class="form-group col-12">
                    <div class="position-relative w-100" x-data="{ open: false }">
                        <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if(count($selectCantons) > 0)
                                filtered @endif" x-on:click="open = ! open"
                                type="button">
                            <span class="spinner-border spinner-border-sm" wire:loading></span>
                            @if(count($selectCantons) > 0)
                                <span class="badge bg-white ml-2">
                                    @foreach($selectCantons as $item)
                                        {{$cantons->find($item)->name.' / '}}
                                    @endforeach
                                </span>
                            @else
                                {{trans('general.cantons')}}
                            @endif
                        </button>
                        <div class="dropdown mb-2 w-100" x-on:click.outside="open = false" x-show="open"
                             style="will-change: top, left;top: 37px;left: 0;">
                            <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div wire:loading.class="hidden-child">
                                <div style="max-height: 300px; overflow-y: auto" class="w-100">
                                    @if(empty($cantons))
                                        <div class="dropdown-item" x-cloak
                                             @click="open = false">
                                            <span>{{ trans('general.type') }}</span>
                                        </div>
                                    @endif
                                    @foreach($cantons as $index => $item)
                                        <div class="dropdown-item cursor-pointer"
                                             wire:key="{{time().$index.$item->id}}">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="i-canton-{{ $item->id }}" wire:model="selectCantons"
                                                       value="{{ $item->id }}">
                                                <label class="custom-control-label"
                                                       for="i-canton-{{ $item->id }}">{{ $item->name  }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if(count($selectCantons) > 0 )
                                        <div class="dropdown-divider"></div>
                                        <div class="dropdown-item">
                                            <span wire:click="$set('selectCantons', [])" class="cursor-pointer">{{ trans('general.delete_selection') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        <div class="d-flex w-20">
            <div class="form-group col-12">
                <div class="position-relative w-100" x-data="{ open: false }">
                    <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if($selectUnits) filtered @endif" x-on:click="open = ! open"
                            type="button">
                        <span class="spinner-border spinner-border-sm" wire:loading></span>
                        @if($selectUnits!=null)
                            <span class="badge bg-white ml-2">
                                    {{$indicatorUnits->find($selectUnits)->name}}
                                </span>
                        @else
                            {{trans('general.indicator_unit')}}
                        @endif
                    </button>
                    <div class="dropdown mb-2 w-100" x-on:click.outside="open = false" x-show="open"
                         style="will-change: top, left;top: 37px;left: 0;">
                        <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div wire:loading.class="hidden-child">
                            <div style="max-height: 300px; overflow-y: auto" class="w-100">
                                @if(empty($indicatorUnits))
                                    <div class="dropdown-item" x-cloak
                                         @click="open = false">
                                        <span>{{ trans('general.type') }}</span>
                                    </div>
                                @endif
                                @foreach($indicatorUnits as $index => $item)
                                    <div class="dropdown-item cursor-pointer"
                                         wire:key="{{time().$index.$item->abbreviation}}">
                                        <div class="custom-control custom-radio" wire:click="$set('selectUnits',{{$item->id}})">
                                            <input type="radio" class="custom-control-input" id="i-unit-{{ $item->id }}"
                                                   name="defaultIndicatorUnit" @if($selectUnits==$item->id) checked @endif>
                                            <label class="custom-control-label"
                                                   for="i-unit-{{ $item->id }}">{{ $item->name  }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex w-10">
            <div class="form-group col-12">
                <div class="position-relative w-100" x-data="{ open: false }">
                    <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if($selectYears) filtered @endif" x-on:click="open = ! open"
                            type="button">
                        <span class="spinner-border spinner-border-sm" wire:loading></span>
                        @if($selectYears)
                            <span class="badge bg-white ml-2">
                                        {{$selectYears}}
                                </span>
                        @else
                            {{trans('general.year')}}
                        @endif
                    </button>
                    <div class="dropdown mb-2 w-100" x-on:click.outside="open = false" x-show="open"
                         style="will-change: top, left;top: 37px;left: 0;">
                        <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div wire:loading.class="hidden-child">
                            <div style="max-height: 300px; overflow-y: auto" class="w-100">
                                @if(empty($years))
                                    <div class="dropdown-item" x-cloak
                                         @click="open = false">
                                        <span>{{ trans('general.year') }}</span>
                                    </div>
                                @endif
                                @foreach($years as $index => $item)
                                    <div class="dropdown-item cursor-pointer"
                                         wire:key="{{time().$index}}">
                                        <div class="custom-control custom-radio" wire:click="$set('selectYears',{{$item}})">
                                            <input type="radio" class="custom-control-input" id="i-years-{{ $item }}" name="radioGroupYear" wire:model="selectYears"
                                                   value="{{ $item }}">
                                            <label class="custom-control-label"
                                                   for="i-years-{{ $item }}">{{ $item  }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($selectUnits !=null || $selectYears!=null || count($selectCantons)>0 || $selectProvinces!=null)
            <div class="d-flex w-10">
                <a href="javascript:void(0);" class="btn btn-outline-default ml-2" wire:click="cleanFilters()">{{ trans('common.clean_filters') }}</a>
            </div>
        @endif
        <div class="d-flex ml-auto w-5">
            <a href="javascript:void(0)" class="color-success-500" wire:click="exportExcel()"><span class="fas fa-file-excel fa-2x"></span> {{ trans('general.excel') }}</a>
        </div>
    </div>
</div>