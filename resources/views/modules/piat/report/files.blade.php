<div>
    @if($piatReport)
        <div class="d-flex flex-wrap">
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <livewire:components.files-in-modal :modelId="$piatReport->id"
                                                    model="{{\App\Models\Poa\Piat\PoaActivityPiatReport::class}}"
                                                    folder="piats"
                                                    event="fileAdded"
                                                    :key="time().$piatReport->id"

                />
            </div>
            <div class="flex-grow-1 w-100" style="overflow: hidden auto">
                <x-label-section>{{ trans('general.comments') }}</x-label-section>
                <livewire:components.comments :modelId="$piatReport->id"
                                              class="{{\App\Models\Poa\Piat\PoaActivityPiatReport::class}}"
                                              identifier="piats"
                                              :key="time().$piatReport->id"/>
            </div>
        </div>
    @endif
</div>
