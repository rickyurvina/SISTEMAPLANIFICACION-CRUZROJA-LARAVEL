<div class="d-flex flex-wrap w-100">
    <div class="d-flex flex-column p-2 w-15">
        <x-label-detail>Documento</x-label-detail>
        <x-content-detail> {{ $transaction->type }} {{$transaction->number}}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-15">
        <x-label-detail>{{trans('general.created_at')}}</x-label-detail>
        <x-content-detail> {{ $transaction->created_at->diffForHumans() }}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-15">
        <x-label-detail>{{trans('general.updated_at')}}</x-label-detail>
        <x-content-detail> {{ $transaction->updated_at->diffForHumans() }}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-15">
        <x-label-detail>Estado</x-label-detail>
        <x-content-detail>
                                <span class="badge {{ $transaction->status->color() }}">
                                            {{ $transaction->status->label() }}
                                </span>
        </x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-20">
        <x-label-detail>{{trans('general.approved_by')}}</x-label-detail>
        <x-content-detail> {{ $transaction->approved_by ?  $transaction->approver->getFullName() : ''}}</x-content-detail>
    </div>
    <div class="d-flex flex-column p-2 w-20">
        <x-label-detail>{{trans('general.date_approved')}}</x-label-detail>
        <x-content-detail> {{ $transaction->approved_date ?  $transaction->approved_date->format('F j, Y, g:i a')  : ''}}</x-content-detail>

    </div>
</div>
<div class="d-flex flex-wrap w-100">
    <div class="d-flex flex-column p-2 w-20">
        <x-label-detail>{{trans('general.description')}}</x-label-detail>
        <x-content-detail> {{ $transaction->description }}</x-content-detail>
    </div>
</div>