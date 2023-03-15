<div
        wire:ignore
        x-data
        x-init="
        () => {
            var pond = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
            pond.setOptions({
                labelIdle: '{{ trans('general.attachments_zone') }}',
                labelInvalidField: 'Archivo inválido',
                labelFileLoading: 'Cargando',
                labelFileProcessing: 'Subiendo',
                labelFileProcessingComplete: 'Carga completa',
                labelFileProcessingAborted: 'Carga cancelada',
                labelFileProcessingError: 'Error durante la carga',
                labelTapToCancel: ' ',
                labelTapToRetry: 'Click para reintentar',
                labelTapToUndo: 'Click para eliminar',
                labelButtonRemoveItem: 'Eliminar',
                labelButtonAbortItemProcessing: 'Cancelar',
                labelButtonProcessItem: 'Cargar',
                allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
                credits: false,
                server: {
                    process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        @this.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress)
                    },
                    revert: (filename, load) => {
                        @this.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
                    },
                },
                allowRevert: {{ $attributes->has('allowRevert') ? 'true' : 'false' }},
                allowRemove: {{ $attributes->has('allowRemove') ? 'true' : 'false' }},
                allowImagePreview: {{ $attributes->has('allowImagePreview') ? 'true' : 'false' }},
                imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
                allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
                acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
                allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
                maxFileSize: {!! $attributes->has('maxFileSize') ? "'".$attributes->get('maxFileSize')."'" : 'null' !!}
                });

                this.addEventListener('pondReset', e => {
                    setTimeout(function(){ pond.removeFiles(); }, 1000);
                });
                this.addEventListener('fileReset', e => {
                    pond.removeFiles();
                });
            };"
>
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" />
</div>

