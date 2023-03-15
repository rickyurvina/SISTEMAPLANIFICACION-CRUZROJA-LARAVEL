<div class="mt-3">
    <label for="permissions" class="form-label d-block">{{ trans_choice('general.permissions', 2) }}</label>
    @error('permissions')
    <div class="alert border-danger bg-transparent text-danger mb-1" role="alert">
        {{ $errors->first('permissions') }}
    </div>
    @enderror
    <span class="btn btn-outline-primary btn-sm mr-1" wire:click="selectAll()">{{ trans('general.select_all') }}</span>
    <span class="btn btn-outline-primary btn-sm" wire:click="unSelectAll()">{{ trans('general.unselect_all') }}</span>

    <div class="my-3">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
            @foreach($actions as $action)
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 {{ $action == 'read' ? 'active':'' }}" id="tabs-icons-text-1-tab"
                       wire:ignore
                       data-toggle="tab" href="#tab-{{ $action }}"
                       role="tab"
                       aria-controls="tabs-icons-text-1"
                       aria-selected="true">{{ ucwords($action) }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="tab-content">
                @foreach($permissions as $action => $action_permissions)
                    <div class="tab-pane fade show {{ $action == 'read' ? 'active' : '' }}" id="tab-{{ $action }}" role="tabpanel" wire:ignore.self>
                        <span class="btn btn-primary btn-sm" wire:click="select('{{ $action }}')">{{ trans('general.select_all') }}</span>
                        <span class="btn btn-primary btn-sm" wire:click="unSelect('{{ $action }}')">{{ trans('general.unselect_all') }}</span>

                        <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                            <div class="row pt-4">
                                @foreach($action_permissions as $item)
                                    <div class="col-md-4 role-list">
                                        <div class="custom-control custom-checkbox">
                                            <input name="permissions[]" id="permissions-{{ $item['id'] }}" type="checkbox" class="custom-control-input"
                                                   wire:model="selectedPermissions" value="{{ $item['id'] }}">
                                            <label class="custom-control-label" for="permissions-{{ $item['id'] }}">
                                                {{$item['spanish_label'] }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <x-form.footer/>
    </div>
</div>