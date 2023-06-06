<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
        <div class="container-fluid">
            <a class="navbar-brand d-flex flex-row align-items-center" href="#" >
                <div class="border-end border-white border-2 pe-4 me-4 d-none d-sm-block">
                    <img src="{{ asset("/img/logo.png")}}" alt="" width="100" class="d-inline-block align-text-top">
                </div>
                <div class="pe-4 me-4 d-block d-sm-none">
                    <img src="{{ asset("/img/logo.png")}}" alt="" width="100" class="d-inline-block align-text-top">
                </div>
                <img src="{{ asset("/img/logo_cre_white.png")}}" alt="" height="64" class="navbar-brand d-none d-sm-block">
            </a>
            @if ($user = session('user', false))
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end me-3" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2">
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex flex-row align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex flex-column justify-content-end me-3">
                                    <div class="text-end">
                                        {{ $user->name }}
                                    </div>
                                    <div class="text-end">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{route('azure.logout')}}">Salir</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </nav>
</header>
