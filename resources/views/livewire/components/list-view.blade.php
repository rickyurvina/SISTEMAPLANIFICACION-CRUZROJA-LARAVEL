<div class="card border m-auto m-lg-0 w-100" style="width: 18rem;">
    <div class="card-header">
        {{ $title }}
    </div>
    <ul class="list-group list-group-flush">
        @if($elements)
            @foreach($elements as $item)
                <li class="list-group-item p-2 item d-flex justify-content-between align-items-center">
                    {{ $item }}
                    <span wire:click="removeItem('{{ $item }}')" class="cursor-pointer trash"><i class="fas fa-trash text-danger"></i></span>
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
