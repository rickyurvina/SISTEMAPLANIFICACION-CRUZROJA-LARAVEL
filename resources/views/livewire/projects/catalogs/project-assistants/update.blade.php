<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('general.update') }} {{ trans_choice('project.assistants', 1) }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="code" class="form-label required">{{ __('general.code') }}</label>
                        <input type="text"
                               class="form-control @error('code') is-invalid @enderror"
                               id="code"
                               wire:model.defer="code" />
                        @error('code') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label required">{{ __('general.name') }}</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               wire:model.defer="name" />
                        @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="justify-content-center">
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            <a class="btn btn-outline-secondary mr-1" wire:click.prevent="cancel()" data-dismiss="modal">
                                <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                            </a>
                            <button type="button" wire:click.prevent="update()" id='update' class="btn btn-primary">
                                {{__('general.save')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_script')
<script>
    $('#updateModal').on('hide.bs.modal', function (e) {
        Livewire.emit('cancel');
    });
    window.livewire.on('projectAssistantStore', () => {
        $('#updateModal').modal('hide');
    })
</script>
@endpush


