<div class="d-flex flex-wrap mb-3 mt-2">
    <div class="w-30">
        @if(isset($programs ) && count($programs) > 0)
            <div class="input-group bg-white shadow-inset-2 w-100 mr-2">
                <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                       placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.activities', 2) }} ..."
                       wire:model="search">
                <div class="input-group-append">
                <span class="input-group-text bg-transparent border-left-0">
                    <i class="fal fa-search"></i>
                </span>
                </div>
            </div>
        @endif
    </div>
    <div class="w-15">
        @if(isset($programs ) && count($programs) > 0)
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle @if(count($selectedPrograms) > 0) filtered @endif"
                        type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ trans_choice('general.programs', 2) }}
                    @if(count($selectedPrograms) > 0)
                        <span class="badge bg-white ml-2">{{ count($selectedPrograms) }}</span>
                    @endif
                </button>
                <div class="dropdown-menu">
                    @foreach($programs as $program)
                        <div class="dropdown-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="i-program-{{ $program['id'] }}" wire:model="selectedPrograms"
                                       value="{{ $program['id'] }}">
                                <label class="custom-control-label" for="i-program-{{ $program['id'] }}">{{  $program->planDetail->name }}</label>
                            </div>
                        </div>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-item">
                        <span wire:click="$set('selectedPrograms', [])">{{ trans('general.delete_selection') }}</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="w-10">
        @if(count($selectedPrograms) > 0 || $search != '')
            <a href="javascript:void(0);" class="btn btn-outline-default ml-2" wire:click="clearFilters">{{ trans('common.clean_filters') }}</a>
        @endif
    </div>
    <div class="d-inline-flex flex-column justify-content-center mr-3" bis_skin_checked="1">
                                    <span class="fw-300 fs-xs d-block opacity-50">
                                        <small>Total</small>
                                    </span>
        <span class="fw-500 fs-xl d-block color-primary-500">
               {{$total}}
        </span>
    </div>
</div>
