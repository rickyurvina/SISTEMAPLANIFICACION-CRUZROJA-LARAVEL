@push('page_script')
    <script>
        window.addEventListener('alert', event => {
            Toast.fire({
                icon: event.detail.icon,
                title: event.detail.title,
            })
        });
    </script>
@endpush