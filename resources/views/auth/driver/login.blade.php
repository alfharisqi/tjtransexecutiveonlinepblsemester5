@extends('layouts.front')

@section('front')
<style>
    .auth-container {
        min-height: 100vh;
        background: #f1f3f6;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .auth-card {
        display: flex;
        width: 800px;
        max-width: 100%;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    /* Bagian kiri */
    .auth-left {
        flex: 1;
        background: linear-gradient(to bottom, #5a9cf7, #6fd4ff);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #fff;
        padding: 40px;
        text-align: center;
    }

    .auth-logo {
        width: 100px;
        margin-bottom: 20px;
    }

    .auth-title {
        font-weight: bold;
        font-size: 1.5rem;
    }

    /* Bagian kanan */
    .auth-right {
        flex: 1;
        padding: 40px;
    }

    .auth-register {
        margin-bottom: 20px;
    }

    .auth-register a {
        color: #3b82f6;
        font-weight: 600;
        text-decoration: none;
    }

    .auth-register a:hover {
        text-decoration: underline;
    }

    .auth-input {
        border-radius: 8px;
        padding: 12px;
    }

    .auth-btn {
        border-radius: 8px;
        font-weight: 600;
    }

    .auth-forgot {
        color: #3b82f6;
        text-decoration: none;
    }

    .auth-forgot:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .auth-card {
            flex-direction: column;
        }
        .auth-left {
            padding: 30px 20px;
        }
        .auth-title {
            font-size: 1.2rem;
        }
        .auth-right {
            padding: 30px 20px;
        }
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        
        <!-- Bagian Kiri -->
        <div class="auth-left">
            <img src="{{ asset('images/tjulogo.png') }}" alt="Logo" class="auth-logo">
            <h3 class="auth-title">Login to Your<br>Account</h3>
        </div>
        
        <!-- Bagian Kanan -->
        <div class="auth-right">
            <p class="auth-register">
                Belum punya akun Driver? Hubungi Admin untuk melihat detail akun anda
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('driver.login.post') }}">
                @csrf
                <div class="mb-3">
                    <input type="text" name="username" 
                           class="form-control form-control-lg auth-input" 
                           value="{{ old('username') }}" 
                           placeholder="Username" required autofocus>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" 
                           class="form-control form-control-lg auth-input" 
                           placeholder="Password" required>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <input type="checkbox" name="remember" id="remember" class="me-2">
                    <label for="remember" class="mb-0">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 auth-btn">Login</button>
            </form>

            <div class="mt-3">
                <a href="{{ route('password.request') }}" class="auth-forgot">Forgot your password?</a>
            </div>
        </div>
    </div>
</div>
@endsection