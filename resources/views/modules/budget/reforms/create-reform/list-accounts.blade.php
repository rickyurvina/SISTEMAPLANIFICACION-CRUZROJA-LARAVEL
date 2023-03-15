<div class="d-flex flex-wrap mt-2 p-2">
    <div class="w-5">
        <label for="countRegisters" class="mt-2">
            Mostrar
        </label>
    </div>
    <div class="w-20" wire:ignore>
        <select class="form-control" id="select2-registers">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <div class="w-5 mr-6">
        <label for="countRegisters2" class="mt-2">
            Registros
        </label>
    </div>
    <div class="w-50">
        <div class="d-flex mb-3">
            <div class="input-group bg-white shadow-inset-f2 w-100 mr-2">
                <input type="text" class="form-control border-right-0 bg-transparent pr-0"
                       placeholder="{{ trans('general.filter') . ' ' . trans_choice('budget.item_code', 1) }} ..."
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
<div class="d-flex flex-wrap mt-2 p-2">
    <div class="w-100 pl-2">
        <div class="table-responsive">
            <table class="table table-light table-hover">
                <thead>
                <tr>
                    <th class="w-10 table-th">{{__('general.type')}}</th>
                    <th class="w-75 table-th">{{__('budget.item_code')}}</th>
                    <th class="w-5 table-th">{{__('budget.balance')}}</th>
                    <th class="w-10 table-th"><a href="#">{{ trans('general.actions') }} </a></th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts->take($countRegisterSelect) as $item)
                    <tr>
                        <td class="table-th">{{\App\Models\Budget\Account::TYPES[$item->type]}}</td>
                        <td class="table-th">{{$item->code}}</td>
                        <td class="table-th">
                            {{$item->balance}}
                        </td>
                        <td>
                            <div class="frame-wrap">
                                <div class="d-flex justify-content-start">
                                    <div class="p-2">
                                        <a href="javascript:void(0);" class="mr-2" wire:click="$set('accountSelected', {{$item->id}})"
                                           data-toggle="tooltip"
                                           data-placement="top" title=""
                                           data-original-title="{{ trans('general.select') }}">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-pagination :items="$accounts"/>
    </div>
</div>