@extends('layouts.login_layout')

@section('content')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <img src="{{ asset('/assets/images/logo.svg') }}">
                        </div>
                        <h4>Hello! let's get started</h4>
                        <h6 class="font-weight-light">Sign in to continue.</h6>
                        <form class="pt-3" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <input 
                                type="email" 
                                class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="Email"
                                autocomplete="email" autofocus
                                >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mt-3 d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Keep me signed in 
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="#" class="auth-link text-primary">Forgot password?</a>
                                @endif
                            </div>

                            <div class="mb-2 d-grid gap-2">
                                <a href="{{ route('google-login-redirect') }}" class="btn btn-block btn-google auth-form-btn">
                                    <i class="mdi mdi-google me-2"></i>Using Google
                                </a>
                            </div>

                            {{-- <div class="text-center mt-4 font-weight-light"> 
                                Don't have an account? <a href="register.html" class="text-primary">Create</a>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection