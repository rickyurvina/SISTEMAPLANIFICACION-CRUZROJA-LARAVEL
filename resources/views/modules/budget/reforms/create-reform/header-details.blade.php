<div class="d-flex flex-wrap p-2 mt-2">
    <h2><i class="fa fa-plus text-success"></i> Adicionar Partida Presupuestaria</h2>
</div>
<div class="d-flex flex-wrap w-100">
    <div class="d-flex flex-column p-2 w-50">
        <x-label-detail>{{trans('budget.item_code')}}</x-label-detail>
        <x-content-detail> {{ $account->code }}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-50">
        <x-label-detail>{{trans('general.name')}}</x-label-detail>
        <x-content-detail> {{ $account->name }}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-50">
        <x-label-detail>{{trans('general.description')}}</x-label-detail>
        <x-content-detail> {{ $account->description }}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-50">
        <x-label-detail>{{trans('budget.balance')}}</x-label-detail>
        <x-content-detail> {{ $account->balance }}</x-content-detail>
    </div>
    @if($typeReformSelected == \App\Models\Budget\Transaction::REFORM_TYPE_INCREMENT || $typeReformSelected == \App\Models\Budget\Transaction::REFORM_TYPE_TRANSFER)
        <div class="d-flex flex-column p-2 w-50">
            <x-label-detail>{{trans('budget.increment')}}</x-label-detail>
            <div class="detail">
                <div class="form-group col-md-12 required">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text badge badge-success">$</span>
                        </div>
                        <input type="number" wire:model.defer="increment" id="increment" placeholder="Ej: 4500.55" class="form-control  @error('increment') is-invalid @enderror">
                        @error('increment')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($typeReformSelected == \App\Models\Budget\Transaction::REFORM_TYPE_DECREASE || $typeReformSelected == \App\Models\Budget\Transaction::REFORM_TYPE_TRANSFER)
        <div class="d-flex flex-column p-2 w-50">
            <x-label-detail>{{trans('budget.decrease')}}</x-label-detail>
            <div class="detail">
                <div class="form-group col-md-12 required">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text badge badge-success">$</span>
                        </div>
                        <input type="number" wire:model.defer="decrease" id="decrease" placeholder="Ej: 4500.55" class="form-control @error('decrease') is-invalid @enderror">
                        @error('decrease')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="row mt-1">
    <div class="col-12 text-center">
        <button class="btn btn-success text-center" wire:click="addReform">
            <i class="fas fa-plus pr-2"></i> {{ trans('general.add') }}
        </button>
    </div>
</div>
