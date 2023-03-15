<script>
    Toast.fire({
        icon: "{{ $message['level'] }}",
        title: "{!! $message['message'] !!}"
    })
</script>
@push('page_script')
    <script>
        Toast.fire({
            icon: "{{ $message['level'] }}",
            title: "{!! $message['message'] !!}"
        })
    </script>
@endpush