@extends('layouts.guest')

@section('title', 'Create Account - Todo List')
@section('subtitle', 'Create your account to start adding tasks.')

@section('content')
    <h3 class="fw-bold mb-4 text-center" style="color: var(--text-dark);">Create Account</h3>

    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fw-medium text-secondary small">Full Name</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}" placeholder="Enter Your Name" required autofocus>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-medium text-secondary small">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-medium text-secondary small">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror"
                       id="password" name="password" placeholder="At least 8 characters" required>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-medium text-secondary small">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                <input type="password" class="form-control border-start-0"
                       id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm">
            <i class="bi bi-person-plus me-1"></i> Register
        </button>
    </form>

    <div class="text-center mt-4 pt-2 border-top">
        <p class="text-muted small mb-0">Already have an account?
            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color: var(--primary-color);">Sign in</a>
        </p>
    </div>
@endsection

