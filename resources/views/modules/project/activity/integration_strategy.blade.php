@if($project->phase instanceof  \App\States\Project\Planning)
    <div class="d-flex flex-column w-100">
        <label class="form-label required">{{ trans_choice('general.programs', 1) }}</label>
        <div class="btn-group">
            <button class="btn btn-outline-secondary dropdown-toggle"
                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                @if($poaProgramId != null)
                    {{ $poaProgramName }}
                @else
                    {{ trans('general.select') }}
                @endif
            </button>
            <div class="dropdown-menu" style="left: 0; right: 0">
                @foreach($programs as $program)
                    <div class="dropdown-item" wire:click="$set('poaProgramId', '{{ $program['id'] }}')"
                         style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                        <span style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">{{ $program->planDetail->name  }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="d-flex flex-column w-100 mt-3">
        <label class="form-label required">{{ trans_choice('general.indicators', 1) }}</label>
        <div class="btn-group">
            <button class="btn btn-outline-secondary dropdown-toggle"
                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                @if($poaActivityIndicatorName != '')
                    {{ $poaActivityIndicatorName }}
                @else
                    {{ trans('general.select') }}
                @endif
            </button>
            <div class="dropdown-menu" style="left: 0; right: 0">
                @foreach($programIndicators as $programIndicator)
                    <div class="dropdown-item" wire:click="$set('poaActivityIndicatorId', '{{ $programIndicator->measure->id }}')"
                         style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                        <span style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                           <i class="{{$programIndicator->measure->unit->getIcon() }}"></i>
                            {{ $programIndicator->measure->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="d-flex flex-wrap mt-2">
        <x-label-detail>{{trans('general.program')}}</x-label-detail>
        <x-content-detail>  {{ $poaProgramName }}</x-content-detail>
    </div>
    <div class="d-flex flex-wrap mt-2">
        <x-label-detail>{{trans_choice('general.indicators', 1)}}</x-label-detail>
        <x-content-detail>
            <i class="{{$indicator->unit->getIcon() }}"></i>
            {{ $poaActivityIndicatorName }}</x-content-detail>
    </div>
@endif