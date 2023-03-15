@stack('scripts_start')
    <!-- Core -->
    <script src="{{asset_cdn("$asset_template/js/vendors.bundle.js")}}"></script>
    <script src="{{asset_cdn("$asset_template/js/app.bundle.js")}}"></script>

    @stack('body_js')

    @stack('body_scripts')

@stack('scripts_end')