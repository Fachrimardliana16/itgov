@extends('layouts.app')

@section('title', 'Masuk')

@section('content')

<div class="auth-page -mx-4 sm:-mx-6 lg:-mx-8 -my-8 px-4 sm:px-6 lg:px-8 py-14 flex items-center justify-center">
    <div class="w-full max-w-md">

        <div class="text-center mb-7">
            <span class="inline-grid place-items-center w-12 h-12 rounded-xl bg-soil-900 text-crop-300 font-display text-xl mb-4" aria-hidden="true">✦</span>
            <h1 class="font-display text-2xl text-soil-800">Masuk ke Governance Center</h1>
            <p class="text-sm text-soil-500 mt-2">Gunakan akun yang telah terdaftar untuk mengakses modul.</p>
        </div>

        <div class="panel p-7">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="field-label">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           class="field @error('email') field-invalid @enderror"
                           required autofocus autocomplete="username">
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="password" class="field-label">Password</label>
                    <input type="password" name="password" id="password"
                           class="field @error('password') field-invalid @enderror"
                           required autocomplete="current-password">
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full mt-7">Masuk</button>
            </form>

            <p class="text-center text-sm text-soil-500 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-crop-700 hover:underline">Daftar</a>
            </p>
        </div>

        <aside class="mt-6 panel px-5 py-4">
            <p class="text-[0.6875rem] font-semibold uppercase tracking-wider text-soil-500 mb-2">Akun demo</p>
            <dl class="space-y-1.5 text-sm">
                <div class="flex items-baseline gap-2">
                    <dt class="w-14 shrink-0 text-soil-500">Admin</dt>
                    <dd class="font-mono text-xs text-soil-700">admin@itgov.local / password123</dd>
                </div>
                <div class="flex items-baseline gap-2">
                    <dt class="w-14 shrink-0 text-soil-500">Staff</dt>
                    <dd class="font-mono text-xs text-soil-700">staff@itgov.local / password123</dd>
                </div>
            </dl>
        </aside>

    </div>
</div>

@endsection