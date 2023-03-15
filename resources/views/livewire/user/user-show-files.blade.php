<div wire:ignore.self class="modal fade in" id="user-show-files" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-info">
                    {{trans('general.personal_files')}} {{trans('general.of')}}  {{$user->getFullName()}}
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; height:450px; ">

                <div class="container-fluid" wire:ignore.self>
                    <div class="row">
                        @if(\Illuminate\Support\Facades\Auth::user()->id==$user->id)
                            <div class="form-group col-6 pl-6 pt-4">
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

                            <div class="form-group col-4">
                                <label class="form-label"
                                       for="observation">{{ trans('general.observations') }}</label>
                                <textarea wire:model.defer="observation" rows="3" id="observation" class="form-control bg-transparent
                                    @error('observation') is-invalid @enderror"></textarea>
                                <div style="color:#fd3995; font-size: 0.6875rem ">{{ $errors->first('observation',':message') }} </div>

                            </div>

                            <div class="form-group col-2 pt-4">
                                <button class="btn btn-primary" wire:click="addFile">
                                    <i class="fas fa-plus pr-2"></i> {{ trans('general.add') }}
                                </button>
                            </div>

                    </div>
                    @endif
                    <div class="d-flex align-items-center">
                        <span class="fs-2x w-40px"><i class="fal fa-paperclip"></i></span>
                        <span class="fs-2x fw-700">{{trans('general.attachments_files')}}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover m-0">
                            <thead class="bg-primary-50">
                            <tr>
                                <th>{{trans('general.name')}}</th>
                                <th>{{trans('general.comments')}}</th>
                                <th>{{trans('general.user')}}</th>
                                <th>{{trans('general.created_at')}}</th>
                                @if(\Illuminate\Support\Facades\Auth::user()->id==$user->id)
                                    <th class="text-center color-primary-500">{{ trans('general.actions') }}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($medias as $media)
                                <tr>
                                    <td>
                                        <a href="#" wire:click="download({{ $media->id }})">{{ $media->filename }}
                                        </a>
                                    </td>
                                    <td>{{ $media->comments }}</td>
                                    <td>{{ \App\Models\Auth\User::find($media->user_id)->name??'' }}</td>
                                    <td>{{ $media->created_at->diffForHumans() }}</td>
                                    @if(\Illuminate\Support\Facades\Auth::user()->id==$user->id)
                                        <td class="text-center">

                                            <button wire:click="$emit('fileDelete', '{{ $media->id }}')"
                                                    data-toggle="tooltip" data-placement="top" title="Eliminar"
                                                    data-original-title="Eliminar"
                                                    style="border: 0 !important; background-color: transparent !important;">
                                                <i class="fas fa-trash mr-1 text-danger"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <x-pagination :items="$medias"/>
                </div>

            </div>
        </div>
    </div>
</div>

@push('page_script')
    <script>

        document.addEventListener('DOMContentLoaded', function () {

        @this.on('fileDelete', id => {
            Swal.fire({
                target: document.getElementById('user-show-files'),
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