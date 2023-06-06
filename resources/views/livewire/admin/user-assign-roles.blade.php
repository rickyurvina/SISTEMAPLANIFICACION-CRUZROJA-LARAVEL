<div wire:ignore.self class="modal fade" id="user_assign_roles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div wire:ignore class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{ trans('general.edit') }}</h5>
                <button wire:click="resetForm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                @if($user)
                    <div class="row">
                        <div class="form-group col-12">
                            <label class="form-label">{{ trans_choice('general.roles', 0) }}</label>
                            @foreach($roles as $rol)
                                <div>
                                    <input wire:model.defer="userRolesIds"
                                           id="{{ 'roles' . $loop->index }}" type="checkbox"
                                           value="{{ $rol['id'] }}"/>
                                    <label for="{{ 'roles' . $loop->index }}">{{ $rol['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" wire:click="resetForm" data-dismiss="modal" aria-label="Close"><i
                            class="fas fa-times"></i> {{ trans('general.cancel') }}</button>
                <button class="btn btn-primary" wire:click="update">
                    <i class="fas fa-save pr-2"></i> {{ trans('general.save') }}
                </button>
            </div>
        </div>
    </div>
</div>