@extends('layouts.auth')

@section('title', trans('auth.login'))

@section('content')

    <div class="page-wrapper auth">
        <div class="page-inner bg-brand-gradient">
            <div class="page-content-wrapper bg-transparent m-0">
                <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                    <div class="d-flex align-items-center container p-0">
                        <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                                <img src="{{ asset_cdn("/img/logo.png") }}" aria-roledescription="logo">
                                <span class="page-logo-text mr-1">{{ trans('footer.software') }} </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-1" style="background: url({{ asset_cdn("$asset_template/img/svg/pattern-1.svg") }}) no-repeat center bottom fixed; background-size: cover;">
                    <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                        <div class="row">
                            <div class="col col-md-6 col-lg-7 hidden-sm-down">
                                <h2 class="fs-xxl fw-500 mt-4 text-white">
                                    {{ trans('footer.software') }}
                                    <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                                        {{ trans('footer.software_description') }}
                                    </small>
                                </h2>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                                <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
                                    {{ trans('auth.login_to') }}
                                </h1>
                                <div class="card p-4 rounded-plus bg-faded">
                                    <form id="js-login" novalidate="" action="{{ route('login') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label" for="email">{{ trans('general.email') }}</label>
                                            <div class="input-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fal fa-user fa-lg"></i>
                                                    </span>
                                                </div>
                                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                                       placeholder="{{ trans('auth.enter_email') }}" name="email" required value="{{ old('email') }}">
                                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="password">{{ trans('general.password') }}</label>
                                            <div class="input-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fal fa-key fa-lg"></i>
                                                    </span>
                                                </div>
                                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                       placeholder="{{ trans('auth.password.current_password') }}" value="" required>
                                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                            </div>
                                        </div>

                                        <div class="form-group text-left">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="remember" id="remember">
                                                <label class="custom-control-label" for="remember"> {{ trans('auth.remember_me') }}</label>
                                            </div>
                                        </div>
                                        <div class="row no-gutters">
                                            <div class="col-lg-12 my-2">
                                                <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-lg">{{ trans('auth.login') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @include('partials.auth.footer')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection