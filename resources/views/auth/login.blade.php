@extends('layouts.guest')

@section('title', 'Sign In - Todo List')
@section('subtitle', 'Enter your email and password to continue.')

@section('content')
    <h3 class="fw-bold mb-4 text-center" style="color: var(--text-dark);">Sign In</h3>

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label fw-medium text-secondary small">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required autofocus>
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
                       id="password" name="password" placeholder="Enter password" required>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label text-muted small" for="remember">Remember me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm">
            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
        </button>
    </form>

    <div class="text-center mt-4 pt-2 border-top">
        <p class="text-muted small mb-0">Don't have an account?
            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none" style="color: var(--primary-color);">Create one</a>
        </p>
    </div>
@endsection

