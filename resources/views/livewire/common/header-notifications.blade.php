<div wire:ignore.self>
    <a href="#" class="header-icon" data-toggle="dropdown">
        <i class="fal fa-bell"></i>
        <span class="badge badge-icon">{{ $notifications }}</span>
    </a>
    <div wire:ignore.self class="dropdown-menu dropdown-menu-animated dropdown-xl">
        <div wire:ignore.self class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top mb-2">
            <h4 class="m-0 text-center color-white">
                {{ trans_choice('header.notifications.counter', $notifications, ['count' => $notifications]) }}
                <small class="mb-0 opacity-80">{{ trans('header.notifications.user') }}</small>
            </h4>
        </div>
        <ul wire:ignore class="nav nav-tabs nav-tabs-clean" role="tablist">
            <li class="nav-item">
                <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab"
                   href="#tab-messages">{{ trans('header.messages') }}</a>
            </li>
        </ul>
        <div wire:ignore.self class="tab-content tab-notification">
            <div wire:ignore.self class="tab-pane" id="tab-messages" role="tabpanel">
                <div class="custom-scrollbar h-100">
                    <ul class="notification">
                        @php($today = true)
                        @php($yesterday = true)
                        @php($older = true)
                        @foreach($unreads as $item)
                            @if(date("Y-m-d", strtotime("now")) == substr($item->created_at, 0, 10))
                                @if($today)
                                    @php($today = false)
                                    <div class="pl-2 text-dark"><small>{{ __('header.today') }}</small></div>
                                @endif
                            @endif
                            @if(date("Y-m-d", strtotime("-1 days")) == substr($item->created_at, 0, 10))
                                @if($yesterday)
                                    @php($yesterday = false)
                                    <div class="pl-2 text-dark"><small>{{ __('header.yesterday') }}</small></div>
                                @endif
                            @endif
                            @if(date("Y-m-d", strtotime("-1 days")) > substr($item->created_at, 0, 10))
                                @if($older)
                                    @php($older = false)
                                    <div class="pl-2 text-dark"><small>{{ __('header.older') }}</small></div>
                                @endif
                            @endif
                            <li @if(!$item->read_at) style="background-color: #fffaee;" @else style="background-color: #e8e6ec;" @endif>
                                <a href="{{ $item->data['url'] }}" class="d-flex align-items-center show-child-on-hover">
                                    <span class="mr-2">
                                        <span class="profile-image rounded-circle d-inline-block"
                                              style="background-image:url({{ url('/') . '/img/avatar-m.png' }})"></span>
                                    </span>
                                    <span class="d-flex flex-column flex-1 ml-1">
                                        <span class="name">
                                            {{ $item->data['username'] }}
                                            @if(!$item->read_at)
                                                <span class="badge badge-primary fw-n position-absolute pos-top pos-right ">
                                                    {{ __('general.new') }}
                                                </span>
                                            @endif
                                        </span>
                                        <span class="msg-a fs-sm text-info">{{ $item->data['title'] }}</span>
                                        <span class="msg-b fs-xs">{{ $item->data['description'] }}</span>
                                        <span class="fs-nano text-muted mt-1">
                                            @php($times = strtotime("now") - strtotime($item->created_at))
                                            @php($timem = floor((strtotime("now") - strtotime($item->created_at)) / 60))
                                            @php($timeh = floor((strtotime("now") - strtotime($item->created_at)) / 3600))
                                            @php($timed = floor((strtotime("now") - strtotime($item->created_at)) / 86400))
                                            @if($times < 60)
                                                {{ trans_choice('header.time_since_seconds', 0, ['time' => $times]) }}
                                            @elseif($timem < 60)
                                                {{ trans_choice('header.time_since_minutes', 0, ['time' => $timem]) }}
                                            @elseif($timeh < 24)
                                                {{ trans_choice('header.time_since_hours', 0, ['time' => $timeh]) }}
                                            @else
                                                {{ trans_choice('header.time_since_days', 0, ['time' => $timed]) }}
                                            @endif
                                        </span>
                                    </span>
                                    @if(!$item->read_at)
                                        <div class="show-on-hover-parent position-absolute pos-right pos-bottom p-3">
                                            <a wire:click="markRead('{{ $item->id }}')" href="javascript:void(0)" class="text-muted" title="{{ __('general.read_mark') }}">
                                                <i class="fal fa-check-circle"></i>
                                            </a>
                                        </div>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="py-2 px-3 bg-faded d-block rounded-bottom  border-faded border-bottom-0 border-right-0 border-left-0">
            @if($totalNotifications)
                <a wire:click="readAll()" href="javascript:void(0)" class="fs-xs fw-500 ml-auto">
                    @if(!$viewAll)
                        {{ trans('header.notifications.view_all') }}
                    @else
                        {{ trans('header.notifications.view_unread') }}
                    @endif
                </a>
            @endif
            @if($notifications)
                <a wire:click="markAllRead()" href="javascript:void(0)" class="fs-xs fw-500 ml-auto float-right">
                    {{ trans('header.notifications.mark_all_read') }}
                </a>
            @endif
        </div>
    </div>
</div>