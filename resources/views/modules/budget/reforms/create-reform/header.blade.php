<div class="d-flex flex-wrap w-100">
    <div class="d-flex flex-column p-2 w-15">
        <x-label-detail>Documento</x-label-detail>
        <x-content-detail> {{ $transaction->type }} {{$transaction->number}}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-15" wire:ignore>
        <x-label-detail>Tipo de Reforma</x-label-detail>
        <select class="form-control" id="select2-types-reforms">
            @foreach(\App\Models\Budget\Transaction::REFORMS_TYPES  as $index => $item)
                <option value="{{$item}}">{{ $item }}</option>
            @endforeach
        </select>
    </div>
    <div class="d-flex flex-column p-2 w-15">
        <x-label-detail>Fecha de Aprobación</x-label-detail>
        <x-content-detail> {{ $transaction->approved_date ?? 'Sin Aprobacion' }}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-15">
        <x-label-detail>Fecha Creación Reforma</x-label-detail>
        <x-content-detail> {{ $transaction->created_at }}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-10">
        <x-label-detail>Estado</x-label-detail>
        <x-content-detail>
                <span class="badge {{ $transaction->status->color() }}">
                            {{ $transaction->status->label() }}
                </span>
        </x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-25">
        <x-label-detail>{{trans('general.description')}}</x-label-detail>
        <livewire:components.input-inline-edit :modelId="$transaction->id"
                                               class="App\Models\Budget\Transaction"
                                               field="description" type="textarea"
                                               defaultValue="{{$transaction->description ?? ''}}"
                                               :key="time().$transaction->id"/>
    </div>
</div>
