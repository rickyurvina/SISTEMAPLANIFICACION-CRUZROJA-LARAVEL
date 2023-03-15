<div>
    <div class="form-group col-12">
        <div class="mb-2">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="province2" name="location" value="PROVINCE" wire:model="typeLocation">
                <label class="custom-control-label" for="province2">{{trans('general.province')}}</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="canton" name="location" value="CANTON" wire:model="typeLocation">
                <label class="custom-control-label" for="canton">{{trans('general.canton')}}</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="parish" name="location" value="PARISH" wire:model="typeLocation">
                <label class="custom-control-label" for="parish">{{trans('general.parish')}}</label>
            </div>
        </div>
        <div class="position-relative w-100" x-data="{ open: false }">
            <button class="btn btn-outline-secondary dropdown-toggle-custom w-100" x-on:click="open = ! open" type="button">
                <span class="spinner-border spinner-border-sm" wire:loading wire:target="typeLocation"></span>
                {{ $selectedLocationName != '' ? $selectedLocationName:trans('general.select')  }}
            </button>
            <div class="dropdown mb-2" x-on:click.outside="open = false" x-show="open" style="will-change: top, left;top: 37px;left: 0;">
                <div class="input-group bg-white">
                    <input type="text" class="form-control border-0 bg-transparent pr-0" placeholder="{{ trans('general.search') }}"
                           wire:model.debounce.500ms="searchLocation"
                           wire:keydown.escape="$set('searchLocation', '')"
                           x-on:escape="open = false">
                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent border-0" wire:click="$set('searchLocation', '')">
                                            @if($searchLocation != '')
                                                <i class="fal fa-times-circle cursor-pointer"></i>
                                            @else
                                                <i class="fal fa-search"></i>
                                            @endif
                                        </span>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child" wire:target="searchLocation">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
                <div wire:loading.class="hidden-child">
                    <div style="max-height: 300px; overflow-y: auto" class="w-100">
                        @forelse($locations as $item)
                            <div class="dropdown-item cursor-pointer" x-cloak
                                 @click="open = false" wire:key="{{time().$item->id}}"
                                 wire:click="$set('selectedLocationId', '{{ $item->id }}')">
                                <span>{{ $item->getPath() }}</span>
                            </div>
                        @empty
                            <div class="dropdown-item">
                                <span>{{ trans('general.select_location_type') }}</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
