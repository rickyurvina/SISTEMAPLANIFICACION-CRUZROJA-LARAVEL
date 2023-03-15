<div class="d-flex flex-wrap w-75">
    <div class="d-flex flex-column p-2 w-25" wire:ignore>
        <x-label-detail>Estado</x-label-detail>
        <select class="form-control" id="select2-states">
            <option value="{{ \App\States\Transaction\Draft::label() }}">{{ \App\States\Transaction\Draft::label() }}</option>
            <option value="{{ \App\States\Transaction\Approved::label() }}">{{ \App\States\Transaction\Approved::label() }}</option>
            <option value="{{ \App\States\Transaction\Rejected::label() }}">{{ \App\States\Transaction\Rejected::label() }}</option>
            <option value="{{ \App\States\Transaction\Override::label() }}">{{ \App\States\Transaction\Override::label() }}</option>
        </select>
    </div>
    <div class="d-flex flex-column p-2 w-15">
        <button type="button" class="btn btn-outline-default ml-2 mt-3"
                wire:click="clearFilters">{{ trans('common.clean_filters') }}
        </button>
    </div>
</div>

<div class="d-flex flex-wrap mt-2 p-2" wire:ignore>
    <div class="w-5">
        <label for="countRegisters" class="mt-2">
            Mostrar
        </label>
    </div>
    <div class="w-15">
        <select class="form-control" id="select2-registers" wire:model="countRegisterSelect">
            <option value="1">1</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <div class="w-5 mr-6 ml-2">
        <label for="countRegisters2" class="mt-2">
            Registros
        </label>
    </div>
    <div class="w-50">
        <div class="d-flex mb-3">
            <div class="input-group bg-white shadow-inset-2 w-100 mr-2">
                <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                       placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.reforms', 1) }} por descripción ..."
                       wire:model="search">
                <div class="input-group-append">
                        <span class="input-group-text bg-transparent border-left-0">
                            <i class="fal fa-search"></i>
                        </span>
                </div>
            </div>
        </div>
    </div>
</div>