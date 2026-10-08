@extends('layouts.app')

@section('title', 'Daftar')

@section('content')

<div class="auth-page -mx-4 sm:-mx-6 lg:-mx-8 -my-8 px-4 sm:px-6 lg:px-8 py-14 flex items-center justify-center">
    <div class="w-full max-w-md">

        <div class="text-center mb-7">
            <span class="inline-grid place-items-center w-12 h-12 rounded-md bg-soil-900 text-crop-300 font-display text-xl mb-4 border-2 border-crop-600 shadow-[0_3px_0_0_var(--color-crop-800)]" aria-hidden="true">✦</span>
            <h1 class="font-display text-2xl text-soil-800">Daftar akun baru</h1>
            <p class="text-sm text-soil-500 mt-2">Akun baru terdaftar dengan peran Staff.</p>
        </div>

        <div class="panel p-7">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label for="name" class="field-label">Nama</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name') }}"
                           class="field @error('name') field-invalid @enderror"
                           required autofocus autocomplete="name">
                    @error('name')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="email" class="field-label">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           class="field @error('email') field-invalid @enderror"
                           required autocomplete="username">
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="password" class="field-label">Password</label>
                    <input type="password" name="password" id="password"
                           class="field @error('password') field-invalid @enderror"
                           required autocomplete="new-password" minlength="6" aria-describedby="password-hint">
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                    <p id="password-hint" class="text-xs text-soil-400 mt-1.5">Minimal 6 karakter.</p>
                </div>

                <div class="mt-5">
                    <label for="password_confirmation" class="field-label">Konfirmasi password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="field"
                           required autocomplete="new-password">
                </div>

                <button type="submit" class="btn-primary w-full mt-7">Buat akun</button>
            </form>

            <p class="text-center text-sm text-soil-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-crop-700 hover:underline">Masuk</a>
            </p>
        </div>

    </div>
</div>

@endsection