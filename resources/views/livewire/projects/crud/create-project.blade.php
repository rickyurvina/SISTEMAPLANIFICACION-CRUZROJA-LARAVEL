<div
        x-data="{
                show: @entangle('show'),
                type: @entangle('type')
            }"
        x-init="$watch('show', value => {
            if (value) {
                $('#create-project-modal').modal('show')
            } else {
                $('#create-project-modal').modal('hide');
            }
        })"
        x-on:keydown.escape.window="show = false"
        x-on:close.stop="show = false"
>
    @can('project-crud-project')
    <button class="btn btn-success"
            x-on:click="show = true">{{ trans('general.create') . ' ' . trans_choice('general.project', 1) }}</button>
    @endcan
    <div class="modal fade" id="create-project-modal"
         data-backdrop="static" data-keyboard="false"
         tabindex="-1" role="dialog" style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary-600">
                    <h3 class="modal-title">Crear Proyecto</h3>
                    <button type="button" class="close" aria-label="Close" x-on:click="show = false">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="w-50 mx-auto">
                        <div class="form-group">
                            <label class="form-label required" for="project-name">{{ trans('general.name') }}</label>
                            <input type="text" id="project-name" class="form-control @error('name') is-invalid @enderror" wire:model.lazy="name">
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        </div>
                        <label class="form-label required" for="project-name">Tipo de Proyecto</label>

                        @foreach($projectTypes as $key => $value)
                            <div class="btn-select rounded-mid border-dashed d-flex p-3 mb-3 cursor-pointer"
                                 x-bind:class="{ 'active': type === '{{ $key }}' }" x-on:click="type = '{{ $key }}'">
                                <div class="d-flex">
                                    <span class="ml-2">
                                        <span class="fs-xl fw-700 color-fusion-700 mb-1 d-block">{{ $value['title'] }}</span>
                                    </span>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button x-on:click="show = false" type="button" class="btn btn-outline-secondary waves-effect waves-themed">
                        {{ trans('general.cancel') }}
                    </button>
                    <button type="button" class="btn btn-primary waves-effect waves-themed" x-on:click="$wire.store()">
                        {{trans('general.save')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
