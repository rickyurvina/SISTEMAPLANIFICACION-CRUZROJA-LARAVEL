<div>
    @can('manage-files-project')
        <div class="container-fluid" wire:ignore.self>
            <div class="d-flex align-items-center">
                <span class="fs-2x w-40px"><i class="fal fa-paperclip"></i></span>
                <x-label-section>{{trans('general.attachments_files')}}</x-label-section>
            </div>
            <div class="row">
                <div class="form-group col-12 pl-6 pt-4">
                    <x-fileupload
                            wire:model.defer="file"
                            allowRevert
                            allowRemove
                            allowFileSizeValidation
                            maxFileSize="4mb"></x-fileupload>
                    @error('file')
                    <div class="alert alert-danger fade show" role="alert">
                        {{__('general.file_required')}}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="row ml-2">
                <div class="form-group  col-10 required">
                    <label class="form-label" for="observations">{{ trans('general.observations') }}</label>
                    <textarea wire:model.defer="observation" rows="1" id="observations"
                              class="form-control bg-transparent @error($observation) is-invalid @enderror"></textarea>
                    <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('observation',':message') }} </div>
                </div>
                <div class="form-group col-2 pt-4">
                    <button class="btn btn-success btn-sm mb-2 mr-2" wire:click="addFile">
                        <i class="fas fa-plus mr-1"></i> {{ trans('general.add') }}
                    </button>
                </div>
            </div>
        </div>
    @endcan
    @can('manage-files-projects'||'view-files-project')
        <div class="panel-content">
            <div class="accordion accordion-clean" id="js_demo_accordion-1">
                @foreach($filesProject as $index => $file_s)
                    @if(count($file_s)>0)
                        <div class="card">
                            <div class="card-header">
                                <a href="javascript:void(0);" class="card-title" data-toggle="collapse"
                                   data-target="#js_demo_accordion-1{{$index}}"
                                   aria-expanded="false">
                                                            <span class="mr-2">
                                                                <span class="collapsed-reveal">
                                                                    <i class="fal fa-minus fs-xl"></i>
                                                                </span>
                                                                <span class="collapsed-hidden">
                                                                    <i class="fal fa-plus fs-xl"></i>
                                                                </span>
                                                            </span>
                                    {{$months_list[$index]}}
                                </a>
                            </div>
                            <div id="js_demo_accordion-1{{$index}}" class="collapse" data-parent="#js_demo_accordion-1">
                                <div class="card-body">
                                    <table class="table m-0">
                                        <thead>
                                        <tr>
                                            <th>{{ __('general.file_name') }}</th>
                                            <th>{{ __('general.observations') }}</th>
                                            <th>{{trans('general.user')}}</th>
                                            <th>{{ __('general.date') }}</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($file_s as $index => $file)
                                            <tr>
                                                <td>
                                                    <a href="#"
                                                       wire:click="download({{ $file['id'] }})">{{ $file['name'] }}
                                                    </a>
                                                </td>
                                                <td>{{ $file['observation'] }}</td>
                                                <td>{{ \App\Models\Auth\User::find( $file['user_id'] )->name }}</td>
                                                <td>{{ $file['date'] }}</td>
                                                <td class="text-center">
                                                    <button class="border-0 bg-transparent"
                                                            wire:click="$emit('fileDelete', '{{ $file['id']}}')"
                                                            data-toggle="tooltip"
                                                            data-placement="top" title="Eliminar"
                                                            data-original-title="Eliminar"><i
                                                                class="fas fa-trash mr-1 text-danger"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endcan
</div>
@push('page_script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

        @this.on('fileDelete', id => {
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
                @this.call('deleteMedia', id);
                }
            });
        });
        })
    </script>
@endpush