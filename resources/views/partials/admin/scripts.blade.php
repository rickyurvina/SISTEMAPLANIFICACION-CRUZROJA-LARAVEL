<!-- Vendor -->
<script src="{{ asset_cdn("$asset_template/js/vendors.bundle.js") }}"></script>
<script src="{{ asset_cdn("$asset_template/js/app.bundle.js") }}"></script>
<script src="{{ asset_cdn("$asset_template/js/notifications/sweetalert2/sweetalert2.bundle.js") }}"></script>
<script src="{{ asset_cdn("$asset_template/js/formplugins/select2/select2.bundle.js") }}"></script>
<script src="{{ asset_cdn("$asset_template/js/formplugins/ion-rangeslider/ion-rangeslider.js") }}"></script>
<script src="{{ asset_cdn("$asset_template/js/formplugins/easypiechart/easypiechart.bundle.js") }}"></script>
<script src="{{ asset_cdn("$asset_template/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js") }}"></script>
<script src="{{ asset_cdn("/vendor/quill/quill.min.js") }}"></script>
<script src="{{ asset_cdn("$asset_template/js/formplugins/inputmask/jquery.inputmask.js") }}"></script>

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/kelly.js"></script>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script>
    'use strict';

    var classHolder = document.getElementsByTagName("BODY")[0],
        /**
         * Load from localstorage
         **/
        themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
        themeURL = themeSettings.themeURL || '',
        themeOptions = themeSettings.themeOptions || '';

    myapp_config.debugState = false;
</script>

@livewireScripts

<script src="https://unpkg.com/alpinejs@3.1.1/dist/cdn.min.js" defer></script>

<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script>
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.registerPlugin(FilePondPluginFileValidateSize);
    FilePond.registerPlugin(FilePondPluginImagePreview);
</script>
<script>
    $(document).ready(function() {
        // ...// Enable Bootstrap tooltips on page load
        $('[data-toggle="tooltip"]').tooltip();

        // Ensure Livewire updates re-instantiate tooltipsif (typeof window.Livewire !== 'undefined') {
        window.Livewire.hook('message.processed', (message, component) => {
            $('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
            $('[data-toggle="popover"]').popover();
        });

    });$(document).ready(function() {
        // Ensure Livewire updates re-instantiate tooltips
        if (typeof window.Livewire !== 'undefined') {
            window.Livewire.hook('message.processed', (message, component) => {
                $('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
                $('[data-toggle="popover"]').popover();
            });
        }
    });
</script>

@stack('vendor_js')


<!-- Core -->
<script src="{{ asset_cdn("/js/app.js") }}"></script>

@stack('page_script')
