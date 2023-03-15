@props(['action', 'id', 'text' => trans('messages.warning.delete')])

<form action="{{ $action }}" method="post" style="display: contents !important;">
    @csrf
    @method('delete')
    <button type="submit" class="" id="btn-{{ $id }}" style="border: 0 !important; background-color: transparent !important;">
        <i class="fas fa-trash mr-1 text-danger" data-toggle="tooltip" data-placement="top" title=""
           data-original-title="Eliminar"></i>
    </button>
</form>
@push('page_script')
    <script>
        $('#btn-{{ $id }}').on('click', (e) => {
            e.preventDefault();
            let $form = e.currentTarget.form;
            Swal.fire({
                title: '{{ trans('messages.warning.sure') }}',
                text: '{{ $text }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                confirmButtonText: '<i class="fas fa-trash"></i> {{ trans('general.yes') . ', ' . trans('general.delete') }}',
                cancelButtonText: '<i class="fas fa-times"></i> {{ trans('general.no') . ', ' . trans('general.cancel') }}'
            }).then((result) => {
                if (result.value) {
                    $form.submit();
                }
            });
        })
    </script>
@endpush