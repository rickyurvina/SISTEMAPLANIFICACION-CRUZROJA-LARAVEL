@foreach($arrayReformsIncomes as $index => $itemIncome)
    <tr class="" wire:key="{{time().$index}}">
        <th class="w-30 table-th">{{$itemIncome['code']}}</th>
        <th class="w-20 table-th">{{$itemIncome['name']}}</th>
        <th class="w-15 table-th">
            <div x-data="{ isEditing: false,   newValue: @entangle('newValue').defer}" x-cloak>
                <div x-show="!isEditing" class="w-100 fs-2x" wire:loading.class="bg-warning-100">
                    <div class="cursor-text text-editable align-items-center " style="border: none"
                         x-on:click="isEditing = true; $nextTick(() => focus())">
                        <span class="text-component"> {{ money( $itemIncome['debit']*100)}}</span>
                    </div>
                </div>
                <div x-show=isEditing>
                    <div class="d-flex align-items-center">
                        <input
                                type="number"
                                class="text-input fs-2x"
                                value="{{ $itemIncome['debit']}}"
                                x-model="newValue"
                                x-on:keydown.enter="isEditing = false; $wire.editArrayReformIncomes({{$index}}, newValue,'debit')"
                                x-on:keydown.escape="isEditing = false;"
                                x-on:click.outside="isEditing = false; $wire.editArrayReformIncomes({{$index}}, newValue,'debit')"
                        >
                    </div>
                </div>
            </div>
        </th>
        <th class="w-15 table-th">
            <div x-data="{ isEditing: false,   newValue: @entangle('newValue').defer}" x-cloak>
                <div x-show="!isEditing" class="w-100 fs-2x" wire:loading.class="bg-warning-100">
                    <div class="cursor-text text-editable align-items-center " style="border: none"
                         x-on:click="isEditing = true; $nextTick(() => focus())">
                        <span class="text-component"> {{ money( $itemIncome['credit']*100)}}</span>
                    </div>
                </div>
                <div x-show=isEditing>
                    <div class="d-flex align-items-center">
                        <input
                                type="number"
                                class="text-input fs-2x"
                                value="{{ $itemIncome['credit']}}"
                                x-model="newValue"
                                x-on:keydown.enter="isEditing = false; $wire.editArrayReformIncomes({{$index}}, newValue,'credit')"
                                x-on:keydown.escape="isEditing = false;"
                                x-on:click.outside="isEditing = false; $wire.editArrayReformIncomes({{$index}}, newValue,'credit')"
                        >
                    </div>
                </div>
            </div>
        </th>
        <th class="w-10 table-th">
            <div class="frame-wrap">
                <div class="d-flex justify-content-start">
                    <div class="p-2">
                        <a href="javascript:void(0);" class="mr-2" wire:click="deleteItemIncome({{$index}})"
                           data-toggle="tooltip"
                           data-placement="top" title=""
                           data-original-title="{{ trans('general.delete') }}">
                            <i class="fas fa-trash text-danger"></i>
                        </a>
                    </div>
                </div>
            </div>
        </th>
    </tr>
@endforeach