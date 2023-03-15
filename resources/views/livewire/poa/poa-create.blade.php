<div>
    <div wire:ignore.self class="modal fade in" id="create-modal-poa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header mb-0 pb-0">
                    <h3 class="modal-title font-weight-bold">
                        {{ __('poa.poa_create') }} &nbsp;&nbsp;&nbsp;
                    </h3>
                    <button type="button" wire:click="resetModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body mt-4 pt-0">
                    <form method="post" id="create-form" wire:submit.prevent="store()"
                          id="save-poa">
                        <div class="d-flex flex-wrap justify-content-between w-100">
                            <div class="d-flex w-50">
                                <div class="position-relative w-100" x-data="{ open: false }">
                                    <button class="btn btn-outline-secondary dropdown-toggle-custom w-100  @if($year) filtered @endif"
                                            x-on:click="open = ! open"
                                            type="button">
                                        <span class="spinner-border spinner-border-sm" wire:loading></span>
                                        @if($year)
                                            <span class="badge bg-white ml-2">
                                                            {{$year}}
                                                    </span>
                                        @else
                                            {{trans('general.year')}}
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
                                                @if(empty($year))
                                                    <div class="dropdown-item" x-cloak
                                                         @click="open = false">
                                                        <span>{{ trans('general.year') }}</span>
                                                    </div>
                                                @endif
                                                @foreach($years as $index => $item)
                                                    <div class="dropdown-item cursor-pointer"
                                                         wire:key="{{time().$item}}">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" id="i-year-{{ $item }}" wire:click="$set('year',{{$item}})"
                                                                   value="{{ $item }}">
                                                            <label class="custom-control-label"
                                                                   for="i-year-{{ $item }}">{{ $item  }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex w-50 pl-2 ">
                                @if($year)
                                    <button type="submit" class="btn btn-success" id="btn-save">
                                        <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('page_script')
    <script>

    </script>
@endpush