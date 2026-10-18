@extends('layouts.app')

@section('title', 'Login - Aplikasi Manajemen Inventaris')

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <h1>📦 Aplikasi Manajemen Inventaris</h1>
            <p>Silakan login untuk melanjutkan</p>
        </div>

        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                       value="{{ old('email') }}"
                       placeholder="masukkan email Anda" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password"
                       placeholder="masukkan password Anda" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
                🔐 Login
            </button>
        </form>

        <div class="demo-credentials">
            <strong>🔑 Akun Demo:</strong>
            Email: admin@inventaris.test<br>
            Password: password123
        </div>
    </div>
</div>
@endsection
