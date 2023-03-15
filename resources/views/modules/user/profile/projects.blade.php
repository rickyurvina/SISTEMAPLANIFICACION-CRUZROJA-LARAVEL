<div class="card mb-g">
    <div class="card-body">
        <h2 class="mb-0 fs-xl">
            {{trans('general.projects_in_charge')}}
        </h2>
    </div>
    @foreach($user->projects as $item)
        @if($loop->iteration<=3)
            <a href="{{ route('projects.show', $item->id) }}" class="card border shadow-hover-5">
                <div class="card-body">
                    <span class="fs-xl font-weight-bolder color-black">{{ $item->name }}</span>
                    <p class="card-text color-fusion-50"{{ $item->description }}</p>
                    <div class="progress progress-xs mt-3">
                        <div class="progress-bar bg-danger-300 bg-warning-gradient" role="progressbar" style="width: 30%" aria-valuenow="30"
                             aria-valuemin="0"
                             aria-valuemax="100">
                        </div>
                    </div>
                    <div class="profile-image-group mt-4">
                        @foreach($item->members->take(2) as $member)
                            @if (is_object($member->picture))
                                <div class="img-item rounded-circle">
                                    @if($loop->iteration == 2 && $item->members->count() > 2)
                                        <span data-hasmore="+{{ $item->members->count() - 2 }}" class="profile-image-md rounded-circle">
                                            <img src="{{ Storage::url($member->picture->id) }}"
                                                 class="profile-image-md" alt="{{ $member->full_name }}">
                                        </span>
                                    @else
                                        <img src="{{ Storage::url($member->picture->id) }}"
                                             class="profile-image-md" alt="{{ $member->full_name }}">
                                    @endif

                                </div>
                            @else
                                <div class="img-item rounded-circle">
                                    @if($loop->iteration == 2 && $item->members->count() > 2)
                                        <span data-hasmore="+{{ $item->members->count() - 2 }}" class="profile-image-md rounded-circle">
                                            <img src="{{ asset_cdn("img/user.svg") }}" class="profile-image-md"
                                                 alt="{{ $member->full_name }}">
                                        </span>
                                    @else
                                        <img src="{{ asset_cdn("img/user.svg") }}" class="profile-image-md"
                                             alt="{{ $member->full_name }}">
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </a>
        @endif
    @endforeach
    <div class="collapse" id="collapseProjects">
        @foreach($user->projects as $item)
            @if($loop->iteration>3)
                <a href="{{ route('projects.show', $item->id) }}" class="card border shadow-hover-5">

                    <div class="card-body">
                        <span class="fs-xl font-weight-bolder color-black">{{ $item->name }}</span>
                        <p class="card-text color-fusion-50"{{ $item->description }}</p>
                        <div class="progress progress-xs mt-3">
                            <div class="progress-bar bg-danger-300 bg-warning-gradient" role="progressbar" style="width: 30%" aria-valuenow="30"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>
                        <div class="profile-image-group mt-4">
                            @foreach($item->members->take(2) as $member)
                                @if (is_object($member->picture))
                                    <div class="img-item rounded-circle">
                                        @if($loop->iteration == 2 && $item->members->count() > 2)
                                            <span data-hasmore="+{{ $item->members->count() - 2 }}" class="profile-image-md rounded-circle">
                                            <img src="{{ Storage::url($member->picture->id) }}"
                                                 class="profile-image-md" alt="{{ $member->full_name }}">
                                        </span>
                                        @else
                                            <img src="{{ Storage::url($member->picture->id) }}"
                                                 class="profile-image-md" alt="{{ $member->full_name }}">
                                        @endif

                                    </div>
                                @else
                                    <div class="img-item rounded-circle">
                                        @if($loop->iteration == 2 && $item->members->count() > 2)
                                            <span data-hasmore="+{{ $item->members->count() - 2 }}" class="profile-image-md rounded-circle">
                                                                    <img src="{{ asset_cdn("img/user.svg") }}" class="profile-image-md"
                                                                         alt="{{ $member->full_name }}">
                                                                </span>
                                        @else
                                            <img src="{{ asset_cdn("img/user.svg") }}" class="profile-image-md"
                                                 alt="{{ $member->full_name }}">
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
    <div class="col-12">
        <div class="p-3 text-center">
            <a data-toggle="collapse" href="#collapseProjects" role="button" aria-expanded="false" aria-controls="collapseProjects"
               class="btn-link font-weight-bold">{{trans('general.see_more')}}</a>
        </div>
    </div>
</div>
