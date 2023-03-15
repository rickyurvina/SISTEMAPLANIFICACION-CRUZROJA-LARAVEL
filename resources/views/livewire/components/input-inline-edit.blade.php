<div class="w-100">
    <div x-data="{
                 isEditing: false,
                 value: @entangle('value').defer,
                 newValue: @entangle('newValue').defer,
                 focus: function() {
                    setTimeout(() => {
                        $refs.textInput.focus();
                     }, 50);
                 }
                    }" x-cloak>
        <div x-show="!isEditing" class="w-100 fs-{{ $size }}" wire:loading.class="bg-warning-100" wire:target="newValue">
            <div class="cursor-text text-editable align-items-center "
                 @if($borders) style="border: none" @else  style="background-clip: padding-box;
                 border: 1px solid #E5E5E5; border-radius: 4px; height: calc(1.47em + 1rem + 2px); padding: 0.5rem 0.875rem" @endif

                 @if(strlen($value) > 30)
                 data-toggle="tooltip" data-placement="top" data-original-title="{{ $value }}"
                 @endif
                 x-on:click="isEditing = true; $nextTick(() => focus())">

                @if(strlen($value) > 30)
                    <span class="text-component"> {{$value}}</span>
                @elseif(!$value)
                    <small style="color: rgb(94, 108, 132); font-size: 12px">{{__('general.add_text')}}</small>
                @else
                    <span x-text="value" class="text-component"></span>
                @endif

            </div>
        </div>
        <div x-show=isEditing>
            <div class="d-flex align-items-center">
                @if($type == 'textarea')
                    <textarea
                            type="text"
                            class="form-control"
                            rows="{{$rows}}"
                            x-ref="textInput"
                            x-model="newValue"
                            wire:model.defer="newValue"
                            x-on:keydown.escape="isEditing = false; newValue = value"
                            x-on:click.outside="isEditing = false; $wire.save()"
                    ></textarea>
                @else
                    <input
                            type="{{ $type }}"
                            class="text-input fs-{{ $size }}"
                            x-ref="textInput"
                            x-model="newValue"
                            wire:model.lazy="newValue"
                            x-on:keydown.enter="isEditing = false; $wire.save()"
                            x-on:keydown.escape="isEditing = false; newValue = value"
                            x-on:click.outside="isEditing = false; $wire.save()"
                    >
                @endif
            </div>

        </div>
        @if($errors->first('code') )
            <div class="d-flex mt-2 ml-2">
                <div class="alert alert-danger align-center" role="alert" id="div_percentage_of_control">
                    {{ $errors->first('code') }}
                </div>
            </div>
        @endif
        @if($errors->first('fieldValidate') )
            <div class="d-flex mt-2 ml-2">
                <div class="alert alert-danger align-center" role="alert" id="div_percentage_of_control">
                    {{ $errors->first('fieldValidate') }}
                </div>
            </div>
        @endif
    </div>
</div>