@extends('frontend.layout')
@section('title', __('Register'))

@section('content')
    <!-- Start Account Register Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <div class="register-form">
                        <div class="title">
                            <h3>{{ __('No Account? Register') }}</h3>
                            <p>{{ __('Registration takes less than a minute but gives you full control over your orders.') }}</p>
                        </div>
                        <form class="row" method="post" action="{{route('register')}}">
                            @csrf
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-fn">{{ __('First Name') }}</label>
                                    <input name="first_name" class="form-control" type="text" id="reg-fn" required>
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-ln">{{ __('Last Name') }}</label>
                                    <input name="last_name" class="form-control" type="text" id="reg-ln" required>
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-email">{{ __('E-mail Address') }}</label>
                                    <input name="email" class="form-control" type="email" id="reg-email" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-phone">{{ __('Phone Number') }}</label>
                                    <input name="phone_number" class="form-control" type="text" id="reg-phone" required>
                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-pass">{{ __('Password') }}</label>
                                    <input name="password" class="form-control" type="password" id="reg-pass" required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-pass-confirm">{{ __('Confirm Password') }}</label>
                                    <input name="confirm-password" class="form-control" type="password" id="reg-pass-confirm" required>
                                    @error('confirm')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">{{ __('Register') }}</button>
                            </div>
                            <p class="outer-link">{{ __('Already have an account?') }} <a href="{{route('login')}}">{{ __('Login Now') }}</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Register Area -->

@endsection