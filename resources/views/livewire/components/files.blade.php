<div>
    <div
            x-data="{ isUploading: false, progress: 0 }"
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress" x-cloak
    >

        <x-label-section>{{ trans('general.attachments_files') }}
            @if($limit!=1)
                <x-slot name="actions">
                    <button class="btn btn-outline-default btn-sm border-0" x-on:click.prevent="$refs.input.click()">
                        <i class="fas fa-plus fw-500 fs-2x"></i>
                    </button>
                </x-slot>
            @endif
        </x-label-section>

        @if(count($model->media))
            <div class="table-responsive">
                <table class="table table-light table-hover">
                    <thead>
                    <tr>
                        <th class="w-60"><a href="#">{{ trans('general.name') }}</a></th>
                        <th class="w-15"><a href="#">{{ trans('general.size') }}</a></th>
                        <th class="w-20"><a href="#">{{ trans('general.date') }}</a></th>
                        <th class="w-10"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($model->media as $file)
                        <tr class="tr-hover" wire:loading.class.delay="opacity-50">
                            <td class="px-2 py-1">{{ $file->filename }}</td>
                            <td class="px-2 py-1">{{ $file->readableSize() }}</td>
                            <td class="px-2 py-1">{{ $file->created_at }}</td>
                            <td class="px-2 py-1 text-center">
                                <div class="frame-wrap">
                                    <div class="d-flex justify-content-start">
                                        <a href="#"
                                           data-placement="top"
                                           title="{{trans('general.download')}}">
                                              <span class="p-2 cursor-pointer" wire:click="download({{ $file->id }})">
                                                <i class="fas fa-cloud-download" style="color: #2582fd;"></i>
                                            </span>
                                        </a>
                                        <a href="#"
                                           data-placement="top"
                                           title="{{trans('general.delete')}}">
                                            <span class="p-2 cursor-pointer"
                                                  wire:click="$emit('fileDelete', '{{ $file->id }}')">
                                                    <i class="fas fa-trash color-danger-600"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer-pagination text-muted py-2">

            </div>
        @else
            <x-empty-content>
                <x-slot name="img">
                    <i class="fas fa-cloud-upload-alt" style="color: #2582fd;"></i>
                </x-slot>
                <x-slot name="title">
                    {{ trans('general.files') }}
                </x-slot>
                <x-slot name="info">
                    {{ trans('messages.info.empty_attachment') }}
                </x-slot>

                <div class="d-flex flex-column">
                    <a href="#" x-on:click.prevent="$refs.input.click()"><i class="fas fa-paperclip"></i> {{ trans('general.add_attachments') }}</a>
                    <!-- Progress Bar -->
                    <div x-show="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>
            </x-empty-content>
    @endif
    <!-- File Input -->
        <input type="file" wire:model="files" style="display: none" x-ref="input" @if($accept) accept=".{{$accept}}" @endif id="fileInput">
    </div>
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
                @this.call('deleteFile', id);
                }
            });
        });
        })
    </script>
@endpush
