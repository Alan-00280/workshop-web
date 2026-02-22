@extends('layouts.login_layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        
        <h4 class="text-center mb-3">Verify OTP</h4>
        <p class="text-center text-muted">Enter the OTP sent to your email.</p>

        {{-- Alert Message --}}
        <x-successAlert :message="session('success')" />
        @if(session('error'))
            <x-error-alert :errors="session('error')" type="global" />
        @endif
        <x-error-alert :errors="$errors" />

        {{-- Verify OTP Form --}}
        <form method="POST" action="/verify-otp">
            @csrf

            <div class="mb-3">
                <input 
                    type="text"
                    name="otp"
                    class="form-control text-center"
                    placeholder="Enter 6-digit OTP"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    maxlength="6"
                    required
                    autofocus>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">
                    Verify OTP
                </button>
            </div>

            <p>
                OTP sent to:

                <strong>{{ auth()->user()->email??'xxx@mail.com' }}</strong>
            </p>
        </form>

        {{-- <div class="text-center">
            <form method="POST" action="/resend-otp">
                @csrf
                <button type="submit" class="btn btn-link">
                    Resend OTP
                </button>
            </form>
        </div> --}}

    </div>
</div>
@endsection

