<div class="content-wrapper">
    <div x-data="{
                 isEditing: false,
                 value: @entangle('value').defer,
                 newValue: @entangle('newValue').defer,
                 focus: function() {
                     setTimeout(() => {
                        $refs.textInput.focus();
                     }, 50);
                 }
             }" x-cloak class="child-wrapper">
        <div class="content-read" x-show="!isEditing">
            <div class="content-read-view" x-on:click="isEditing = true; $nextTick(() => focus())">
                <span class="mb-0 truncate" x-text="value"></span>
            </div>
        </div>
        <div class="content-read-active" x-show=isEditing>
            <div class="w-100">
                <input
                        class="w-100 border-0 fw-400"
                        type="{{$type}}"
                        x-ref="textInput"
                        x-model="newValue"
                        wire:model.defer="newValue"
                        x-on:keydown.enter="isEditing = false; value = newValue; $wire.save()"
                        x-on:keydown.escape="isEditing = false; newValue = value"
                        x-on:click.outside="isEditing = false; value = newValue; $wire.save()"
                >
            </div>
        </div>
        @if($errors->first('fieldValidate') )
            <div class="d-flex mt-2 ml-2">
                <div class="alert alert-danger align-center" role="alert" id="div_percentage_of_control">
                    {{ $errors->first('fieldValidate') }}
                </div>
            </div>
        @endif
    </div>
</div>