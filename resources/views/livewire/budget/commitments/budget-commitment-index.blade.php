<div>
    <div class="d-flex flex-wrap w-75">
        <div class="d-flex flex-column p-2 w-25" wire:ignore>
            <x-label-detail>Estado</x-label-detail>
            <select class="form-control" id="select2-states">
                <option value="{{ \App\States\Transaction\Draft::label() }}">{{ \App\States\Transaction\Draft::label() }}</option>
                <option value="{{ \App\States\Transaction\Approved::label() }}">{{ \App\States\Transaction\Approved::label() }}</option>
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
            <select class="form-control" id="select2-registers">
                <option value="10">10</option>
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
                           placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.commitments', 2) }} ..."
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
    <div class="w-100 pl-2">
        <div class="table-responsive">
            <table class="table table-light table-hover">
                <thead>
                <tr>
                    <th class="w-auto table-th">{{__('general.document')}}</th>
                    <th class="w-auto table-th text-center">Proyecto/Poa</th>
                    <th class="w-auto table-th">{{__('general.activity')}}</th>
                    <th class="w-auto table-th">{{__('general.description')}}</th>
                    <th class="w-auto table-th">{{__('general.date')}}</th>
                    <th class="w-auto table-th">{{__('general.state')}}</th>
                    <th class="w-10 table-th text-center"><a href="#">{{ trans('general.actions') }} </a></th>
                </tr>
                </thead>
                <tbody>
                @foreach($commitments->take($countRegisterSelect) as $item)
                    @if($item->transactions->first()->account->accountable instanceof \App\Models\Poa\PoaActivity)
                        <tr>
                            <td class="table-th">{{$item->type}}-{{$item->number}}</td>
                            <td class="table-th">{{$item->transactions->first()->account->accountable->program->poa->name}}</td>
                            <td class="table-th">{{$item->transactions->first()->account->accountable->name}}</td>
                            @if($item->description)
                                <td class="table-th">{{$item->description}}</td>
                            @else
                                <td class=" fs-1x fw-500">
                                    <i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                </td>
                            @endif
                            <td class="table-th">{{$item->created_at->diffForHumans()}}</td>
                            <td class="table-th">
                            <span class="badge {{ $item->status->color() }}">
                                            {{ $item->status->label() }}
                                </span>
                            </td>
                            <td class="text-center table-th">
                                <div class="frame-wrap">
                                    <div class="d-flex justify-content-center">
                                        <div class="p-2">
                                            <a href="#" data-toggle="modal" data-transaction-id="{{ $item->id }}"
                                               data-target="#show-commitment" class="mr-2 p-2 bg-">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </div>
                                        @if($item->status instanceof \App\States\Transaction\Draft)
                                            <div class="p-2">
                                                <button type="submit" class="" id="btn-override" style="border: 0 !important; background-color: transparent !important;"
                                                        wire:click="$emit('openSwalOverRide', '{{ $item->id }}')">
                                                    <i class="fas fa-stop-circle mr-1 text-danger" data-toggle="tooltip" data-placement="top" title=""
                                                       data-original-title="Anular"></i>
                                                </button>
                                            </div>
                                            <div class="p-2">
                                                <a href="{{route('budget.edit-commitment',['commitment'=>$item,'certification'=>$certification])}}" class="mr-2 p-2"
                                                   data-toggle="tooltip"
                                                   data-placement="top" title=""
                                                   data-original-title="{{ trans('general.edit') }}">
                                                    <i class="fas fa-pencil-alt text-info"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="table-th">{{$item->type}}-{{$item->number}}</td>
                            <td class="table-th">{{$item->transactions->first()->account->accountable->project->name}}</td>
                            <td class="table-th">{{$item->transactions->first()->account->accountable->text}}</td>
                            @if($item->description)
                                <td class="table-th">{{$item->description}}</td>
                            @else
                                <td class=" fs-1x fw-500">
                                    <i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                                </td>
                            @endif
                            <td class="table-th">{{$item->created_at->diffForHumans()}}</td>
                            <td class="table-th">
                                <span class="badge {{ $item->status->color() }}">{{ $item->status->label() }}</span>
                            </td>
                            <td>
                                <div class="frame-wrap">
                                    <div class="d-flex justify-content-start">
                                        <div class="p-2 mr-2">
                                            <a href="#" data-toggle="modal" data-transaction-id="{{ $item->id }}"
                                               data-target="#show-commitment">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </div>
                                        @if(($item->status instanceof \App\States\Transaction\Draft))
                                            <div class="p-2">
                                                <button type="submit" class="" id="btn-override" style="border: 0 !important; background-color: transparent !important;"
                                                        wire:click="$emit('openSwalOverRide', '{{ $item->id }}')">
                                                    <i class="fas fa-stop-circle mr-1 text-danger" data-toggle="tooltip" data-placement="top" title=""
                                                       data-original-title="Anular"></i>
                                                </button>
                                            </div>
                                            <div class="p-2">
                                                <a href="{{route('budget.edit-commitment',['commitment'=>$item,'certification'=>$certification])}}"
                                                   data-toggle="tooltip"
                                                   data-placement="top" title=""
                                                   data-original-title="{{ trans('general.edit') }}">
                                                    <i class="fas fa-pencil-alt text-info"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :items="$commitments"/>
    </div>
    <div wire:ignore>
        <livewire:budget.commitments.show-commitment :certification="$certification"/>
    </div>
</div>

@push('page_script')
    <script>
        Livewire.on('toggleShowCommitment', () => $('#show-commitment').modal('toggle'));

        $(document).ready(function () {
            $('#select2-states').select2({
                placeholder: "{{ trans('general.select').' '.trans_choice('general.state',2) }}"
            }).on('change', function (e) {
                @this.
                set('stateSelect', $(this).val());
            });

            $('#select2-registers').select2({
                placeholder: "{{ trans('general.select').' '.trans_choice('general.state',2) }}"
            }).on('change', function (e) {
                @this.
                set('countRegisterSelect', $(this).val());
            });
        });
        $('#show-commitment').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let transactionId = $(e.relatedTarget).data('transaction-id');
            //Livewire event trigger
            Livewire.emit('loadTransaction', transactionId);
        });

        document.addEventListener('DOMContentLoaded', function () {
            @this.
            on('openSwalOverRide', id => {
                Swal.fire({
                    title: '{{ trans('messages.warning.sure') }}',
                    text: '{{ trans('messages.warning.override') }}',
                    icon: 'danger',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--danger)',
                    confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.override') }}',
                    cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {
                        // calling destroy method to delete
                        @this.
                        call('overrideTransaction', id);
                    }
                });
            });
        })
    </script>
@endpush