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
        <div class="content-read" x-show="!isEditing" x-on:click="isEditing = true; $nextTick(() => focus())">
            <div class="content-read-view">
                @if($title)
                    <h1 class="mb-0 truncate" x-text="value"></h1>
                @else
                    <span class="mb-0 truncate" x-text="value"></span>
                    @if($value=="")
                        <span class="mb-0 truncate">Ingrese el texto..</span>
                    @endif
                @endif
            </div>
        </div>

        <div class="content-read-active" x-show=isEditing>
            <div class="w-100">
                <input @if($title) style="line-height: 1.3; font-size: 1.5rem" @endif
                class="w-100 border-0 fw-400"
                       type="text"
                       x-ref="textInput"
                       x-model="newValue"
                       wire:model.lazy="newValue"
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