<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    @include('partials.admin.head')

    <body class="mod-bg-1 header-function-fixed mod-clean-page-bg nav-function-top nav-function-fixed">

        <div class="page-wrapper">

            <div class="page-inner">

                <div class="page-content-wrapper">

                    <main id="js-page-content" role="main" class="page-content">

                        @yield('content')

                    </main>

                    <!-- this overlay is activated only when mobile menu is triggered -->
                    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>

                    @include('partials.admin.colors')

                </div>

            </div>

        </div>


        @include('partials.admin.scripts')

    </body>

</html>
