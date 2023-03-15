<div class="w-60">
    <div x-data="{
                        isEditing: false,
                        value: @entangle('value').defer,
                        newValue: @entangle('newValue').defer,
                        selectedValue: @entangle('selectedValue').defer,
                        newSelectedValue: @entangle('newSelectedValue').defer
                        }" x-cloak>
        <div x-show="!isEditing" class="editable-component fs-{{ $size }}" wire:loading.class="bg-warning-100" wire:target="newValue">
            <div class="cursor-text text-editable border-bottom justify-content"
                 style="background-clip: padding-box;
                 border: 1px solid #E5E5E5; border-radius: 4px; height: calc(1.47em + 1rem + 2px); padding: 0.5rem 0.875rem"
                 @if(strlen($value) > 75)
                 data-toggle="tooltip" data-placement="top" data-original-title="{{ $value }}"
                 @endif
                 x-on:click="isEditing = true">
                <span x-text="value" class="text-component"></span>
            </div>
        </div>
        <div x-show=isEditing>
            <div class="d-flex justify-content" style="width: 100% !important;">
                <select class="form-control"
                        x-ref="textInput"
                        x-model="newSelectedValue"
                        wire:model.defer="newSelectedValue"
                        x-on:click.outside="isEditing = false; $wire.save()">
                    @if($selectValues)
                        <option value="">{{ trans_choice('general.form.select.field', 1, ['field' => '']) }}</option>
                        @foreach($selectValues as $item)
                            <option value="{{ $item->id }}">{{ $item->{$selectField} }}</option>
                        @endforeach
                    @endif
                    @if($selectValuesArray)
                        @if($limit)
                            @foreach(array_slice($selectValuesArray,0,$limit) as $index=>$item)
                                <option value="{{$index}}">{{ $item }}</option>
                            @endforeach
                        @else
                            @foreach($selectValuesArray as $index => $item)
                                <option value="{{$index}}">{{ $item }}</option>
                            @endforeach
                        @endif
                    @endif
                </select>
            </div>
        </div>
    </div>
</div>
