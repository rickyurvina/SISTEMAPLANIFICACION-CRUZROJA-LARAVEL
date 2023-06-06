<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-100">
    @include('partials.home.head')
    <body class="d-flex flex-column h-100" style="background: url({{ asset("/img/background-1.png") }}) no-repeat center bottom fixed;background-size: cover;">
        <main>
            @include('partials.home.header')

            @yield('content')
        </main>
        @include('partials.home.footer')
    </body>
</html>
