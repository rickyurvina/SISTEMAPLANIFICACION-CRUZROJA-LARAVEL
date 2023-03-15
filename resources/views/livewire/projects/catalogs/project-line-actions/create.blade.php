<!-- Modal -->
<div wire:ignore.self  class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('general.create') }} {{ trans_choice('project.line_actions', 1) }}
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
                    <div class="form-group">
                        <label for="description">{{ __('general.description') }}</label>
                        <input type="text"
                               class="form-control @error('description') is-invalid @enderror"
                               id="name"
                               wire:model.defer="description" />
                        @error('description') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="plan_detail_id" class="form-label required">
                            {{ trans_choice('poa.program',1) }}
                        </label>
                        <select id="plan_detail_id"
                                name="plan_detail_id"
                                class="form-control @error('plan_detail_id') is-invalid @enderror"
                                wire:model.defer="plan_detail_id">
                            <option>--</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                        @error('plan_detail_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="justify-content-center">
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            <a class="btn btn-outline-secondary mr-1" data-dismiss="modal">
                                <i class="fas fa-times"></i> {{ trans('general.cancel') }}
                            </a>
                            <button wire:click.prevent="store()" class="btn btn-primary">
                                <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
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
        $('#createModal').on('hide.bs.modal', function (e) {
            Livewire.emit('cancel');
        });
        window.livewire.on('projectLineActionStore', () => {
            $('#createModal').modal('hide');
        })
    </script>
@endpush