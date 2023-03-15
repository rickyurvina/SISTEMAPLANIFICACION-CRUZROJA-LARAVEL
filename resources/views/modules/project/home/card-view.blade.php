<div class="row">
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

    @foreach($types as $type)
        <div class="col-3">
            <div class="card border mb-g">
                <div class="card-header d-flex align-items-center flex-wrap"
                     style="background-color: #3955bc">
                    <div class="card-title color-white">{{trans('general.'.$type)}}</div>
                </div>
                <div class="card-body">
                    @foreach($projects->where('type',$type) as $item)
                        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
                            <a href="{{ route('projects.showSummary', $item->id) }}"
                               class="card border border-info shadow-hover-5">
                                <div class="card-header border-0 pb-0 bg-white d-flex align-items-center flex-wrap">
                                    <div class="card-title">
                                                <span>
                                                    @if (is_object($item->picture))
                                                        <img src="{{ Storage::url($item->picture->id) }}"
                                                             class="rounded-circle width-2" alt="{{ $item->name }}">
                                                    @else
                                                        <img src="{{ asset_cdn("img/user.svg") }}"
                                                             class="rounded-circle width-2" alt="{{ $item->name }}">
                                                    @endif
                                                </span>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="badge {{ $item->phase->color() }}">{{ $item->phase->label() }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <span class="fs-xl font-weight-bolder color-black">{{ $item->name }}</span>
                                    <div class="progress progress-xs mt-3">
                                        <div class="progress-bar bg-danger-300 bg-warning-gradient"
                                             role="progressbar"
                                             style="width: {{ intval($item->tasks->where('parent','root')->first()->progress*100)}}%"
                                             aria-valuenow="30"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="profile-image-group mt-4">
                                        @foreach($item->members->take(2) as $member)
                                            @if (is_object($member->user->picture))
                                                <div class="img-item rounded-circle">
                                                    @if($loop->iteration == 2 && $item->members->count() > 2)
                                                        <span data-hasmore="+{{ $item->members->count() - 2 }}"
                                                              class="profile-image-md rounded-circle">
                                                                            <img src="{{ Storage::url($member->user->picture->id) }}"
                                                                                 class="profile-image-md"
                                                                                 alt="{{ $member->user->getFullName()  }}">
                                                                        </span>
                                                    @else
                                                        <img src="{{ Storage::url($member->user->picture->id) }}"
                                                             class="profile-image-md"
                                                             alt="{{ $member->user->getFullName()  }}">
                                                    @endif
                                                </div>
                                            @else
                                                <div class="img-item rounded-circle">
                                                    @if($loop->iteration == 2 && $item->members->count() > 2)
                                                        <span data-hasmore="+{{ $item->members->count() - 2 }}"
                                                              class="profile-image-md rounded-circle">
                                                                    <img src="{{ asset_cdn("img/user.svg") }}"
                                                                         class="profile-image-md"
                                                                         alt="{{ $member->user->getFullName() }}">
                                                                </span>
                                                    @else
                                                        <img src="{{ asset_cdn("img/user.svg") }}"
                                                             class="profile-image-md"
                                                             alt="{{ $member->user->getFullName() }}">
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>