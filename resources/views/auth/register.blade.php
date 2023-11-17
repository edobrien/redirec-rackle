@extends('layouts.signup-app')
@section('content')
<div class="bg-signin">
    <div class="container d-flex w-100 h-100 p-3 mx-auto flex-column signIn">
        <div class="row pt-9">
            <div class="col-md-7 lh5 login-align">
                <h5 class="lh5 pb-3 ">Helping lawyers navigate their most successful, enjoyable and rewarding career path.</h5>

              
                <h5 class="lh5 pb-3">Thank you for registering to join the rackle. This is a site for qualified lawyers; our aim is to provide objective helpful information, advise and insights that will help you achieve the most successful and rewarding career that your hard work and talent deserve. </h5>
                <h5 class="lh5 pb-3">We ask for your work email address to verify that you are a qualified lawyer </h5>

                <a class="text-white" href="{{ route('login') }}">
                   <button type="button" class="btn btn-form br-40 px-5 mb-4">
                       Already have an account? <span class="text-white">Sign In</span>
                   </button>
               </a>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-9 offset-md-3">
                        <div class="row pt-5">
                            <!-- <div class="col-md-12 text-right">
                                <small><a class="text-white" href="{{ route('login') }}">SIGN IN</a></small>
                            </div> -->
                           
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="pt-5 text-white "><span>THE</span> <span class="text-blue">RACKLE</span></h4>
                                <h4 class="text-white py-2 lh5">{{ __('Please register to join rackle') }}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('register') }}" id="register">
                                    @csrf
                                    <div class="form-group">
                                        <input id="name" type="text" class="form-control mb-1 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="firm_name" type="text" class="form-control mb-1 @error('firm_name') is-invalid @enderror" name="firm_name" value="{{ old('firm_name') }}" required autocomplete="firm_name" autofocus placeholder="Firm">

                                        @error('firm_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="position" type="text" class="form-control mb-1 @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required autocomplete="position" autofocus placeholder="Position">

                                        @error('position')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control mb-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- <div class="form-group">
                                        <input id="contact_number" type="text" class="form-control mb-1 @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number" autofocus placeholder="Contact Number">

                                        @error('contact_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> -->
                                    <div class="form-group">
                                        <input id="password" type="password" class="form-control mb-1 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password-confirm" type="password" class="form-control mb-1" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group py-2">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input id="termsConditions" type="checkbox" class="custom-control-input form-control @error('accepted_terms') is-invalid @enderror" name="accepted_terms" value="YES" required autocomplete="accepted_terms" autofocus>
                                            <label class="custom-control-label text-signIn" for="termsConditions">
                                                <small>    
                                                    I accept <a href={{ url('terms') }} class="text-signIn" target="blank">Terms & Conditions</a>, 
                                                    <a href={{ url('privacy') }}  class="text-signIn" target="blank">Privacy Policy</a>
                                                </small>
                                            </label>
                                            @error('accepted_terms')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input id="privacyPolicy" type="checkbox" class="custom-control-input @error('privacy_policy') is-invalid @enderror" name="privacy_policy" value="YES" required autocomplete="privacy_policy" autofocus>
                                            <label class="custom-control-label text-signIn" for="privacyPolicy">
                                                <small>I accept <a href={{ url('privacy') }}  class="text-signIn" target="blank">Privacy Policy</a></small>
                                            </label>
                                            @error('privacy_policy')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> -->
                                    {{-- @if(\App\SiteConstants::CAPTCHA_SITE_KEY)
                                    <div class="form-group">
                                        <div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="{!! \App\SiteConstants::CAPTCHA_SITE_KEY !!}"></div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" style="display: block;">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    @endif --}}
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-primary w-100 signin-Button">
                                            {{ __('Join rackle') }}
                                        </button>
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
                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                            <i class="fa fa-twitter px-2" aria-hidden="true"></i>
                                            <i class="fa fa-facebook" aria-hidden="true"></i>
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
    <div id="register-done" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header border-0 rhead">
                    <h4 class="modal-title text-blue mb-0">Request Received</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid rounded">
                        <p>Many thanks for registering with the rackle.  The rackle is a site to help lawyers navigate a successful, enjoyable, and rewarding career path.  As such we restrict access to the site to practising lawyers.</p>
                        <p>If you have registered using your work email address, we will shortly email you to confirm approval and you will be able to access the site immediately.  If you have used a personal email address, we will contact you to verify your status prior to approving your registration.</p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-default btn-success br-40 px-4" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Based on Success, trigger the modal -->
@if(isset($success) && $success)
    <script>
        $(document).ready(function(){
            $('#register-done').modal('show');
        });
    </script>
@endif
<script type="text/javascript">
    $(document).ready(function(){
        $("#register").on("submit", function(){
            $(".bg_load").show();
        });
    });
</script>
@endsection