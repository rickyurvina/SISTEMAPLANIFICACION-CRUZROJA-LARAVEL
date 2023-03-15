<div class="mt-2">
    <livewire:components.files :modelId="$task->id"
                               model="\App\Models\Projects\Activities\Task"
                               folder="activities"
                               event="fileAdded"
    />
</div>
<div class="mt-2">
    <x-label-section>{{ trans('general.comments') }}</x-label-section>
    <livewire:components.comments :modelId="$task->id"
                                  class="\App\Models\Projects\Activities\Task"
                                  :key="time().$task->id"
                                  identifier="activities"
                                  event="commentAdded"
    />
</div>