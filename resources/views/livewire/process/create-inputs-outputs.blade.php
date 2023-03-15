<div class="row">
    <div class="col-6">
        <livewire:components.list-view-edit title="{{ __('general.inputs') }}"
                                            event="inputsAdded"
                                            componentId="inputs"
                                            :elements="$inputsItems"
        />
    </div>
    <div class="col-6">
        <livewire:components.list-view-edit title="{{ __('general.outputs') }}"
                                            event="outputsAdded"
                                            componentId="outputs"
                                            :elements="$outputsItems"
        />
    </div>
</div>
