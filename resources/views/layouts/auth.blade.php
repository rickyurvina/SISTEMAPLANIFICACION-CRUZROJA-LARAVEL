<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    @include('partials.auth.head')

    <body style="background: url({{ asset_cdn("$asset_template/img/svg/pattern-1.svg") }}) no-repeat center bottom fixed;background-size: cover;">

        @yield('content')

        @include('partials.auth.colors')

        @include('partials.auth.scripts')
    </body>

</html>
