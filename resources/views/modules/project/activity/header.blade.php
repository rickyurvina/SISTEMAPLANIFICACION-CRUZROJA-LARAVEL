<div class="d-flex flex-wrap w-65">
    <div class="w-100">
        <livewire:components.input-text :modelId="$task->id"
                                        class="\App\Models\Projects\Activities\Task"
                                        field="text"
                                        :title="true"
                                        :rules="'required|max:250|min:3'"
                                        defaultValue="{{ $task->text }}"/>


    </div>
</div>
<div class="d-flex flex-wrap p-2 w-35">
    <div class="mr-2">
        <x-label-detail>Progreso: <small
                    class="badge badge-success">{{ $progressBarSubActiviites}}%</small>
        </x-label-detail>
    </div>
    <span class="badge badge-info">{{$task->company->name}}</span>
</div>