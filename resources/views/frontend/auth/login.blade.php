@extends('frontend.layout')

@section('title', __('تسجيل الدخول'))

@section('content')
    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <div class="register-form">
                        <div class="title">
                            <h3>{{ __('تسجيل الدخول') }}</h3>
                            <p>{{ __('يمكنك تسجيل الدخول باستخدام بريدك الإلكتروني وكلمة المرور.') }}</p>
                        </div>
                        <form class="row" method="post" action="{{route('login')}}">
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">{{ __('البريد الإلكتروني') }}</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror" 
                                           type="email" id="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password">{{ __('كلمة المرور') }}</label>
                                    <input name="password" class="form-control @error('password') is-invalid @enderror" 
                                           type="password" id="password" required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-group">
                                    <input class="form-check-input width-auto" type="checkbox" value="" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">{{ __('تذكرني') }}</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="button">
                                    <button class="btn" type="submit">{{ __('تسجيل الدخول') }}</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="outer-link">{{ __('ليس لديك حساب؟') }} <a href="{{route('register')}}">{{ __('إنشاء حساب جديد') }}</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->
@endsection