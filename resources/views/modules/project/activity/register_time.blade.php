@if($project->phase instanceof  \App\States\Project\Implementation)
    <div class="d-flex flex-wrap mt-2" wire:loading.class="bg-warning-100">
        {{--                                                    @if($showPanelWork===false)--}}
        <x-label-detail>Seguimiento de Tiempo</x-label-detail>
        <x-content-detail>
            <div class="progress cursor-pointer"
                 style="width: 100% !important;"
                 wire:click="showPanelWorkLog()">
                <div class="progress-bar" role="progressbar"
                     style="width: {{ $widthProgress }}%;"
                     aria-valuenow="{{$registerTime}}" aria-valuemin="0"
                     aria-valuemax="100">
                    {{ $task->workLogs->sum('value') }}h
                </div>
            </div>
        </x-content-detail>
        {{--                                                    @endif--}}
    </div>
@endif
<div class="d-flex flex-wrap mt-2">
    @if($showPanelWork)
        <div class="text-center">
            <x-label-section>Registrar Tiempo</x-label-section>
        </div>
        <div class="w-100 pr-2" wire:loading.class="bg-warning-100">

            <div class="d-flex flex-wrap mt-2">
                <x-label-detail>{{ trans('general.value') }}(h)
                </x-label-detail>
                <div class="detail">
                    <input type="number" min="0" max="24"
                           class="form-control" name="valueWorkLog"
                           id="valueWorkLog"
                           wire:model.defer="valueWorkLog" placeholder="4">
                </div>
            </div>
            <div class="d-flex flex-wrap mt-2">
                <x-label-detail>{{ trans('general.description') }}</x-label-detail>
                <div class="detail">
                                                                <textarea name="valueWorkLogText" id="valueWorkLogText"
                                                                          class="form-control w-100" rows="3"
                                                                          wire:model.defer="valueWorkLogText"></textarea>
                </div>
            </div>
            <div class="text-center p-2">
                <button wire:click="$set('showPanelWork', false)"
                        class="btn btn-outline-info btn-sm">
                    <i class="fas fa-trash pr-2"></i> Cancelar
                </button>
                <button wire:click="saveWorkLog()"
                        class="btn btn-success btn-sm">
                    <i class="fas fa-save pr-2"></i> Guardar
                </button>
            </div>
        </div>
    @endif
</div>