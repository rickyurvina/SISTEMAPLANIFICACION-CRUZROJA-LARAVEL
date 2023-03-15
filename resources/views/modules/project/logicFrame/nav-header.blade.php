<div class="d-flex mb-3">
    <div class="input-group bg-white shadow-inset-2 w-25 mr-2">
        <input type="text" class="form-control border-right-0 bg-transparent pr-0"
               placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.result', 2) }} ..."
               wire:model="search">
        <div class="input-group-append">
            <span class="input-group-text bg-transparent border-left-0">
                <i class="fal fa-search"></i>
            </span>
        </div>
    </div>

    @if(count($objectives) > 0)
        <div class="btn-group">
            <button class="btn btn-outline-secondary dropdown-toggle @if(count($selectedObjectives) > 0) filtered @endif"
                    type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                {{ trans('general.objectives_name')}}
                @if(count($selectedObjectives) > 0)
                    <span class="badge bg-white ml-2">{{ count($selectedObjectives) }}</span>
                @endif
            </button>
            <div class="dropdown-menu" style="min-width: 30rem !important;">
                @foreach($objectives as $objective)
                    <div class="dropdown-item">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   id="i-program-{{ $objective['id'] }}"
                                   wire:model="selectedObjectives"
                                   value="{{ $objective['id'] }}">
                            <label class="custom-control-label"
                                   for="i-program-{{ $objective['id'] }}">{{ strlen($objective['name'])>40? substr($objective['name'], 0,40).'...': $objective['name']  }}</label>
                        </div>
                    </div>
                @endforeach
                <div class="dropdown-divider"></div>
                <div class="dropdown-item">
                    <span wire:click="$set('selectedObjectives', [])">{{ trans('general.delete_selection') }}</span>
                </div>
                <div class="dropdown-item">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input"
                               id="showProgramPanel" checked="" wire:model="showProgramPanel">
                        <label class="custom-control-label"
                               for="showProgramPanel">{{ trans('general.show_panel_objectives') }}</label>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(count($selectedObjectives) > 0 || $search != '')
        <a class="btn btn-outline-default ml-2"
           wire:click="clearFilters()">{{ trans('common.clean_filters') }}</a>
    @endif
    <button type="button" class="btn btn-success btn-sm border-0 shadow-0 ml-2" data-toggle="modal"
            data-target="#project-create-specific-objective">{{ trans('general.create')}}  {{trans('general.objectives_name')}}
    </button>

    <button type="button" class="btn btn-success btn-sm border-0 shadow-0 ml-2" data-toggle="modal"
            data-target="#project-objectives-weight">{{ trans('general.weight')}}  {{trans('general.objectives_name')}}
    </button>


    <x-tooltip-help
            message="{{$messages->where('code','marco_logico')->first()->description}}"></x-tooltip-help>
</div>
