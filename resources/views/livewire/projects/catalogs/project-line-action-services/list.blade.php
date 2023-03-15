<div class="form-group">
    <label for="project_line_action_id">
        {{ trans_choice('project.line_action_services',2) }}
    </label>
    <hr/>
    <div class="form-row mb-3">
        <div class="col font-weight-bold">
            {{ __('general.code') }}
        </div>
        <div class="col font-weight-bold">
            {{ __('general.name') }}
        </div>
        <div class="col font-weight-bold"></div>
    </div>
    @foreach($services as $service)
        <div class="form-row my-2">
            <div class="col-3">
                <p class="form-control text-truncate">{{$service->code}}</p>
            </div>
            <div class="col-8">
                <p class="form-control text-truncate">{{$service->name}}</p>
            </div>
            <div class="col-1 text-center">
                <x-delete-link-livewire id="{{ $service->id }}"
                                        dismiss="none"
                                        class="deleteService px-0"/>
            </div>
        </div>

        @if($loop->last)
            <script>
                document.getElementsByClassName('deleteService').forEach(t => {
                    t.addEventListener('click', (e) => {
                        e.preventDefault();
                        Swal.fire({
                            title: '{{ trans('messages.warning.sure') }}',
                            text: '{{ trans('messages.warning.delete') }}',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'var(--danger)',
                            confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                            cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
                        }).then((result) => {
                            if (result.value) {
                                window.livewire.emit('deleteService', t.getAttribute('data-model'))
                            }
                        });

                    })
                });
            </script>
        @endif
    @endforeach
    <div class="form-row my-2">
        <div class="col-3">
            <input type="text"
                   wire:model.defer="code"
                   placeholder="{{ __('general.code') }}"
                   class="form-control @error('code') is-invalid @enderror"/>
            @error('code') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="col-8">
            <input type="text"
                   wire:model.defer="name"
                   placeholder="{{ __('general.name') }}"
                   class="form-control @error('name') is-invalid @enderror"/>
            @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="col-1 text-center">
            <button type="button" wire:click="store" class="btn btn-link px-0">
                <i class="fas fa-plus mr-1 text-success"></i>
            </button>
        </div>
    </div>
</div>