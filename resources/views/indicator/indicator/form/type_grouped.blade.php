@if(isset($this->indicators))
    <div class="d-flex w-100 m-2">
        <div class="form-group col-12">
            <div class="position-relative w-100" x-data="{ open: false }">
                <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if(count($indicatorsSelected) > 0) filtered @endif"
                        x-on:click="open = ! open"
                        type="button">
                    <span class="spinner-border spinner-border-sm" wire:loading></span>
                    @if(count($indicatorsSelected) > 0)
                        <span class="badge bg-white ml-2">
                                                            {{ count($indicatorsSelected) }}
                                                    </span>
                    @else
                        {{trans_choice('general.indicators',1)}}
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
                            @if(empty($indicators))
                                <div class="dropdown-item" x-cloak
                                     @click="open = false">
                                    <span>{{ trans('general.name') }}</span>
                                </div>
                            @endif
                            @foreach($indicators as $index => $item)
                                <div class="dropdown-item cursor-pointer"
                                     wire:key="{{time().$index}}" wire:ignore.self>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="i-indicator-{{ $item->id }}"
                                               wire:model="indicatorsSelected" name="indicatorsSelected[]"
                                               value="{{ $item->id }}">
                                        <label class="custom-control-label"
                                               for="i-indicator-{{ $item->id }}">{{ $item->name }}</label>
                                    </div>
                                </div>

                            @endforeach
                            @if(count($indicatorsSelected) > 0 )
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-item">
                                    <span wire:click="$set('indicatorsSelected', [])"
                                          class="cursor-pointer">{{ trans('general.delete_selection') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('indicatorsSelected',':message') }} </div>
        </div>
    </div>
@endif
@if(isset($goalValueTotal))
    <div class="form-group col-12">
        <dl>
            <dt class="col-sm-10">
                <h5><strong>{{trans('indicators.indicator.total_goal_value') }}
                    </strong>
                </h5>
            </dt>
            <dd class="col-sm-2">
                {{ $goalValueTotal }}
            </dd>
            <dt class="col-sm-10"><h5><strong>{{trans('indicators.indicator.total_actual_value') }}</strong></h5></dt>
            <dd class="col-sm-2">
                {{ $actualValueTotal }}
            </dd>
        </dl>
    </div>
@endif