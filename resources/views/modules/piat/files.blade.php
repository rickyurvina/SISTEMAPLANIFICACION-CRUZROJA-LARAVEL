<div>
    @if($piat)
        <div class="d-flex flex-wrap">
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <livewire:components.files-in-modal :modelId="$piat->id"
                                                    model="{{\App\Models\Poa\Piat\PoaActivityPiat::class}}"
                                                    folder="piat"
                                                    event="fileAdded"
                                                    :key="time().$piat->id"

                />
            </div>
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <x-label-section>{{ trans('general.comments') }}</x-label-section>
                <livewire:components.comments :modelId="$piat->id"
                                              class="{{\App\Models\Poa\Piat\PoaActivityPiat::class}}"
                                              identifier="piat"
                                              :key="time().$piat->id"/>
            </div>
        </div>
    @endif
</div>
