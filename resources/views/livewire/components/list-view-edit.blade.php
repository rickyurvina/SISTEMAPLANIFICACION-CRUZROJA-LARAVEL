<div class="card border m-auto m-lg-0" style="width: 18rem;">
    <div class="card-header">
        {{ $title }}
    </div>
    <ul class="list-group list-group-flush">
        @if($elements)
            @foreach($elements as $index => $elementEdited)
                <li class="list-group-item p-2 item d-flex justify-content-between align-items-center" wire:key="{{time().$elementEdited}}">
                    <div x-data="{
                                     isEditingInput: false,
                                  elementEdited: @js($elementEdited),
                                    focus: function() {
                                        setTimeout(() => {
                                            $refs.textInputEditing.focus();
                                         }, 50);
                                     }
                                   }" x-cloak>
                        <div x-show="!isEditingInput" class="w-100 fs-1x" wire:loading.class="bg-warning-100">
                            <div class="cursor-text text-editable align-items-center "
                                 x-on:click="isEditingInput = true; $nextTick(() => focus())">
                                <span class="text-component"> {{$elementEdited}}</span>
                            </div>
                        </div>
                        <div x-show=isEditingInput>
                            <div class="d-flex align-items-center">
                                <input
                                        type="text"
                                        class="text-input fs-1x"
                                        x-ref="textInputEditing"
                                        x-model="elementEdited"
                                        wire:model.defer="elementEdited"
                                        x-on:keydown.enter="isEditingInput = false; $wire.edit({{$index}})"
                                        x-on:click.outside="isEditingInput = false; $wire.edit({{$index}})"
                                >
                            </div>
                        </div>
                    </div>
                    <span wire:click="removeItem('{{ $elementEdited }}')" class="cursor-pointer trash"><i class="fas fa-trash text-danger"></i></span>
                </li>
            @endforeach
        @endif
    </ul>

    <div>
        <div x-data="{
            isAdding: false,
            focus: function() {
                const textInput = this.$refs.textInput;
                //textInput.focus();
            }
        }" x-cloak>
            <div x-show=!isAdding class="mt-1 p-2 cursor-pointer"
                 x-on:click="isAdding = true; $nextTick(() => focus())">
                <span class="fs-md"><i class="fal fa-plus text-success"></i>  Nueva</span>
            </div>
            <input type="text" class="form-control mt-1" x-show=isAdding
                   placeholder="Nueva"
                   x-on:click.away="isAdding = false"
                   x-ref="textInput"
                   x-on:keydown.enter="isAdding = false"
                   x-on:keydown.escape="isAdding = false"
                   wire:model.defer="element"
                   wire:keydown.enter="addElement">
        </div>
    </div>
</div>
