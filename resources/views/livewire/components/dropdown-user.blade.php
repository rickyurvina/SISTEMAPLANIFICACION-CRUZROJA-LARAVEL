<div>
    <div class="position-relative content-wrapper" x-data="{ open: false }">
        <div class="child-wrapper" x-on:click="open = ! open">
            <div class="content-read" @if($user) data-toggle="tooltip" data-placement="top"
                 title="{{ $user->getFullName() }}" data-original-title="{{ $user->getFullName() }}" @endif>
                <div class="content-read-view">
                    @if($user)
                        @if($user->picture)
                            <span class="mr-2">
                            <img src="{{ asset_cdn('img/user.svg') }}" class="rounded-circle width-1">
                        </span>
                        @else
                            <span class="mr-2">
                            <img src="{{ asset_cdn('img/user_off.png') }}" class="rounded-circle width-1">
                        </span>
                        @endif
                        @if($onlyIcon===false)
                            <span class="pt-1">{{ $user->getFullName() }}</span>
                        @endif
                    @else
                        <span class="mr-2">
                        <img src="{{ asset_cdn('img/user_off.png') }}" class="rounded-circle width-1">
                    </span>
                        @if($onlyIcon===false)
                            <span class="pt-1">{{ trans('general.not_assigned') }}</span>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="dropdown mb-2" x-on:click.outside="open = false" x-show="open" style="will-change: top, left;top: 37px; @if($toLeft==true)left: -210px @else left:0px @endif;">
            <div class="input-group bg-white">
                <input type="text" class="form-control border-0 bg-transparent pr-0"
                       placeholder="{{ trans('general.search') }}"
                       wire:model.debounce.500ms="search"
                       wire:keydown.escape="$set('search', '')"
                       x-on:escape="open = false">
                <div class="input-group-append">
                <span class="input-group-text bg-transparent border-0" wire:click="$set('search', '')">
                    @if($search != '')
                        <i class="fal fa-times-circle cursor-pointer"></i>
                    @else
                        <i class="fal fa-search"></i>
                    @endif
                </span>
                </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="p-3 hidden-child" wire:loading.class.remove="hidden-child" wire:target="search">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div wire:loading.class="hidden-child">
                <div style="max-height: 300px; overflow-y: auto">
                    @forelse($users as $item)
                        <div class="dropdown-item cursor-pointer" x-cloak
                             @click="open = false"
                             wire:click="$set('selectedUserId', '{{ $item->id }}')">
                        <span class="mr-2">
                            <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-1">
                        </span>
                            <span class="pt-1">{{ $item->getFullName() }}</span>
                        </div>
                    @empty
                        <div class="dropdown-item cursor-pointer">
                            <span>{{ trans('messages.info.user_not_found') }}</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>


