@extends('layouts.app')

@section('title', 'Tambah Kredensial')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="page-title">Tambah Kredensial</h1>
        <p class="page-subtitle">Simpan satu peti kunci baru ke dalam gudang terenkripsi.</p>
    </div>

    <div class="mb-5 flex items-start gap-3 px-4 py-3 rounded-xl bg-ember-50 border border-ember-200">
        <span class="mt-0.5 shrink-0 text-ember-500" aria-hidden="true">⚿</span>
        <p class="text-sm text-ember-700">
            Username dan password akan dienkripsi dengan <strong>AES-256-GCM</strong> sebelum menyentuh database.
            Nilai yang Anda ketik tidak pernah disimpan dalam bentuk plaintext.
        </p>
    </div>

    <form method="POST" action="{{ route('vault.store') }}" class="panel p-6 space-y-5">
        @csrf

        <div>
            <label for="title" class="field-label">Judul</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="field @error('title') field-invalid @enderror" required>
            @error('title') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="category" class="field-label">Kategori</label>
                <select name="category" id="category" class="field" required>
                    @foreach(['Server', 'Database', 'Network', 'SaaS', 'ServiceAccount'] as $cat)
                        <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="host_or_url" class="field-label">Host / URL</label>
                <input type="text" name="host_or_url" id="host_or_url" value="{{ old('host_or_url') }}"
                       class="field font-mono text-xs" placeholder="https://…">
            </div>
        </div>

        <div class="pt-4 border-t border-soil-100 space-y-5">
            <div>
                <label for="username_encrypted" class="field-label">Username</label>
                <input type="text" name="username_encrypted" id="username_encrypted"
                       value="{{ old('username_encrypted') }}" class="field font-mono text-sm" required>
                @error('username_encrypted') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_encrypted" class="field-label">Password</label>
                <input type="text" name="password_encrypted" id="password_encrypted"
                       value="{{ old('password_encrypted') }}" class="field font-mono text-sm" required>
                @error('password_encrypted') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="additional_secret_encrypted" class="field-label">API Key / Secret tambahan</label>
                <input type="text" name="additional_secret_encrypted" id="additional_secret_encrypted"
                       value="{{ old('additional_secret_encrypted') }}" class="field font-mono text-sm">
            </div>

            <div>
                <label for="notes_encrypted" class="field-label">Catatan</label>
                <textarea name="notes_encrypted" id="notes_encrypted" rows="3"
                          class="field">{{ old('notes_encrypted') }}</textarea>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn-ember">Simpan Kredensial</button>
            <a href="{{ route('vault.index') }}" class="btn-quiet">Batal</a>
        </div>
    </form>
</div>

@endsection