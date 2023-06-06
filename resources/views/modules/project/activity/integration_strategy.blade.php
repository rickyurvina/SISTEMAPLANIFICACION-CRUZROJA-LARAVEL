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
            <div class="dropdown-menu" style="right: 0; left:0;height: 250px; overflow-y: scroll; width: 100% !important;">
                @foreach($programs as $program)
                    <div class="dropdown-item" wire:click="$set('poaProgramId', '{{ $program['id'] }}')"
                         style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                        <span>{{ $program->planDetail->name  }}</span>
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
                <span data-toggle="tooltip" data-placement="top"
                      title="{{$poaActivityIndicatorName ?? ''}}" data-original-title="{{ $poaActivityIndicatorName ?? '' }}">
                      @if($poaActivityIndicatorName != '')
                        {{ $poaActivityIndicatorName }}
                    @else
                        {{ trans('general.select') }}
                    @endif
                </span>

            </button>
            <div class="dropdown-menu"
                 style="right: 0; left:0;height: 250px; overflow-y: scroll; width: 100% !important;">
                @foreach($programIndicators as $programIndicator)
                    <div class="dropdown-item" wire:click="$set('poaActivityIndicatorId', '{{ $programIndicator->measure->id }}')"
                         style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                        <span style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;" data-toggle="tooltip" data-placement="top"
                              title="{{$programIndicator->measure->name }}" data-original-title="{{ $programIndicator->measure->name }}">
                           <i class="{{$programIndicator->measure->unit->getIcon() }}"></i>
                            {{ $programIndicator->measure->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@else
    @if($task->measure)
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

@endif