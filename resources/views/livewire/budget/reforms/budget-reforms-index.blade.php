<div>
    <div class="d-flex flex-wrap w-75">
        <div class="d-flex flex-column p-2 w-25" wire:ignore>
            <x-label-detail>Estado</x-label-detail>
            <select class="form-control" id="select2-states">
                <option value="{{ \App\States\Transaction\Draft::label() }}">{{ \App\States\Transaction\Draft::label() }}</option>
                <option value="{{ \App\States\Transaction\Approved::label() }}">{{ \App\States\Transaction\Approved::label() }}</option>
                <option value="{{ \App\States\Transaction\Digited::label() }}">{{ \App\States\Transaction\Digited::label() }}</option>
                <option value="{{ \App\States\Transaction\Balanced::label() }}">{{ \App\States\Transaction\Balanced::label() }}</option>
            </select>
        </div>
        <div class="d-flex flex-column p-2  w-25" wire:ignore>
            <x-label-detail>Tipo de Reforma</x-label-detail>
            <select class="form-control" id="select2-reform">
                @foreach(\App\Models\Budget\Transaction::REFORMS_TYPES  as $index => $item)
                    <option value="{{$item}}">{{ $item }}</option>
                @endforeach
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
                           placeholder="{{ trans('general.filter') . ' ' . trans_choice('general.reforms', 1) }} ..."
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
                    <th class="w-auto table-th">{{__('general.state')}}</th>
                    <th class="w-auto table-th">{{__('general.reform_type')}}</th>
                    <th class="w-auto table-th">{{__('general.description')}}</th>
                    <th class="w-auto table-th">{{__('general.date')}}</th>
                    <th class="w-auto table-th">{{__('budget.incomes')}}</th>
                    <th class="w-auto table-th">{{__('budget.expense')}}</th>
                    <th class="w-10 table-th"><a href="#">{{ trans('general.actions') }} </a></th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions->take($countRegisterSelect) as $item)
                    <tr>
                        <td class="table-th">{{$item->type}}-{{$item->number}}</td>
                        <td class="table-th">
                            <span class="badge {{ $item->status->color() }}">
                                            {{ $item->status->label() }}
                                </span>
                        </td>
                        @if($item->reform_type)
                            <td class="table-th">
                            <span class="badge {{ \App\Models\Budget\Transaction::REFORMS_TYPES_BG[$item->reform_type]}}">
                                                {{$item->reform_type}}
                                </span>
                            </td>
                        @else
                            <td class=" fs-1x fw-500">
                                <i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                            </td>
                        @endif
                        @if($item->description)
                            <td class="table-th">{{$item->description}}</td>
                        @else
                            <td class=" fs-1x fw-500">
                                <i class="fal fa-times-circle fa-2x" style="color: #D52B1E"></i>
                            </td>
                        @endif
                        <td class="table-th">{{$item->created_at->diffForHumans()}}</td>
                        <td class="table-th">{{$item->debits}}</td>
                        <td class="table-th">{{$item->credits}}</td>
                        <td class=" table-th">
                            <div class="d-flex flex-wrap">
                                <div class="p-2 mr-2">
                                    <a href="#" data-toggle="modal" data-transaction-id="{{ $item->id }}"
                                       data-target="#show-reform">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </div>
                                @if((!$item->status instanceof \App\States\Transaction\Approved))
                                    <div class="p-2">
                                        <a href="{{route('budgets.editReform',$item)}}" class="mr-2"
                                           data-toggle="tooltip"
                                           data-placement="top" title=""
                                           data-original-title="{{ trans('general.edit') }}">
                                            <i class="fas fa-pencil-alt text-info"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :items="$transactions"/>
    </div>
    <div wire:ignore>
        <livewire:budget.reforms.show-reform/>
    </div>

</div>

@push('page_script')
    <script>
        $(document).ready(function () {
            $('#select2-states').select2({
                placeholder: "{{ trans('general.select').' '.trans_choice('general.state',2) }}"
            }).on('change', function (e) {
            @this.set('stateSelect', $(this).val());
            });

            $('#select2-reform').select2({
                placeholder: "{{ trans('general.select').' '.trans_choice('general.state',2) }}"
            }).on('change', function (e) {
            @this.set('reformSelect', $(this).val());
            });

            $('#select2-registers').select2({
                placeholder: "{{ trans('general.select').' '.trans_choice('general.state',2) }}"
            }).on('change', function (e) {
            @this.set('countRegisterSelect', $(this).val());
            });
        });
        $('#show-reform').on('show.bs.modal', function (e) {
            //get level ID & plan registered template detail ID
            let transactionId = $(e.relatedTarget).data('transaction-id');
            //Livewire event trigger
            Livewire.emit('loadTransaction', transactionId);
        });
    </script>
@endpush