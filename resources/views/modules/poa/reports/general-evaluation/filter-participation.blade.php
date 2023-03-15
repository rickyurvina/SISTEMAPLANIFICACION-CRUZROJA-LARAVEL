<div class="col-12 mb-2 p-2">
    <div class="d-flex flex-wrap mb-2">
        <div class="d-flex flex-wrap w-100">
            <div class="d-flex w-20">
                <div class="form-group col-12">
                    <div class="position-relative w-100" x-data="{ open: false }">
                        <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if($selectUnits) filtered @endif"
                                x-on:click="open = ! open"
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
            @if($selectUnits !=null || $selectYears!=null)
                <div class="d-flex w-10">
                    <a href="javascript:void(0);" class="btn btn-outline-default ml-2"
                       wire:click="cleanFilters()">{{ trans('common.clean_filters') }}</a>
                </div>
            @endif
        </div>
    </div>
</div>
