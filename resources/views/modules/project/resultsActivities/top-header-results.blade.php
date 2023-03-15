<div class="d-flex mb-1 mt-1">
    <div class="input-group bg-white shadow-inset-2 w-25 mr-2">
        <input type="text" class="form-control border-right-0 bg-transparent pr-0"
               placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.activities', 2) }} ..."
               wire:model="search">
        <div class="input-group-append">
            <span class="input-group-text bg-transparent border-left-0">
                <i class="fal fa-search"></i>
            </span>
        </div>
    </div>
    @if(count($results) > 0)
        <div class="btn-group">
            <button class="btn btn-outline-secondary dropdown-toggle @if(count($selectedResults) > 0) filtered @endif"
                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ trans_choice('general.result',2)}}
                @if(count($selectedResults) > 0)
                    <span class="badge bg-white ml-2">{{ count($selectedResults) }}</span>
                @endif
            </button>
            <div class="dropdown-menu">
                @foreach($results as $result)
                    <div class="dropdown-item">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   id="i-program-{{ $result->id}}" wire:model="selectedResults"
                                   value="{{ $result->id }}">
                            <label class="custom-control-label"
                                   for="i-program-{{ $result->id }}">
                                {{ strlen($result->text)>40? substr($result->text , 0,40).'...': $result->text  }}
                            </label>
                        </div>
                    </div>
                @endforeach
                <div class="dropdown-divider"></div>
                <div class="dropdown-item">
                    <span wire:click="$set('selectedResults', [])">{{ trans('general.delete_selection') }}</span>
                </div>
                <div class="dropdown-item">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="showProgramPanel"
                               checked="" wire:model="showProgramPanel">
                        <label class="custom-control-label"
                               for="showProgramPanel">{{ trans('general.show_panel_results') }}</label>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(count($selectedResults) > 0 || $search != '')
        <a class="btn btn-outline-default ml-2"
           wire:click="clearFilters()">{{ trans('common.clean_filters') }}</a>
    @endif
    @if($project->phase instanceof \App\States\Project\Planning)
        <button type="button" class="btn btn-success border-0 shadow-0 ml-2" data-toggle="modal"
                data-target="#project-create-result-activity">{{ trans('general.create')}} {{trans('general.activity')}}
        </button>
    @endif
    <hr>
</div>
