<div class="card border ">
    <div class="d-flex flex-wrap m-2">
        <div class="d-flex flex-wrap w-100">
            <div class="d-flex w-100">
                <div class="pr-2 d-flex flex-wrap w-100">
                    <div class="d-flex position-relative" style="width: 90%">
                        <i class="spinner-border spinner-border-sm position-absolute pos-left mx-3" style="margin-top: 0.75rem" wire:target="search" wire:loading></i>
                        <i class="fal fa-search position-absolute pos-left fs-lg mx-3" style="margin-top: 0.75rem" wire:loading.remove></i>
                        <input type="text" wire:model.debounce.300ms="search" class="form-control bg-subtlelight pl-6"
                               placeholder="Buscar...">
                    </div>
                </div>
                @if(count($selectDepartmentsId) > 0 || $search != '')
                    <div class="d-flex w-15">
                        <a href="javascript:void(0);" class="btn btn-outline-default ml-2" wire:click="cleanFilters()">{{ trans('common.clean_filters') }}</a>
                    </div>
                @endif
            </div>

        </div>
        <div class="d-flex flex-wrap w-100">
            <div class="d-flex w-100 align-items-center mt-4">
                <x-label-section>Listado de Gerencias</x-label-section>
            </div>
            @foreach($departments as $index => $item)
                <div class="card border w-25 mr-4" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->name}}</h5>
                        <p class="card-text">{{$item->description}}</p>
                        <a href="{{ route('process.showProcess',$item->id) }}" class="btn btn-primary waves-effect waves-themed">Ver Procesos ({{$item->process->count()}})</a>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                        <span class="mr-2 ml-2">
                                @if (is_object($item->user->picture))
                                <img src="{{ Storage::url($item->user->picture->id) }}" class="rounded-circle width-2" alt="{{ $item->user->name }}">
                            @else
                                <img src="{{ asset_cdn("img/user.svg") }}" class="rounded-circle width-2" alt="{{ $item->user->name }}">
                            @endif
                            </span>
                            {{$item->user->getFullName()}}
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
    @push('page_script')
        <script>
            Livewire.on('toggleCreateProcess', () => $('#create-process-modal').modal('toggle'));
            Livewire.on('toggleUpdateProcess', () => $('#update-process-modal').modal('toggle'));
            $('#update-process-modal').on('show.bs.modal', function (e) {
                //get level ID & plan registered template detail ID
                let id = $(e.relatedTarget).data('item-id');
                //Livewire event trigger
                Livewire.emit('openEditProcess', id);
            });
        </script>
        <script>
            function deleteModel(id) {
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
                    @this.call('delete', id);
                    }
                });
            }
        </script>
@endpush