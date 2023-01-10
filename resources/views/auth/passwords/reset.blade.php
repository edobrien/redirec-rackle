@extends('layouts.signup-app')

@section('content')
<div class="container-fluid signIn bg-signin">
    <div class="row mt-170">
        <div class="col-lg-7 col-md-6 p-28 d-flex justify-content-center">
            <a class="navbar-brand pb-4" href="{{ url('/') }}">
                <img src="../../img/logo-login.png" alt="Rackle">
            </a>
        </div>
        <div class="col-lg-5 col-md-6">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card border-0 bg-transparent">
                        <div class="card-header border-0 bg-transparent px-0">
                            <h4 class="text-white">{{ __('Reset Password') }}</h4>
                        </div>

                        <div class="card-body p-0">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group row">
                                    <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control mb-1 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control mb-1 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <!-- <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label> -->

                                    <div class="col-md-12">
                                        <input id="password-confirm" type="password" class="form-control mb-1" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                    </div>
                                </div>

                        {{-- @if(\App\SiteConstants::CAPTCHA_SITE_KEY)
                        <div class="form-group row">
                            <!-- <label for="captcha" class="col-md-4 col-form-label text-md-right">Captcha</label> -->

                            <div class="col-md-12">
                                <div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="{!! \App\SiteConstants::CAPTCHA_SITE_KEY !!}"></div>

                               @if ($errors->has('g-recaptcha-response'))
                                    <span class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif --}}
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn w-100 mb-3 signin-Button">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
