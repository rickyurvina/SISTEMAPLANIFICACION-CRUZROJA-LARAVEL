<div class="d-flex flex-wrap">
    <x-label-detail>{{ trans('general.poa_activity_complexity') }}</x-label-detail>
    <div class="detail">
        @if($project->phase instanceof  \App\States\Project\Planning)
            <livewire:components.dropdown-simple :modelId="$task->id"
                                                 modelClass="\App\Models\Projects\Activities\Task"
                                                 :values="\App\Models\Poa\PoaActivity::CATEGORIES"
                                                 field="complexity"
                                                 event="App\Events\Projects\ProjectActivityWeightChanged"
                                                 eventLivewire="refreshPage"
                                                 :defaultValue="\App\Models\Poa\PoaActivity::CATEGORIES[$task->complexity ?? 1]"
            />
        @else
            <div class="dropdown-item">
                <i class="{{ \App\Models\Poa\PoaActivity::CATEGORIES[$task->complexity ?? 1]['icon']}}} mx-1 fw-700"></i>
                <span>{{ \App\Models\Poa\PoaActivity::CATEGORIES[$task->complexity ?? 1]['text']}}</span>
            </div>
        @endif
    </div>
</div>
<div class="d-flex flex-wrap mt-2">
    <x-label-detail>{{trans('general.cost')}}</x-label-detail>
    <div class="detail">
        @if($project->phase instanceof  \App\States\Project\Planning)

            <livewire:components.input-text :modelId="$task->id"
                                            class="\App\Models\Projects\Activities\Task"
                                            field="amount"
                                            :rules="'required|numeric'"
                                            event="App\Events\Projects\ProjectActivityWeightChanged"
                                            eventLivewire="refreshPage"
                                            defaultValue="{{ $task->amount}}"/>
        @else
            {{$task->amount}}
        @endif
    </div>
</div>
<div class="d-flex flex-wrap mt-2">
    <x-label-detail>{{trans('general.weight')}}</x-label-detail>
    <x-content-detail>{{number_format($task->weight, 2)  }}</x-content-detail>
</div>