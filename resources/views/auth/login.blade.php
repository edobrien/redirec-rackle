@extends('layouts.signup-app')
@section('content')
<div class="bg-signin">
    <div class="container d-flex w-100 h-100 p-3 mx-auto flex-column signIn">
        <div class="row" style="align-items: flex-start; display: flex; flex: 1;">
            <div class="col-md-7 lh5 login-align">
                <h5 class="lh5 pb-3 login-align">Helping lawyers navigate their most successful, enjoyable and rewarding career path.</h5>
                <a class="text-white" href="{{ route('register') }}">
                    <button type="button" class="btn btn-form br-40 px-5 mb-4">
                        <span class="text-white">Register here</span>
                    </button>
                </a>
            </div>
            <div class="col-md-5 lh5 login-align">
                <div class="row">
                    <div class="col-md-9 offset-md-3">       
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="pt-5 text-white "><span>THE</span> <span class="text-blue">RACKLE</span></h4>
                                <h4 class="text-white py-2 lh5">{{ __('Sign me in') }}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('login') }}" id="login">
                                    @csrf
                                    @if(count($errors))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control mb-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" class="form-control mb-1 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- @if(\App\SiteConstants::CAPTCHA_SITE_KEY)
                                    <div class="form-group py-2">
                                        <div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="{!! \App\SiteConstants::CAPTCHA_SITE_KEY !!}"></div>

                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" style="display: block;">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    @endif --}}
                                    <div class="form-group">
                                        <button type="submit" class="btn py-2 w-100 signin-Button">
                                            {{ __('Sign In') }}
                                        </button>
                                    </div>
                                    <div class="form-group pt-1">
                                        @if (Route::has('password.request'))
                                        <small>
                                            <a class="text-signIn" href="{{ route('password.request') }}">
                                                {{ __('Forgotten Password?') }}
                                            </a>
                                        </small>
                                        @endif
                                    </div>
                                
                                    <div class="row mb-0">
                                        <div class="col-12">
                                            <small>
                                                <a href="{{ url('/terms') }}" class="text-signIn">Terms & Conditions</a>
                                                <span class="text-signIn"> | </span>
                                                <a href="{{ url('/privacy') }}" class="text-signIn">Privacy Policy</a>
                                            </small>
                                        </div>
                                        <!-- <div class="col-5 text-right">
                                            <small>
                                                <a href="{{ url('/Register') }}" class="text-signIn">Sign Up?</a>
                                            </small>
                                        </div> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#register").on("submit", function(){
            $(".bg_load").show();
        });
    });
</script>
@endsection